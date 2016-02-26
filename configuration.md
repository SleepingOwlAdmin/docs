# Конфигурация

[Команда install](command_install) публикует конфиг SleepingOwl Admin автоматически. Если вы хотите опубликовать конфиг вручную выполните эту команду:

```bash
$ php artisan vendor:publish --provider="SleepingOwl\Admin\SleepingOwlServiceProvider" --tag="config"
```

## Параметры конфигурации

### title

Строка для отображения в заголовке страницы.

### title_mini

Короткий заголовок при свернутой панели меню. Формат: html.

### prefix

Префикс адреса для административного модуля.

По умолчанию: `admin`

### middleware

Middleware, который ограничивают административный модуль от доступа неавторизованных пользователей.

По умолчанию: `['web']`

### bootstrapDirectory

Путь к директории автозапуска SleepingOwl Admin. Располагайте там ваши конфигурацию моделей, конфигурацию меню, кастомные столбцы и элементы форм. Каждый `.php` файл в этой директории будет подключен.

По умолчанию: `app_path('Admin')`

### imagesUploadDirectory

Путь к директории изображений. Относительно вашей public директории.

По умолчанию: `'images/uploads'`

### template

Используемый шаблон.

По умолчанию: `SleepingOwl\Admin\Templates\TemplateDefault::class`

### datetimeFormat, dateFormat, timeFormat

Формат даты и времени для использования в столбцах и элементах формы по умолчанию

По умолчанию: `'d.m.Y H:i', 'd.m.Y', 'H:i'`
