#!/bin/bash

docker-compose up&
docker exec -it mysql bash -c "echo Europe/Paris > /etc/timezone"