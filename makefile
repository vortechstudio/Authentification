.PHONY: deploy install

deploy:
	cd /www/wwwroot/auth.vortechstudio.fr/ && git pull origin master && make install

install: vendor/autoload.php .env public/storage public/build/manifest.json
	php artisan migrate --seed --force
	php artisan optimize:clear
	php artisan cache:clear
	php artisan route:clear
	php artisan view:clear

.env:
	cp .env.example .env
	php artisan key:generate

public/storage:
	php artisan storage:link
	chmod -R 777 storage/ bootstrap/cache/

vendor/autoload.php: composer.lock
	composer install --ignore-platform-reqs --no-interaction --prefer-dist
	touch vendor/autoload.php

public/build/manifest.json: package.json
	npm i
	npm run build

testing:
	php artisan migrate:fresh
	php artisan db:seed --class=InstallSeeder
	php artisan db:seed --class=TestSeeder
