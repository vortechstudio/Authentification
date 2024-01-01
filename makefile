.PHONY: testing

testing:
	php artisan migrate:fresh --seed --force
	php artisan db:seed --class=TestSeeder --force
