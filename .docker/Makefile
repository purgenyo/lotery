composer-require:
	docker-compose run --rm api composer require $(p)

composer-require-dev:
	docker-compose run --rm api composer require --dev $(p)

composer-install:
	docker-compose run --rm api composer install -n

dump-autoload:
	docker-compose run --rm api composer dump-autoload --optimize --classmap-authoritative

lint:
	docker-compose run --rm api composer lint
	docker-compose run --rm api composer psalm
	docker-compose run --rm api composer php-cs-fixer fix -- --dry-run --diff

cs-fix:
	docker-compose run --rm api composer php-cs-fixer fix

analyze:
	docker-compose run --rm api composer psalm -- --no-diff

test-coverage:
	docker-compose run --rm api composer test-coverage

init: docker-down-clear \
	clear \
	docker-build docker-up \
	permissions \
	composer-install \
	dump-autoload

docker-down-clear:
	docker-compose down -v --remove-orphans

clear:
	docker run --rm -v ${PWD}/../api:/app -w /app alpine sh -c 'rm -rf var/cache/* var/test/*'

docker-build:
	docker-compose build --no-cache

docker-up:
	docker-compose up -d

permissions:
	docker run --rm -v ${PWD}/../api:/app -w /app alpine chmod 777 var/cache var/test

test-ab:
	docker-compose run --rm ab -k -c 1500 -n 10000 http://lotery-nginx/

migrate:
	docker-compose run --rm api vendor/bin/doctrine-migrations migrations:migrate --allow-no-migration --no-interaction

migrate-diff:
	docker-compose run --rm api vendor/bin/doctrine-migrations migrations:diff