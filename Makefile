build:
	docker compose build --no-cache --force-rm

stop:
	docker compose stop

down:
	docker compose down

up:
	docker compose up -d

composer-update:
	docker exec ballast-php bash -c "composer update"

composer-install:
	docker exec ballast-php bash -c "composer install"

migrate:
	docker exec ballast-php bash -c "php artisan migrate"