PROJECT_NAME := 'To-Do Planning'
DOCKER_COMPOSE_FILE := $(shell pwd)/docker-compose.yml
ACTIVE_BRANCH := $(shell (git branch |grep '*'|tr -d '*'|tr -d ' '))
WEB_SERVICE := 'nginx'
PHP_SERVICE := 'php'
NODE_SERVICE := 'node'

start:
	docker-compose -f $(DOCKER_COMPOSE_FILE) up -d

rebuild-php:
	docker-compose build $(PHP_SERVICE)

stop:
	docker-compose stop

restart: stop start

install: install-backend database-initials install-frontend

install-demo: install install-demo-data

reinstall: reset-database install

install-backend:
	docker-compose -f $(DOCKER_COMPOSE_FILE) run --rm $(PHP_SERVICE) composer install -d /app


install-demo-data:
	docker-compose -f $(DOCKER_COMPOSE_FILE) run --rm $(PHP_SERVICE) /app/bin/console doctrine:fixtures:load -n
	docker-compose -f $(DOCKER_COMPOSE_FILE) run --rm $(PHP_SERVICE) /app/bin/console app:fetch:provider provider1 provider2
	docker-compose -f $(DOCKER_COMPOSE_FILE) run --rm $(PHP_SERVICE) /app/bin/console app:task:assignee

reset-database:
	docker-compose -f $(DOCKER_COMPOSE_FILE) run --rm $(PHP_SERVICE) /app/bin/console doctrine:database:drop --force
	docker-compose -f $(DOCKER_COMPOSE_FILE) run --rm $(PHP_SERVICE) /app/bin/console doctrine:database:create

database-initials:
	docker-compose -f $(DOCKER_COMPOSE_FILE) run --rm $(PHP_SERVICE) /app/bin/console doctrine:migration:migrate -n


install-frontend:
	docker-compose -f $(DOCKER_COMPOSE_FILE) run --rm $(NODE_SERVICE) yarn install --cwd /app
	docker-compose -f $(DOCKER_COMPOSE_FILE) run --rm $(NODE_SERVICE) yarn build --cwd /app
	docker-compose -f $(DOCKER_COMPOSE_FILE) run --rm $(PHP_SERVICE) /app/bin/console assets:install --symlink

ui-dev:
	docker-compose -f $(DOCKER_COMPOSE_FILE) run --rm $(NODE_SERVICE) yarn encore dev --watch --cwd /app

web-shell:
	docker-compose -f $(DOCKER_COMPOSE_FILE) exec $(PHP_SERVICE) bash

node-shell:
	docker-compose -f $(DOCKER_COMPOSE_FILE) run --rm $(NODE_SERVICE) bash

logs:
	docker-compose -f $(DOCKER_COMPOSE_FILE) logs -f $(PHP_SERVICE)

data-reset: reset-database database-initials

pull:
	git pull origin $(ACTIVE_BRANCH)

update: pull reinstall
