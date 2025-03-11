start:
	php artisan serve
install:
	composer install
lint:
	composer exec --verbose phpcs -- --standard=PSR12 app
test:
	php artisan test --testsuite=Feature
