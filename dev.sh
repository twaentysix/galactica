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
    vendor/bin/sail up -d
    vendor/bin/sail artisan migrate
    vendor/bin/sail artisan db:seed
    # frontend stuff missing
}

function start(){
    cd laravel-backend
    vendor/bin/sail up -d
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

