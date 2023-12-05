.PHONY: deploy install

deploy:
	cd /home/admin/domains/auth.vortechstudio.fr/public_html && git pull origin master && make install

install: vendor/autoload.php .env public/storage public/build/manifest.json
	php artisan cache:clear
	php artisan migrate --seed --force
	php artisan optimize:clear

.env:
	cp .env.example .env
	php artisan key:generate

public/storage:
	php artisan storage:link

vendor/autoload.php: composer.lock
	composer install --ignore-platform-reqs --no-interaction --prefer-dist
	touch vendor/autoload.php

public/build/manifest.json: package.json
	npm i
	npm run build
