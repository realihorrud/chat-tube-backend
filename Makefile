-include .env
export $(shell sed 's/=.*//' .env)

dc := docker compose -f compose.yml

.PHONY: config
config: ## Create application configs
	@printf "$$BGreen Create application configs $$ColorOff \n"
	cp ./.env.example ./.env
	@printf "$$BRed Done! $$ColorOff \n"

.PHONY: build
build: ## Build containers
	@printf "$$BGreen Build containers (time for a coffee break ☕ !) $$ColorOff \n"
	$(dc) build

.PHONY: up
up: ## Start application
	$(dc) up -d

.PHONY: down
down: ## Stop application
	$(dc) down

.PHONY: restart
restart: ## Restart application
	$(dc) down && $(dc) up -d

.PHONY: app-console
app-console: ## CONSOLE: Enter into app container
	$(dc) exec -it app bash

.PHONY: dm
dm: ## Drop merged branches, use it wisely!
	git checkout main && git branch --merged | grep -v \* | xargs git branch -D

.PHONY: composer-test
composer-test: ## Run composer test in container
	$(dc) exec -it app sh -c "composer test"

.DEFAULT_GOAL := help
.PHONY: help
help: ## Display help
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' Makefile | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'
