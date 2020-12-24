phpunit:
	docker-compose run --rm -T php /usr/local/bin/php /app/vendor/bin/phpunit

phpstan:
	docker-compose run --rm -T php /usr/local/bin/php /app/vendor/bin/phpstan analyse

coverage:
	docker-compose run --rm -T php /usr/local/bin/php /app/vendor/bin/phpunit --coverage-html=vendor/coverage

composer-update:
	docker-compose run --rm -T php /usr/local/bin/php /usr/local/bin/composer update
