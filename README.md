# Invertory app

# Development run

## Setup database
1. cd backend
2. copy .env.example to .env
1. Setup database in .env

## Setup backend
1. cd backend
2. composer install
3. php artisan key:generate
4. php artisan migrate
5. php artisan db:seed
6. php artisan serve

## Setup frontend
1. cd frontend
2. npm install
3. npm run serve
