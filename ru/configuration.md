# Конфигурация

[php artisan sleepingowl:install](installation#artisan) во время установки автоматически публикует конфиг `sleeping_owl.php`.

Если вы хотите опубликовать конфиг вручную выполните эту команду:
```bash
$ php artisan vendor:publish --provider="SleepingOwl\Admin\Providers\SleepingOwlServiceProvider" --tag="config"
```

## Параметры конфигурации

#### `title`
Строка для отображения в заголовке страницы

#### `logo`
Логотип отображаемый в верхней панеле

#### `logo_mini` (@deprecated in ver. 6+)
Логотип отображаемый в верхней панели при минимизированной боковой панели

#### `url_prefix` (default: `'admin'`)
Префикс адреса для административного модуля

#### `domain` (default: `false`)
Включение/отключение поддержки субдомена для админки

#### `middleware` (default: `['web', 'auth']`)
Посредник, который ограничивают административный модуль от доступа неавторизованных пользователей

#### `enable_editor` (default: `false`)
Включение и добавление редактирования настроек

#### `env_editor_url` (default: `'env/editor'`)
URL, для редактирования env файла настроек

#### `env_editor_policy` (default: `null`)
Добавление политики

#### `env_editor_excluded_keys`
Массив ключей или масок ключей для скрытия в редакторе файла настроек
```php
'env_editor_excluded_keys' => [
    'APP_KEY', 'DB_*',
],
```

#### `env_editor_middlewares` (default: `[]`)
Добавление посредника для редактирование настроек

#### `auth_provider` (default: `'users'`)
Провайдер авторизации пользователей. [Custom User Providers](https://laravel.com/docs/authentication#adding-custom-user-providers)

#### `bootstrapDirectory` (default: `app_path('Admin')`)
Путь к директории автозапуска SleepingOwl Admin

#### `imagesUploadDirectory` (default: `'images/uploads'`)
Путь к директории изображений относительно `public`

#### `filesUploadDirectory` (default: `'files/uploads'`)
Путь к директории файлов относительно `public`

#### `template` (default: `SleepingOwl\Admin\Templates\TemplateDefault::class`)
Класс используемого шаблона, должен быть унаследован от `SleepingOwl\Admin\Contracts\TemplateInterface`

#### `datetimeFormat` (default: `'d.m.Y H:i'`)
#### `dateFormat` (default: `'d.m.Y'`)
#### `timeFormat` (default: `'H:i'`)
Формат даты и времени для использования в столбцах и элементах формы по умолчанию

#### `wysiwyg`
Настройки для Wysiwyg редакторов текста по умолчанию

#### `datatables` (default: `[]`)
Настройки datatables по умолчанию

#### `dt_autoupdate` (default: `false`)
Включение/отключение автообновления datatables

#### `dt_autoupdate_interval` (default: `5`)
Время обновления datatables в минутах

#### `dt_autoupdate_class` (default: `''`)
Класс автообновления. Если не задано все datatables будут с автообновлением

#### `dt_autoupdate_color` (default: `'#dc3545'`)
Цвет прогрессбара автообновления таблиц

#### `breadcrumbs` (default: `true`)
Включение/отключение хлебных крошек

#### `aliases`
Алиасы, которые инициализируются пакетом


## Следующий шаг
- [Описание работы системы](global)
- [Авторизация](authentication)
