# Laravel Api
Laravel API Demo. 
Authentication and Data Access

## How to develop

Copy .env.example to .env

Fire up a container with composer.
```$ docker-compose up ```

Inside the container run 
``` $ composer install ```

By default the api is listening in the 8080 port.

## Testing
Replace the DB_NAME variable inside the .env with a database for testing.
Execute:
``` $ php artisan test```  

## Features

### Routes
https://github.com/Raul-Espinoza-FS/laravel-api/blob/master/routes/api.php

### Controllers
https://github.com/Raul-Espinoza-FS/laravel-api/tree/master/app/Http/Controllers

### Models
https://github.com/Raul-Espinoza-FS/laravel-api/tree/master/app/Models
  
### Policies
https://github.com/Raul-Espinoza-FS/laravel-api/tree/master/app/Policies

### Migrations
https://github.com/Raul-Espinoza-FS/laravel-api/tree/master/database/migrations

### Seeders
https://github.com/Raul-Espinoza-FS/laravel-api/tree/master/database/seeders

### Factories
https://github.com/Raul-Espinoza-FS/laravel-api/tree/master/database/factories

### Unit Testing
https://github.com/Raul-Espinoza-FS/laravel-api/tree/master/tests/Unit