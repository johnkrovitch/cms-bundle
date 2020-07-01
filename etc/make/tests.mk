.PHONY: tests.integration tests.phpunit phpunit.run

tests: phpunit.run php-cs-fixer.run phpstan.run

tests.integration:
	mkdir -p var/integration/
	cd var/integration/ && composer create-project symfony/website-skeleton:^4.4 media-bundle-test
	cd var/integration/media-bundle-test && ls

# PHPUnit
phpunit.run:
	bin/phpunit
	@echo "Results file generated file://$(shell pwd)/var/phpunit/coverage/index.html"

.PHONY: php-cs-fixer.install php-cs-fixer.run php-stan.run
# php-cs-fixer
php-cs-fixer.install:
	@echo "Install binary using composer (globally)"
	composer global require friendsofphp/php-cs-fixer
	@echo "Exporting composer binary path"
	@export PATH="$PATH:$HOME/.composer/vendor/bin"

php-cs-fixer.run:
	bin/php-cs-fixer fix

php-cs-fixer.ci:
	php-cs-fixer fix --dry-run --using-cache=no --verbose

# PHPStan
phpstan.run:
	bin/phpstan analyse --level=1 src tests

