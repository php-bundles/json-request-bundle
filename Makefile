clear-cache:
	rm -rf var

php-cs-fixer: clear-cache
	docker-compose run --rm -T php /usr/local/bin/php-cs-fixer fix --no-interaction --verbose --dry-run

phpunit: clear-cache
	docker-compose run --rm -T php /usr/local/bin/php /app/vendor/bin/phpunit

phpstan: clear-cache
	docker-compose run --rm -T php /usr/local/bin/php /app/vendor/bin/phpstan analyse

coverage: clear-cache
	docker-compose run --rm -T php /usr/local/bin/php /app/vendor/bin/phpunit --coverage-html=vendor/coverage

composer-update:
	docker-compose run --rm -T php /usr/local/bin/php /usr/local/bin/composer update
