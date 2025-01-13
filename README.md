# A simple Laravel App 


The folder structure is as follows : 

 Laravel-vue-ecomm - hosts the laravel application \
 laravel-vue-ecomm/backend - hosts the vuejs application 
 
 The laravel application serves data to the vue appliaction via RestFul APIs. \
 The VueJs App is version Vue3


## Running the applications
 VueJS APP:
 ```sh
 cd laravel-vue-ecomm/backend 
 npm install #to install dependencies 
 npm run dev #to start a local instance 
 ```
 
 Laravel App :
 ```sh
  cd laravel-vue-ecomm/
  composer install #to install PHP dependencies
  # Duplicate the .env.example file and rename it to .env.
  # Open the .env file and set your database connection details.
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_username
    DB_PASSWORD=your_database_password

    # Run Migrations 
    php artisan migrate
    # Seed the DB 
    php artisan db:seed
    # Start Server 
    php artisan serve
```

