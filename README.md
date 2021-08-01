## About Larapos

1. Laravel 8
2. PostgreSQL

## Instalation

1. php artisan optimize:clear
2. Move All File from Public to Root
3. Setting File index.php
    - require **DIR**.'/vendor/autoload.php';
    - $app = require_once __DIR__.'/bootstrap/app.php';
   $app->bind('path.public', function() {
      return base_path();
      });
4. Update .env
   APP_URL=http://localhost/mypos
5. Update BASE_URL Javascript
 <script>
      window.APP_URL = '{{ config('app.url')}}';
  </script>

6. composer update
7. update file .env
   DB_CONNECTION=pgsql
   DB_HOST=localhost
   DB_PORT=5432
   DB_DATABASE=larapos
   DB_USERNAME=postgres
   DB_PASSWORD=
8. create database "larapos"
9. php artisan migrate #migration database
10. php artisan db:seed #DB Seed Example
11. php artisan key:generate

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
