#!/bin/bash
mysql_password="jaimeles1576483bonnesmontagnesrectangulaires"
project_folder=$HOME/Projects/web/camagru
machine_name="web"

if ! docker-machine ls -q | grep $machine_name
then
	docker-machine create --driver virtualbox $machine_name
fi

eval $(docker-machine env $machine_name)
docker run -dit -p 3306:3306 -e MYSQL_ROOT_PASSWORD=$mysql_password -e MYSQL_DATABASE=camagru --name mysql mysql:5.6
docker build -t phpapache .
docker run -d -p 80:80 -v $project_folder:/var/www/html --name phpapache phpapache
