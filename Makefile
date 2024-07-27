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
	docker exec -it my_finances_planner_app bash

frontend:
	@echo "Starting front v2..."
	cd resources/frontend-v2 && npm run dev

setup-frontend:
	@echo "Setting up..."
	cd resources/frontend-v2 && npm install && npm update
	@echo "Run 'cd resources/frontend-v2 && make frontend' to start the frontend. To access the frontend, go to http://localhost/login"

.PHONY: backend-start backend-stop backend-restart backend-bash front-dev setup-frontend