# Кейс Росрыболовства

Для запуска проекта требуется Docker
https://www.docker.com/get-started/

##Команды для разворачивания:

### Build docker images

```
$ docker-compose build
```

### Run containers

```
$ docker-compose up -d
```

### Install Composer dependencies

```
$ docker-compose exec app composer install
```

### Apply DB migrations

```
$ docker-compose exec app php yii migrate --interactive=0
```

### Access to web

```
http://localhost:80/
```

### Импорт результатов

```
docker-compose exec app php yii task/import-results
```