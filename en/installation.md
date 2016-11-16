# Installation

 1. Require this package in your composer.json and run `composer update`:

  ```
  "require": {
    "php": ">=5.5.9",
    "laravel/framework": "5.2.*",
    ...
    "laravelrus/sleepingowl": "4.*@dev"
  },
  ```

  Or `composer require laravelrus/sleepingowl:4.*@dev`

 2. After composer update, insert service provider `SleepingOwl\Admin\Providers\SleepingOwlServiceProvider::class,`
 before `Application Service Providers...` to the `config/app.php`

  **Example**
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

 3. Run this command in the terminal (if you want to know more about what exactly this command does, see [install command documentation](http://sleeping-owl.github.io/en/Commands/Install.html)):

```
$ php artisan sleepingowl:install
```