# Авторизация

SleepingOwl Admin по умолчанию не использует авторизацию, т.е. доступ в админ панель никак не защищен. Настроить доступ можно используя `middleware`.

Самый простой вариант - использовать стандартный механизм, который предоставляет сам Laravel.

Для этого необходимо выполнить консольную команду `php artisan make:auth` (Подробнее https://laravel.com/docs/5.2/authentication#authentication-quickstart) и в конфиге `sleeping_owl.php` добавить middleware `auth`

```php
/*
 | ...
 | see https://laravel.com/docs/5.2/authentication#authentication-quickstart
 |
 */
    
'middleware' => ['web', 'auth'],
...
```

Таким образом у вас есть возможность с помощью middleware гибко настраивать правила для доступа в админ панель.

---

Подробнее о работе авторизации можно посмотреть в [документации](https://laravel.com/docs/5.2/authentication)
