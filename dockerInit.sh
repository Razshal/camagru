#!/bin/bash
mysql_password="j\'aimeles1576483bonnesmontagnesrectangulaires"
project_folder=$HOME/Projects/web/camagru
machine_name="web"

if ! docker-machine ls -q | grep $machine_name
then
	docker-machine create --driver virtualbox $machine_name
fi

eval $(docker-machine env $machine_name)
docker run -dit -p 8888:3306 -e MYSQL_ROOT_PASSWORD=$mysql_password --name mysql mysql
docker run -d -p 8100:80 -v $project_folder:/var/www/html --name phpapache php:apache
