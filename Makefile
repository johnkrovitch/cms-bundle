include etc/make/assets.mk
include etc/make/tests.mk

.PHONY: install composer.install

install: composer.install

composer.install:
	composer install
