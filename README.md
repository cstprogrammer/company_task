# company_task

# ![Laravel 9 CMS With Roles management]

# Getting started

## Installation

Clone the repository

    git clone https://github.com/cstprogrammer/company_task

Switch to the repo folder

    cd company_task

Install all the dependencies using composer

    composer install

Install  the npm dependencies 

    npm install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate


Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Run the database seeders

    php artisan db:seed


Start the local development server

    php artisan serve

Run  npm for vue components changes reflect

    npm run watch 

You can now access the server at http://localhost:8000

Run the test

    php artisan test

**TL;DR command list**

    git clone https://github.com/cstprogrammer/company_task
    cd company_task
    composer install
    cp .env.example .env
    php artisan key:generate
    php artisan test
    npm run watch 

**Make sure you set the correct database connection information before running the migrations** [Environment variables](#environment-variables)

    php artisan migrate
    php artisan serve

## Database seeding

Run the database seeder and you're done

    php artisan db:seed

***Note*** : It's recommended to have a clean database before seeding. You can refresh your migrations at any point to clean the database by running the following command

    php artisan migrate:refresh


----------
# Technology Used

Language : PHP
Framework : Laravel 9.21
PHP Version : 8.0
Js : Vue 3 , Inertia js

# Code overview


## Folders

- `app/Models` - Contains all the Eloquent models
- `app/Providers` - Contains all the providers
- `app/Http/Controllers` - Contains all the  controllers
- `config` - Contains all the application configuration files
- `database/factories` - Contains the model factory for all the models
- `database/migrations` - Contains all the database migrations
- `database/seeds` - Contains the database seeder
- `resources/js` - Contains all the vue components
- `routes` - Contains all the  web routes defined in web.php file 
- `routes` - Contains all the api routes defined in api.php file 
- `test/Feature` - Contains all the feature test 

## Environment variables

- `.env` - Environment variables can be set in this file

***Note*** : You can quickly set the database information and other variables in this file and have the application fully working.
