# Installation

 - [Composer](#composer)
 - [Service Provider](#service-provider)
 - [Artisan](#artisan)

<a name="composer"></a>
## Composer

First, download the SleepingOwl Admin package using Composer:

```bash
$ composer require "laravelrus/sleepingowl":"4.*@dev"
```

or add packager to `composer.json`

```json
{
  ...
  "require": {
     ...
     "laravelrus/sleepingowl": "4.*@dev"
  }
}
```
and run

```bash
$ composer update
```

<a name="service-provider"></a>
## Service Provider

Add ([Service Provider](https://laravel.com/docs/5.3/providers)) `SleepingOwl\Admin\Providers\SleepingOwlServiceProvider::class` to `config/app.php` in providers section

**Example**
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

Run artisan command `sleepingowl:install` to install SleepingOwl Admin.

```bash
$ php artisan sleepingowl:install
```

#### What does this command

 - Publishes config file `sleepign_owl.php`.
 - Publishes assets from `vendor/laravelrus/sleepingowl/public` to `public/packages/sleepingowl/default`.
   ```bash
   $ php artisan vendor:publish --tag=assets --force`
   ```

 - Makes directory `app/Admin`.
 - Makes configuration file for navigation `app/Admin/navigation.php`.
 - Makes admin bootstrapper `app/Admin/bootstrap.php`.
 - Makes admin routes file `app/Admin/routes.php`.
 - Creates public directory for images upload `public/images/uploads`
 - Makes [service provider](model_configuration_section.md) `app\Providers\AdminSectionsServiceProvider`

<a name="what-next"></a>
## What next

 - [Configuration](configuration)
 - [Update](update)
