# BOOK MANAGER

A Laravel project that manages a simple CRUD for a Library

## Development Setups

### Prequesites

- **[Composer](https://getcomposer.org/download/) up to 2.4.0**
- **[PHP](https://www.php.net/downloads.php) up 7.2.5**

### Setting Up

Install all the dependencies using composer

    composer install
    
Copy the exaqmple env file and make the required configuration change in the .env file

    cp .env.exmaple .env
    
Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate
    
Start the local development server

    php artisan serve
    
You can now access the server

### Database seeding

**Populate the database with seed data with relationships which includes Books and categories. This can help you quickly start testing the app.**

Run the database seeder

    php artisan db:seed
    
# Code overview



