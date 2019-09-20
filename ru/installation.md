# Установка

 - [Support](#support)
 - [Composer](#composer)
 - [Добавление сервис провайдера](#service-provider)
 - [Artisan](#artisan)

<a name="support"></a>
## Support
- Laravel ~5.5 || ~6.*
- PHP 7.1.3+


<a name="composer"></a>
## Composer
Установить пакет можно помощью командной строки

```bash
$ composer require laravelrus/sleepingowl

//or branch
$ composer require "laravelrus/sleepingowl":"dev-development"
$ composer require "laravelrus/sleepingowl":"dev-bs4"
```


или вручную добавив пакет в `composer.json`

```json
{
  ...
  "require": {
     ...
     "laravelrus/sleepingowl": "dev-development"
  }
}
```
и выполнить команду

```bash
$ composer update
```

<a name="service-provider"></a>
## Service Provider
!> Для Laravel 5.5+ пакет подключится автоматически либо можно указать вручную:

**config/app.php**
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
## Artisan

Используйте эту команду для начальной конфигурации SleepingOwl Admin. Она создаст все необходимые файлы и директории.

```bash
$ php artisan sleepingowl:install
```

#### Что делает эта команда

 - Публикует конфигурацию SleepingOwl Admin.
 - Публикует ассеты из SleepingOwl Admin в `public/packages/sleepingowl/default`.
   ```bash
   $ php artisan vendor:publish --tag=assets --force
   ```


 - Создает директорию автозапуска (`app/Admin`)
 - Создает файл конфигурации меню по умолчанию (`app/Admin/navigation.php`)
 - Создает файл автозапуска по умолчанию (`app/Admin/bootstrap.php`)
 - Создает файл роутов по умолчанию (`app/Admin/routes.php`)
 - Создает структуру директории public (`images/uploads`)
 - Создает [Service Provider](model_configuration_section) `app\Providers\AdminSectionsServiceProvider`

<a name="what-next"></a>
## Следующий этап

 - [Настройка](configuration)
 - [Обновление](update)
