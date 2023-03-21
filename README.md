# BOOK MANAGER

A Laravel project that manages a simple Library with CRUD

## Development Setups

### Prequesites

- **[Composer](https://getcomposer.org/download/) up to 2.4.0**
- **[PHP](https://www.php.net/downloads.php) up 7.2.5**

### Setting Up

Install all the dependencies using composer

    composer install
    
Copy the example env file and make the required configuration change in the .env file

    cp .env.example .env
    
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

## Folders

- `app/Http/Controllers` - Contais all the controllers
- `public/images` - Contains all books cover images
- `resources/views` - Contains all the blade templates
- `database/migrations` - Contains all the database migrations
- `database/seed` - Contains the database seeder
- `routes` - Contains all the routes defined in web.php file
- `storage/logs` - Contains all the logs

### Views 

- `form.blade.php` - A tempalte form to *create* and *update* the books
- `header.blade.php` - A template that renders the navigation bar
- `info.blade.php` - A template that renders the book details
- `list.blade.php` - A template that renders all the books
- `response.blade.php` - A template that renders the server response message

### Controller (BookController.php)

- **Index - Method GET**

Retrieves all the books and categories fetched from the database for the `list.blade.php` template.
Retrieves all the books that match or is similar to the searched name inserted in the searchbar.
Retrieves all the books where genre equals to the selected value in the list.

- **show** - Method GET**

Retrieves the book details for the `info.blade.php` template based on the route parameter ID.
Retrieves all the categories.

- **create** - Method GET**

Renders the `form.blade.php` template without any book details.

- **store** - Method POST**

Creates a Book

- **edit** - Method GET**

Renders the `form.blade.php` template with the book details based on the route parameter ID.

- **update** - Method PUT**

Updates the book with the new client data in the database. 

- **delte** - Method DELETE**

Delete the book


