.PHONY: check fix

check:
	php vendor/bin/phpstan analyse src --memory-limit 256M
	php vendor/bin/phpcs src

fix:
	php vendor/bin/phpcbf src
