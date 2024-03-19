DOCKER_EXEC = docker-compose exec php
PHP_CS_FIXER = $(DOCKER_EXEC) vendor/bin/php-cs-fixer
PHPSTAN = $(DOCKER_EXEC) vendor/bin/phpstan
PHPCS = $(DOCKER_EXEC) vendor/bin/phpcs

ifdef level
	PHPSTAN_LEVEL = --level $(level)
endif

install: build composer-install

uninstall:
	docker-compose down

build: ## Build the container
	docker-compose build --pull

start: ## Start the project
	docker-compose up -d --force-recreate

stop: ## Stop the project
	docker-compose stop

shell: start ## Open shell in coding-standards container
	$(DOCKER_EXEC) sh

composer-install: start ## Run composer install
	$(DOCKER_EXEC) composer install --no-interaction

composer-update: start ## Run composer update
	$(DOCKER_EXEC) composer update $(args)

composer-require: start ## Run composer update
	$(DOCKER_EXEC) composer require $(args)

test: start ## Execute phpunit tests
	$(DOCKER_EXEC) vendor/bin/phpunit --configuration phpunit.xml

php-cs-fix: start ## Fix PHP code style
	$(PHP_CS_FIXER) fix --config=config/.php-cs-fixer.dist

php-cs-check: start ## Check PHP code style
	$(PHP_CS_FIXER) fix --config=config/.php-cs-fixer.dist --verbose --dry-run --using-cache=no --path-mode=intersection

phpstan: start ## Run PHPStan analysis
	$(PHPSTAN) analyse $(PHPSTAN_LEVEL)

phpcs:
	$(PHPCS) \
		-p \
		--warning-severity=0 \
		--ignore=vendor/,var/ \
		--bootstrap=config/.phpcs.dist \
		--standard=vendor/ubitransport/php-code-sniffs/src/Ubitransport/ruleset.xml \
		--report=ubitransport\\PhpCodeSniffs\\Reports\\Ubitransport \
		"."
