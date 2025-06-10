.PHONY: check fix analyse

check:
	php vendor/bin/phpstan analyse src
	php vendor/bin/phpcs src

fix:
	php vendor/bin/phpcbf src
