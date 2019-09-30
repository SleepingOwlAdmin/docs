# Installation

 - [Support](#support)
 - [Composer](#composer)
 - [Adding a Service Provider](#service-provider)
 - [Artisan](#artisan)


<a name="support"></a>
## Support
- Laravel ~5.5 || ~6.*
- PHP 7.1.3+


<a name="composer"></a>
## Composer
You can install the package using the command line

```bash
$ composer require laravelrus/sleepingowl

//or branch
$ composer require laravelrus/sleepingowl:dev-development
```


or manually adding a package to `composer.json`

```json
{
  ...
  "require": {
    ...
    "laravelrus/sleepingowl": "dev-development",
  }
}
```
and execute the command

```bash
$ composer update
```

<a name="service-provider"></a>
## Service Provider
!> In Laravel 5.5+ the package will register automatically or you can specify it manually:

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

Run artisan command to install SleepingOwl Admin

```bash
$ php artisan sleepingowl:install
```

#### What does this command
- Publishes SleepingOwl Admin configuration `config/sleepign_owl.php`
- Publish SleepingOwl Admin Assets in `public/packages/sleepingowl/default`.
  ```bash
  $ php artisan vendor:publish --tag=assets --force
  ```
- Creates Autorun directory (`app/Admin`)
- Creates a default menu configuration file (`app/Admin/navigation.php`)
- Creates a default startup file (`app/Admin/bootstrap.php`)
- Creates a default route file (`app/Admin/routes.php`)
- Creates a directory structure in 'public' (`images/uploads`)
- Make [Service Provider](model_configuration_section) `app\Providers\AdminSectionsServiceProvider`


## Next step
- [Configuration](configuration)
- [Update guide](update)
