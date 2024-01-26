start:
	@echo "Starting container..."
	docker compose start

stop:
	@echo "Stopping container..."
	docker compose stop

restart:
	@echo "Restarting container..."
	docker compose restart

bash:
	@echo "Starting bash..."
	docker exec -it my_finances_planner_app bash

.PHONY: start stop restart bash