# Конфигурация

[Команда install](command_install) публикует конфиг SleepingOwl Admin автоматически. Если вы хотите опубликовать конфиг вручную выполните эту команду:

```bash
$ php artisan vendor:publish --provider="SleepingOwl\Admin\Providers\SleepingOwlServiceProvider" --tag="config"
```

## Параметры конфигурации

#### `title`

Строка для отображения в заголовке страницы.

#### `logo`

Логотип отображаемый в верхней панели

#### `logo_mini`

Логотип отображаемый в верхней панели при минимизированной боковой панели

#### `url_prefix`

Префикс адреса для административного модуля.

По умолчанию: `admin`

#### `middleware`

Middleware, который ограничивают административный модуль от доступа неавторизованных пользователей.

По умолчанию: `['web', 'auth']`

#### `auth_provider`

Провайдер отвечающий за авторизацию пользователей. Подробнее https://laravel.com/docs/5.2/authentication#adding-custom-user-providers

По умолчанию: `users`

#### `bootstrapDirectory`

Путь к директории автозапуска SleepingOwl Admin. Располагайте там ваши конфигурацию моделей, конфигурацию меню, кастомные столбцы и элементы форм. Каждый `.php` файл в этой директории будет подключен.

По умолчанию: `app_path('Admin')`

#### `imagesUploadDirectory`

Путь к директории изображений. Относительно вашей public директории.

По умолчанию: `'images/uploads'`

#### `filesUploadDirectory`

Путь к директории файлов. Относительно вашей public директории.

По умолчанию: `'files/uploads'`

#### `template`

Класс используемого шаблона (должен быть наследован от `SleepingOwl\Admin\Contracts\TemplateInterface`)

По умолчанию: `SleepingOwl\Admin\Templates\TemplateDefault::class`

#### `datetimeFormat`, `dateFormat`, `timeFormat`

Формат даты и времени для использования в столбцах и элементах формы по умолчанию

По умолчанию: `'d.m.Y H:i', 'd.m.Y', 'H:i'`

#### `wysiwyg`

Настройки для редакторов текста по умолчанию.

#### `datatables`

Настройки datatables по умолчанию

#### `breadcrumbs`

Включение/отключение хлебных крошек

#### `aliases`

Алиасы, которые инициализируются пакетом. 
