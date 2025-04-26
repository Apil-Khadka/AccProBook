DOCKERHUB_USER := apilk
IMAGE_NAME     := accprobook

DB_DOCKERFILE   := mariadb.Dockerfile
PHP_DOCKERFILE  := PHP.Dockerfile
NGINX_DOCKERFILE:= nginx.Dockerfile

DB_IMAGE    := $(DOCKERHUB_USER)/$(IMAGE_NAME):db
PHP_IMAGE   := $(DOCKERHUB_USER)/$(IMAGE_NAME):php
NGINX_IMAGE := $(DOCKERHUB_USER)/$(IMAGE_NAME):nginx

.PHONY: all build-db build-php build-nginx build push-db push-php push-nginx push clean

all: build

build: build-db build-php build-nginx

build-db:
	@echo "🔨 Building $(DB_IMAGE)"
	docker build -f $(DB_DOCKERFILE) -t $(DB_IMAGE) .
build-php:
	@echo "🔨 Building $(PHP_IMAGE)"
	docker build -f $(PHP_DOCKERFILE) -t $(PHP_IMAGE) .
build-nginx:
	@echo "🔨 Building $(NGINX_IMAGE)"
	docker build -f $(NGINX_DOCKERFILE) -t $(NGINX_IMAGE) .

push: push-db push-php push-nginx

push-db:
	@echo "Pushing $(DB_IMAGE)"
	docker push $(DB_IMAGE)
push-php:
	@echo "Pushing $(PHP_IMAGE)"
	docker push $(PHP_IMAGE)
push-nginx:
	@echo "Pushing $(NGINX_IMAGE)"
	docker push $(NGINX_IMAGE)

clean:
	@echo "🗑️ Removing images"
	-docker rmi $(DB_IMAGE) $(PHP_IMAGE) $(NGINX_IMAGE)

