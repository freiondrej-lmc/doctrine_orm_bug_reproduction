# Parts come from ./docs/Makefile.md
# Executables (local)
DOCKER_COMP = docker-compose

# Docker containers
PHP_CONT = $(DOCKER_COMP) exec php

# Executables
PHP      = $(PHP_CONT) php
COMPOSER = $(PHP_CONT) composer
SYMFONY  = $(PHP_CONT) bin/console

dev-start:
	#docker-compose -f docker-compose.yml -f docker-compose.debug.yml --env-file docker/.env.local up -d
	docker-compose -f docker-compose.yml -f docker-compose.override.yml up -d

dev-build:
	#docker-compose -f docker-compose.yml -f docker-compose.debug.yml --env-file docker/.env.local up -d --build
	#docker-compose -f docker-compose.yml -f docker-compose.override.yml --env-file docker/.env.local up -d --build
	docker-compose -f docker-compose.yml -f docker-compose.override.yml build --no-cache

dev-stop:
	#docker-compose -f docker-compose.yml -f docker-compose.debug.yml down
	docker-compose -f docker-compose.yml -f docker-compose.override.yml down

sh: ## Connect to the PHP FPM container
	@$(PHP_CONT) sh

## —— Symfony 🎵 ———————————————————————————————————————————————————————————————
sf: ## List all Symfony commands or pass the parameter "c=" to run a given command, example: make sf c=about
	@$(eval c ?=)
	@$(SYMFONY) $(c)

cc: c=c:c ## Clear the cache
cc: sf

# catch all target (%) which does nothing to silently ignore the other goals.
%:
	@true
