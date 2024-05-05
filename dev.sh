#!/bin/bash

    ############################## DEV_SCRIPT_MARKER ##############################
    # This script is used to document and run recurring tasks in development.     #
    #                                                                             #
    # You can run your tasks using the script `./dev some-task`.                  #
    # You can install the Sandstorm Dev Script Runner and run your tasks from any #
    # nested folder using `dev some-task`.                                        #
    # https://github.com/sandstorm/Sandstorm.DevScriptRunner                      #
    ###############################################################################

set -e

##### TASKS #####

# run setup only once when you freshly cloned the repository
function setup(){
    cd laravel-backend
    composer install
    vendor/bin/sail build --no-cache
    cd ../frontend
    npm install
}

function setup-backend(){
    cd laravel-backend
    composer install
    vendor/bin/sail build --no-cache
}

function setup-frontend(){
    cd frontend
    npm install
}

function start(){
    cd laravel-backend
    vendor/bin/sail up -d
    cd ../frontend
    npm run dev
}

function start-backend(){
    cd laravel-backend
    vendor/bin/sail up -d
}

function start-frontend(){
    dev setup-frontend
    cd frontend
    npm run dev
}


function seed(){
    cd laravel-backend
    vendor/bin/sail artisan db:seed
}

function migrate(){
    cd laravel-backend
    vendor/bin/sail artisan migrate
}

function stop(){
    cd laravel-backend
    vendor/bin/sail stop
}

function down(){
    cd laravel-backend
    vendor/bin/sail down -v
}

# THIS NEEDS TO BE LAST!!!
# this will run your tasks
"$@"

