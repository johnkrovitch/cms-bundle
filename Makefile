include etc/make/tests.mk

.PHONY: install composer.install

install: composer.install

composer.install:
	composer install
