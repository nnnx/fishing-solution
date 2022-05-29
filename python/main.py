import sys
import os
import pandas as pd
import numpy as np
import random
from tqdm import tqdm
from catboost import CatBoostClassifier
from sklearn.model_selection import train_test_split
from sklearn.cluster import AgglomerativeClustering
from sklearn.metrics import silhouette_score
from flask import Flask

global PATH1, PATH2, OUTPUT_PATH, top_fishes

PATH1 = './../web/uploads/db1/'
PATH2 = './../web/uploads/db2/'
OUTPUT_PATH = './results/'

app = Flask(__name__)

@app.route('/')
def hello():
    def cluster_definer(X):
        """Find optimal qty of clusters"""
        best_nr = 3
        best_sl = 0
        for i in range(3,8):
            clusterer = AgglomerativeClustering(n_clusters = i)
            cluster_labels = clusterer.fit_predict(X)
            silhouette = silhouette_score(X, cluster_labels)
            if silhouette > best_sl:
                best_sl = silhouette
                best_nr = i
        return AgglomerativeClustering(n_clusters = best_nr).fit_predict(X)

    def doubles_shrinker(df):
        """ Drops rows with doubled 'id_vsd' """
        dft = df.copy()
        dft['uniq_vsd'] = dft.groupby('id_vsd')['id_vsd'].transform('count').values
        if 'id_fish' in dft.columns:
            dft['col_checker'] = dft['id_fish'] == -1
        else:
            dft['col_checker'] = dft['id_own'] == -1
        dft = dft[lambda x: ~((x['col_checker'] == True) & (x['uniq_vsd'] > 1))].copy()
        return dft.drop(columns=['uniq_vsd', 'col_checker'])

    def unit_definer(df, train = True, path = './models/', model_name = 'cb_unit_definer'):
        dft = df[['fish_name', 'volume','unit']].copy()
        if train:
            X_train = dft[lambda x: x['unit'] != '\\N'][['fish_name', 'volume']]
            y_train = dft[lambda x: x['unit'] != '\\N']['unit']

            X_test = dft[lambda x: x['unit'] == '\\N'][['fish_name', 'volume']]

            X_train, X_val, y_train, y_val = train_test_split(X_train, y_train, test_size = 0.25, stratify = y_train)

            cat_features  = ['fish_name']
            cb = CatBoostClassifier(iterations = 300)
            cb.fit(X_train, y_train, eval_set = (X_val, y_val), early_stopping_rounds = 10, cat_features = cat_features, verbose = 100)
            cb.save_model(path + model_name)
        else:
            cb = CatBoostClassifier()
            cb.load_model(path + model_name)
        return cb.predict(dft[['fish_name', 'volume']])

    TOP_N_FISHES = 15
    def catch_loader(TOP_N_FISHES = 15):
        catch = pd.read_csv(PATH1 + 'catch.csv')
        fish  =  pd.read_csv(PATH1 + 'ref/' + 'fish.csv',sep = ';')
        catch = catch.merge(fish, how = 'left', on = 'id_fish')

        catch['fish_name'] = catch['fish'].str.split('[- ]').apply(lambda x: x[0])
        catch['date'] = pd.to_datetime(catch['date'])
        top_fishes = catch.groupby('fish_name')['catch_volume'].sum()\
        .sort_values(ascending = False)[:TOP_N_FISHES].index.to_list()
        return catch, top_fishes

    def ext2_loader():
        def fish_namer(x, fish_names = top_fishes):
            """ seeks fish name in second db and assign name from top names"""
            for i in fish_names:
                if i[:-1] in x:
                    return i
            return x

        ext2 = pd.read_csv(PATH2 + 'Ext2.csv')
        ext2['date'] = pd.to_datetime(ext2['date_vsd'].apply(lambda x: x[:10]))
        ext2['fish_name'] = ext2['fish'].apply(fish_namer)
        ext2['new_unit'] = unit_definer(ext2, train = False)
        ext2['volume_tons'] = np.where(ext2['new_unit'] == 'тонна', ext2['volume'], ext2['volume']/1000)
        return ext2


    def ext_loader(ext2):
        ext1 = pd.read_csv(PATH2 + 'Ext.csv')[['id_ves', 'id_own','date_fishery','id_vsd','id_Plat']]
        ext1['date_fishery'] = pd.to_datetime(ext1['date_fishery'].apply(lambda x: x[:10]))
        ext1 = doubles_shrinker(ext1)
        ext2 = doubles_shrinker(ext2)
        ext = ext1.merge(ext2, on = 'id_vsd', how = 'outer')
        ext = ext[~ext['id_Plat'].isna()] # drop 1400 rows
        ext['id_own'] = ext['id_own'].astype(int)
        return ext
    # ---------------------------------------------------------------------------------------------------------------
    def fish_anomalies_detector(catch, ext2,  window = 5, output_path = OUTPUT_PATH, filename = 'fish_anomaly.csv'):
        # -----------------------------------------------------
     # names of top N fishes
        tmp = catch[catch['fish_name'].isin(top_fishes)][['date', 'catch_volume','fish_name']]
        catch_roll_mean = tmp.groupby(['date', 'fish_name'])['catch_volume'].sum().unstack().fillna(0)\
        .rolling(window, center = True).mean()

        # -----------------------------------------------------



        ext = ext2[ext2['fish_name'].isin(top_fishes)][['date', 'volume_tons','fish_name']]
        tmp_ext = ext.groupby(['date', 'fish_name'])['volume_tons'].sum().unstack().fillna(0)\
        .rolling(window, center = True).mean()

        list_df = []
        for fish_name in top_fishes:
            anom_df = catch_roll_mean[fish_name].rename('db1').to_frame()\
            .merge(tmp_ext[fish_name].rename('db2').to_frame(), left_index = True, right_index = True, how = 'left')\
            .assign(diff_db1_db2 = lambda x: np.abs(x.iloc[:,0] - x.iloc[:,1])).dropna().astype(int)\
            .assign(fish_name = fish_name)\
            .assign(cluster_nr = lambda x: cluster_definer(x[['diff_db1_db2']]))\
            .assign(mean_error = lambda x: x.groupby('cluster_nr')['diff_db1_db2'].transform('mean').astype(int))\
            .assign(cluster_nr = lambda x: x['mean_error'].rank(method='dense', ascending  = False))
            list_df.append(anom_df)
        result = pd.concat(list_df).drop_duplicates()
        result.to_csv(OUTPUT_PATH + filename)
        return result


    def id_owner_anomalies_detector(catch, ext, window = 5, output_path = OUTPUT_PATH, filename = 'id_owner_anomaly.csv'):
        """ Based on 'id_owners' in db1 compares catch in second db"""
        owners = catch.id_own.unique()
        db1_data = catch.groupby(['date','id_own'])['catch_volume'].sum().rename('db1').astype(int).unstack().fillna(0)\
        .rolling(5, center = True).sum().dropna()
        db2_data = ext[lambda x: x['id_own'].isin(owners)].dropna().groupby(['date','id_own'])['volume_tons'].sum().rename('db2').astype(int).unstack().fillna(0)\
        .rolling(5, center = True).sum().dropna()



        tmp_list = []
        for i in tqdm(db1_data.columns):
            if i not in db2_data.columns:
                db2_data[i] = 0
            tmp = db1_data[i].rename('db1').to_frame()\
            .merge(db2_data[i].rename('db2'), left_index = True, right_index = True, how = 'left')\
            .assign(diff_db1_db2 = lambda x: np.abs(x.iloc[:,0] - x.iloc[:,1])).dropna().round(1)\
            .assign(id_own = i)\
            .assign(cluster_nr = lambda x: cluster_definer(x[['diff_db1_db2']]))\
            .assign(mean_error = lambda x: x.groupby('cluster_nr')['diff_db1_db2'].transform('mean').astype(int))\
            .assign(cluster_nr = lambda x: x['mean_error'].rank(method='dense', ascending  = False))
            tmp_list.append(tmp)
        result = pd.concat(tmp_list)
        result.to_csv(OUTPUT_PATH + filename)
        return result

    def per_row_anomalies_detector(catch, ext, output_path = OUTPUT_PATH, filename = 'per_row_anomaly.csv'):
        catch_max_row = catch.copy()
        catch_max_row['db1'] = catch_max_row.groupby('date')['catch_volume'].transform('max')
        catch_max_row = catch_max_row[lambda x: x['db1'] == x['catch_volume']][['date', 'id_ves', 'id_own','fish', 'catch_volume']].copy()
        catch_max_row.set_index('date', inplace = True)
        catch_max_row.columns = ['db1_' + x for x in catch_max_row.columns]

        ext_max_row = ext.copy()
        ext_max_row['max_vol_per_day'] = ext_max_row.groupby('date')['volume_tons'].transform('max')
        ext_max_row = ext_max_row[lambda x: x['max_vol_per_day'] == x['volume_tons']][['date', 'id_ves','id_own','fish','max_vol_per_day']].set_index('date')
        ext_max_row.columns = ['db2_' + x for x in ext_max_row.columns]

        result = catch_max_row.merge(ext_max_row, left_index = True, right_index = True)\
        .assign(diff_db1_db2 = lambda x: np.abs(x['db1_catch_volume'] - x['db2_max_vol_per_day'])).dropna().round(1)\
                .assign(cluster_nr = lambda x: cluster_definer(x[['diff_db1_db2']]))\
                .assign(mean_error = lambda x: x.groupby('cluster_nr')['diff_db1_db2'].transform('mean').astype(int))\
                .assign(cluster_nr = lambda x: x['mean_error'].rank(method='dense', ascending  = False))
        result.to_csv(OUTPUT_PATH + filename)
        return result

    if __name__ == '__main__':
        catch, top_fishes = catch_loader()
        ext2 = ext2_loader()
        ext = ext_loader(ext2)

        fa = fish_anomalies_detector(catch, ext2, window = 5)
        id_a = id_owner_anomalies_detector(catch, ext)
        pr_a = per_row_anomalies_detector(catch, ext)
    return '1'

if __name__ == '__main__':
    app.run(debug=True,host='0.0.0.0')
