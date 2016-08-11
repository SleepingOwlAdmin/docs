# Установка

Установить пакет можно помощью командной строки
```
 composer require "laravelrus/sleepingowl":"4.*@dev"
```
или добавив строчку
```
"laravelrus/sleepingowl": "4.*@dev"
```
в `composer.json` и запустить `composer update`

Далее нужно добавить сервис провайдер (Service Provider), в раздел `providers` файла `config/app.php`:

```
SleepingOwl\Admin\Providers\SleepingOwlServiceProvider::class,
```

**Пример**
```php
    ...
    /*
     * SleepingOwl Service Provider
     */
      SleepingOwl\Admin\Providers\SleepingOwlServiceProvider::class,

      /*
     * Application Service Providers...
     */
    App\Providers\AppServiceProvider::class,
    ...
```

После чего выполняем команду `php artisan sleepingowl:install`.

Все, инсталляция завершена, можно переходить к [настройке](configuration).
