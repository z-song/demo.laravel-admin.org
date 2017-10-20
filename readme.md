laravel-admin.org
=================

Source code of official [http://laravel-admin.org](http://laravel-admin.org) website.

## Installation

```shell

$ git clone https://github.com/z-song/laravel-admin.org

$ cd laravel-admin.org

$ composer install -vvv

```

Then create a database with name `laravel_admin_demo` in your mysql. You can find database dump in `storage/mysql_dump/laravel_admin_demo.sql`,  import it:
```sql

mysql> create database `laravel_admin_demo`;

mysql> use `laravel_admin_demo`;

mysql> source storage/mysql_dump/laravel_admin_demo.sql

```

Back to terminal and start the web server:

```shell

$ php artisan serve

```

Finally open `http://localhost:8000/` in your browser.

## Support

如果觉得这个项目帮你节约了时间，不妨支持一下;)

![-1](https://cloud.githubusercontent.com/assets/1479100/23287423/45c68202-fa78-11e6-8125-3e365101a313.jpg)

## License

MIT
