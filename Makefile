backend-start:
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

front-v1-dev:
	@echo "Starting front v1..."
	npm run dev

front-v2-dev:
	@echo "Starting front v2..."
	cd resources/frontend-v2 && ionic serve

.PHONY: backend-start backend-stop backend-restart backend-bash front-v1-dev front-v2-dev