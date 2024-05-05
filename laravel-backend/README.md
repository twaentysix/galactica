# Galactica - Backend

## Requirements
- PHP v8.3 (min. 8.0)
- Composer
- docker && docker compose
- (optional) DevScriptRunner (shorthand for all different docker commands / seeds / migrate etc.):
    - [DevScriptRunner](https://github.com/sandstorm/dev-script-runner)

## Initial setup
- convert **.env.example** into **.env** file and adjust values (for local dev purpose you nothing has to be changed)

### With DevScriptRunner
- run `dev setup-backend`
- run `dev start-backend`
- run `dev migrate`
- run `dev seed`

### Without DevScriptRunner
**in laravel-backend directory**
- run `composer install`
- run `./vendor/bin/sail build --no-cache`
- run `./vendor/bin/sail up -d`
- run `./vendor/bin/sail artisan migrate` --> create database schema
- run `./vendor/bin/sail artisan db:seed` --> seed database for test data

## Starting Project (local development Server)
### With DevScriptRunner
- run `dev start-backend`

### Without DevScriptRunner
- (in laravel-backend directory) run `docker compose up -d` or `./vendor/bin/sail up -d`



