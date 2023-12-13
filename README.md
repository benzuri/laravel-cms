## About this Laravel app

Simple CMS app made with Laravel.
- User registration (Jetstream)
- Dynamic interface (Livewire, AlpineJS)
- Design (Tailwind)

## Screenshots

<p><img src="/public/screenshot.gif"></p>

## Installation

Please check the official Laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/10.x/installation)

Clone the repository

    git clone https://github.com/benzuri/laravel-cms.git

Switch to the app folder

    cd laravel-cms

Install all the dependencies using composer

    composer install

Make the required configuration changes in the .env file if you need

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate:fresh

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000
