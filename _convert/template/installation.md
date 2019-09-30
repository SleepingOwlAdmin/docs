# Installation

 - [Support](#support)
 - [Composer](#composer)
 - [{{SERVICE-PROVIDER}}](#service-provider)
 - [Artisan](#artisan)


<a name="support"></a>
## Support
- Laravel ~5.5 || ~6.*
- PHP 7.1.3+


<a name="composer"></a>
## Composer
{{COMPOSER1}}

```bash
$ composer require laravelrus/sleepingowl

//or branch
$ composer require laravelrus/sleepingowl:dev-development
```


{{COMPOSER2}} `composer.json`

```json
{
  ...
  "require": {
    ...
    "laravelrus/sleepingowl": "dev-development",
  }
}
```
{{COMPOSER3}}

```bash
$ composer update
```

<a name="service-provider"></a>
## Service Provider
!> {{SERVICE-PROVIDER1}}

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

{{ARTISAN1}}

```bash
$ php artisan sleepingowl:install
```

#### {{ARTISAN2}}
- {{ARTISAN3}} `config/sleepign_owl.php`
- {{ARTISAN4}} `public/packages/sleepingowl/default`.
  ```bash
  $ php artisan vendor:publish --tag=assets --force
  ```
- {{ARTISAN5}} (`app/Admin`)
- {{ARTISAN6}} (`app/Admin/navigation.php`)
- {{ARTISAN7}} (`app/Admin/bootstrap.php`)
- {{ARTISAN8}} (`app/Admin/routes.php`)
- {{ARTISAN9}} (`images/uploads`)
- {{ARTISAN10}}(model_configuration_section) `app\Providers\AdminSectionsServiceProvider`


## {{NEXT}}
- [{{CONFIGURATION}}](configuration)
- [{{UPDATE}}](update)
