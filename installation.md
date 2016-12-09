# Установка

 - [Composer](#composer)
 - [Добавление сервис провайдера](#service-provider)

<a name="composer"></a>
### Composer
Установить пакет можно помощью командной строки

```bash
$ composer require "laravelrus/sleepingowl":"4.*@dev"
```

или вручную добавив пакет в `composer.json`

```json
{
  ...
  "require": {
     ...
     "laravelrus/sleepingowl": "4.*@dev"
  }
}
```
и выполнить команду

```bash
$ composer update
```

<a name="service-provider"></a>
### Service Provider

После установки пакета необходимо добавить сервис провайдер
([Service Provider](https://laravel.com/docs/5.3/providers)) `SleepingOwl\Admin\Providers\SleepingOwlServiceProvider::class`,
в соответсвующий раздел `providers` файла `config/app.php`:

**Пример**
```php
'providers' => [
    ...
    /**
     * SleepingOwl Service Provider
     */
    SleepingOwl\Admin\Providers\SleepingOwlServiceProvider::class,

    /**
     * Application Service Providers...
     */
    App\Providers\AppServiceProvider::class,
    ...
]
```

<a name="artisan"></a>
### Artisan

После добавления сервис провайдера можно приступить к установке, для этого необходимо выполнить команду

```bash
$ php artisan sleepingowl:install
```

<a name="what-next"></a>
### Следующий этап

 - [Настройка](configuration)
 - [Обновление](update)
