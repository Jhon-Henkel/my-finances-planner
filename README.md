## Setup
```bash
cp .env.example .env
cp resources/frontend-v2/.env.example resources/frontend-v2/.env
cp config/docker/develop/docker-compose.yml docker-compose.yml
docker compose up -d
make backend-bash
composer update
php artisan key:generate  
php artisan setup:develop
exit
make setup-frontend
make frontend
```
