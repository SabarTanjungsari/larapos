## About Larapos

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

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
