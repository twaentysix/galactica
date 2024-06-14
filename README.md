# Galactica

## Requirements

### Backend (./laravel-backend)
- PHP v8.3 (min. 8.0)
- Composer 
- docker && docker compose
- DevScriptRunner (shorthand for all different docker commands / seeds / migrate etc.):
  - [DevScriptRunner](https://github.com/sandstorm/dev-script-runner)
- further instructions see [Laravel Backend ReadMe](./laravel-backend/README.md)

### Frontend (./frontend)
- NPM (Version >=10.5.1)
- Node (Version>= 22)

## Initial Project setup
- in laravel-backend directory:
  - convert **.env.example** into **.env** file and adjust values (for local dev purpose you nothing has to be changed)

### With DevScriptRunner
- run `dev setup`
- run `dev start`
- run `dev migrate`
- run `dev seed`

### Without DevScriptRunner
**in laravel-backend directory**
- run `composer install`
- run `./vendor/bin/sail build --no-cache`
- run `./vendor/bin/sail up -d`
- run `./vendor/bin/sail artisan migrate` --> create database schema
- run `./vendor/bin/sail artisan db:seed` --> seed database for test data

**in frontend directory**
- run `npm install`

## Start Project (local development Server)
### With DevScriptRunner
- run `dev start`

### Without DevScriptRunner
**in laravel-backend directory**
- run `docker compose up -d` or `./vendor/bin/sail up -d`

**in frontend directory**
- run `npm run dev`

## Deployment

* AppServiceProvider needs in boot function: `URL::forceScheme('https')`;

* run command in case anything breaks: `php artisan vendor:publish --force --tag=livewire:assets`