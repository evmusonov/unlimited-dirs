## Запуск
1. В корне проекта
```
docker build -t php8.0 .
```
2.
```
docker run --name php8.0 -it -d -v /path/to/unlimited-dirs/src:/src php8.0 bash
```
3.
```
docker exec -it php8.0 bash
```
4. Внутри контейнера
```
cd /src
```
```
php index.php
```
