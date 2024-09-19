
migrate-dev: ## Run migrations and seeds
	clear && docker-compose -f ./docker/development/docker-compose.yml exec php bash -c "php artisan migrate && php artisan db:seed && php artisan route:clear"

build-dev: ## Build the development environment
	docker-compose -f ./docker/development/docker-compose.yml build

run-dev: ## Run the development environment
	docker-compose -f ./docker/development/docker-compose.yml up -d

stop-dev: ## Stop the development environment
	docker-compose -f ./docker/development/docker-compose.yml down

shell-container: ## Access bash in, php container but, use $(DOCKER_EXEC) r settings
	clear && docker-compose -f ./docker/development/docker-compose.yml exec php bash

help: ## This help.
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

.DEFAULT_GOAL := help
