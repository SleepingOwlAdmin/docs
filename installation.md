# Установка

 - [Composer](#composer)
 - [Добавление сервис провайдера](#service-provider)
 - [Artisan](#artisan)

<a name="composer"></a>
## Composer
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
## Service Provider

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
## Artisan

Используйте эту команду для начальной конфигурации SleepingOwl Admin. Она создаст все необходимые файлы и директории.

```bash
$ php artisan sleepingowl:install
```

#### Что делает эта команда

 - Публикует конфигурацию SleepingOwl Admin.
 - Публикет ассеты из SleepingOwl Admin в `public/packages/sleepingowl/default`.
   ```bash
   $ php artisan vendor:publish --tag=assets --force`
   ```

 - Создает директорию автозапуска (По умолчанию `app/Admin`).
 - Создает файл конфигурации меню по умолчанию. (По умолчанию `app/Admin/navigation.php`)
 - Создает файл автозапуска по умолчанию. (По умолчанию `app/Admin/bootstrap.php`)
 - Создает файл роутов по умолчанию. (По умолчанию `app/Admin/routes.php`)
 - Создает структуру директории public (*создает директорию `images/uploads`*)
 - Создает [сервис провайдер](model_configuration_section.md) `app\Providers\AdminSectionsServiceProvider`

<a name="what-next"></a>
## Следующий этап

 - [Настройка](configuration)
 - [Обновление](update)
