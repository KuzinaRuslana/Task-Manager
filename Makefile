start:
	php artisan serve
install:
	composer install
lint:
	composer exec --verbose phpcs -- --standard=PSR12 app
test:
	php artisan test --testsuite=Feature

test-coverage:
	XDEBUG_MODE=coverage composer exec phpunit tests -- --coverage-clover=coverage/clover.xml

test-coverage-text:
	XDEBUG_MODE=coverage composer exec --verbose phpunit tests -- --coverage-text
