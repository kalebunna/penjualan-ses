## Instalation Guide
```bash
cp .env.example .env
```
ater that run
Setup your database configuration in `.env`
``` env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=

run the following commands
```
```bash
php artisan key:generate
php artisan migrate
php artisan db:seed
```

### notes:
- change the `query in forcast controller` if you use MYSQL
