USER = 1000

DOCKER_EXEC = docker-compose exec -u $(USER) php
PHP_CS_FIXER = $(DOCKER_EXEC) vendor/bin/php-cs-fixer
PHPSTAN = $(DOCKER_EXEC) vendor/bin/phpstan
PHP = $(DOCKER_EXEC) php

.DEFAULT_GOAL := help

ifdef level
	PHPSTAN_LEVEL = --level $(level)
endif

help:
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' Makefile | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

start: ## Start the project
	docker-compose up -d

stop: ## Stop the project
	docker-compose stop

build: ## Build the container
	docker-compose build

composer-update: start ## Run composer update
	$(PHP) -d memory_limit=-1 /usr/local/bin/composer update --no-cache $(args)

composer-install: start ## Run composer install
	$(PHP) -d memory_limit=-1 /usr/local/bin/composer install --no-interaction --no-cache

shell: start ## Open shell in coding-standards container
	$(DOCKER_EXEC) sh

test: start ## Execute phpunit tests
	$(DOCKER_EXEC) vendor/bin/phpunit --configuration phpunit.xml

php-cs-fix: start ## Fix PHP code style
	$(PHP_CS_FIXER) fix --config=.php-cs-fixer.dist

php-cs-check: start ## Check PHP code style
	$(PHP_CS_FIXER) fix --config=.php-cs-fixer.dist --verbose --dry-run --using-cache=no --path-mode=intersection

phpstan: start ## Run PHPStan analysis
	$(PHPSTAN) analyse $(PHPSTAN_LEVEL)

.PHONY: help start stop build composer-update composer-install shell test php-cs-fix php-cs-check phpstan
