#!/bin/bash

# Stop execution if a step fails
set -e

DOCKER_USERNAME=lbaw2053 # Replace by your docker hub username
IMAGE_NAME=lbaw2053-piu

docker run -it -p 8000:80 -v $PWD:/var/www/html $DOCKER_USERNAME/$IMAGE_NAME