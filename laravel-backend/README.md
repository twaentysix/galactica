# Galactica

## Requirements
- php
- composer
- docker && docker compose

## Laravel initial setup
- convert **.env.example** into **.env** file and adjust values
- run `composer install`
- run `./vendor/bin/sail up -d`
- run `./vendor/bin/sail artisan migrate` --> create database schema
- run `./vendor/bin/sail artisan db:seed` --> seed database for test data

## Starting Project after setup
- run `docker compose up-d`



