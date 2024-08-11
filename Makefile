backend:
	@echo "Starting container..."
	docker compose start

backend-stop:
	@echo "Stopping container..."
	docker compose stop

backend-restart:
	@echo "Restarting container..."
	docker compose restart

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

.PHONY: backend-start backend-stop backend-restart backend-bash front-dev setup-frontend rebuild-container
