backend:
	@echo "Starting container..."
	docker compose start

backend-stop:
	@echo "Stopping container..."
	docker compose stop

backend-bash:
	@echo "Starting bash..."
	docker compose start && docker exec -it mfp_app bash

frontend:
	@echo "Starting front v2..."
	cd resources/frontend-v2 && npm run dev

setup-frontend:
	@echo "Setting up..."
	cd resources/frontend-v2 && npm install && npm update
	@echo "Run 'make frontend' to start the frontend. To access the frontend, go to http://localhost/login"

rebuild-container $(container):
	@echo "Rebuilding container..."
	docker compose stop $(container) && docker compose rm -f $(container) && docker compose build $(container) && docker compose up -d $(container)

create-production-queue-vhost $(username):
	@echo "Creating production queue vhost..."
	docker exec mfp_rabbitmq /bin/bash -c "rabbitmqctl add_vhost production" && \
	docker exec mfp_rabbitmq /bin/bash -c "rabbitmqctl delete_vhost /" && \
	docker exec mfp_rabbitmq /bin/bash -c "rabbitmqctl set_permissions -p production $(username) \".*\" \".*\" \".*\""

tail:
	@echo "Tailing logs..."
	tail -f -n 100 storage/logs/laravel.log

.PHONY: backend-start backend-stop backend-bash front-dev setup-frontend rebuild-container create-production-queue-vhost tail
