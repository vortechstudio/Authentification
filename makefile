.PHONY: testing

testing:
	php artisan migrate:fresh --seed --force
	php artisan db:seed --class=TestSeeder --force

test:
	php artisan test

testcover:
	./vendor/bin/phpunit --coverage-html ./public/coverage --coverage-clover coverage.xml
	codecov --token=61e7cadc-db08-46fb-a8c5-0d83ab9720f7 -f coverage.xml
