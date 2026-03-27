.PHONY: up down build logs seed lint test console migrate fresh

up:
	cd docker && docker compose up -d --build

down:
	cd docker && docker compose down

build:
	cd docker && docker compose build --no-cache

logs:
	cd docker && docker compose logs -f

seed:
	cd docker && docker compose exec backend php artisan db:seed

lint:
	cd docker && docker compose exec backend ./vendor/bin/pint --test
	cd docker && docker compose exec vite npm run lint
	cd docker && docker compose exec vite npm run format:check

lint-fix:
	cd docker && docker compose exec backend ./vendor/bin/pint
	cd docker && docker compose exec vite npm run lint:fix
	cd docker && docker compose exec vite npm run format

test:
	cd docker && docker compose exec -e APP_ENV=testing backend php artisan test --parallel

coverage:
	cd docker && docker compose exec -e APP_ENV=testing backend php artisan test --coverage --min=80

console:
	cd docker && docker compose exec backend php artisan tinker

migrate:
	cd docker && docker compose exec backend php artisan migrate

fresh:
	cd docker && docker compose exec backend php artisan migrate:fresh --seed

shell:
	cd docker && docker compose exec backend sh
