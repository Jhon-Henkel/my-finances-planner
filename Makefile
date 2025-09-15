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

tail:
	@echo "Tailing logs..."
	tail -f -n 100 storage/logs/laravel.log

.PHONY: backend-bash frontend setup-frontend tail
