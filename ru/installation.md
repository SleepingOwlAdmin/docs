# Установка

 - [Composer](#composer)
 - [Artisan](#artisan)
 - [Следующий этап](#what-next)

<a name="composer"></a>
## Composer
Установить пакет можно помощью командной строки

```bash
$ composer require laravelrus/sleepingowl:5.6.*
```

или вручную добавив пакет в `composer.json`

```json
{
  ...
  "require": {
     ...
     "laravelrus/sleepingowl": "5.6.*"
  }
}
```
и выполнить команду

```bash
$ composer update
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

 - Создает директорию автозапуска (По умолчанию `app/Admin`).
 - Создает файл конфигурации меню по умолчанию. (По умолчанию `app/Admin/navigation.php`)
 - Создает файл автозапуска по умолчанию. (По умолчанию `app/Admin/bootstrap.php`)
 - Создает файл роутов по умолчанию. (По умолчанию `app/Admin/routes.php`)
 - Создает структуру директории public (*создает директорию `images/uploads`*)
 - Создает [сервис провайдер](model_configuration_section) `app\Providers\AdminSectionsServiceProvider`

**Примечание**

Если вы используете пакет  `laravel-ide-helper` допишите `sleepingowl:update` после комманд:


```php
"post-update-cmd": [
        "Illuminate\\Foundation\\ComposerScripts::postUpdate",
        "php artisan ide-helper:generate",
        "php artisan ide-helper:meta",
        "php artisan sleepingowl:update"
]
```

<a id="what-next"></a>
## Следующий этап

 - [Настройка](configuration)
 - [Обновление](update)
