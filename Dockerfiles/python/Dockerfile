FROM python:3.7.6-buster

RUN pip3 install virtualenv
RUN pip3 install flask
RUN pip3 install pandas
RUN pip3 install numpy
RUN pip3 install tqdm
RUN pip3 install catboost
RUN pip3 install scikit-learn

WORKDIR /app/python
ENTRYPOINT ["python"]
CMD ["main.py"]