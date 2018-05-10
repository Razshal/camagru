#!/bin/bash
mysql_password="jaimeles1576483bonnesmontagnesrectangulaires"
project_folder=$HOME/Projects/web/camagru

docker run -d -p 8888:3306 -e MYSQL_ROOT_PASSWORD=$mysql_password -e MYSQL_DATABASE=camagru --name mysql mysql:5.6
docker build -t phpapache . && docker run -d -p 80:80 -p 25:25 -v $project_folder:/var/www/html --name phpapache phpapache
