## BlogProject

### what it does

- Redis cache homepage posts
- Import new posts via api endpoint
- Users can register/login and add their own posts.
- Users can view their own posts.

### Setup

Needed: 
- Php 8.0 - 8.1 (with redis & pdo sqlite(for in db memory tests) extensions)
- MYSQL
- Redis

You can see more here on Laravel installation

https://laravel.com/docs/9.x/installation#getting-started-on-linux


Also need to run:
 - composer install
 - php artisan migrate --seed (for admin user & posts data)
 - npm install && npm run dev

To run tests related to this project:
- php artisan test

Import Posts

The following needs a cron job on your system:

- php artisan schedule:run

Example:
***** php /path/to/artisan schedule:run 1>> /dev/null 2>&1


