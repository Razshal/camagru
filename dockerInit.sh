#!/bin/bash
my_sql_password="j'aimeles1576483bonnesmontagnesrectangulaires"
project_folder=$HOME/Projects/web/camagru

eval $(docker-machine env web)
docker run -dit -p 8888:3306 -e MYSQL_ROOT_PASSWORD=$my_sql_password --name mysql mysql
docker run -d -p 8100:80 -v $project_folder:/var/www/html --name phpapache php:apache
