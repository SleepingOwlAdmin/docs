# Конфигурация

[php artisan sleepingowl:install](installation#artisan) во время установки автоматически публикует конфиг `sleeping_owl.php`.

Если вы хотите опубликовать конфиг вручную выполните эту команду:
```bash
$ php artisan vendor:publish --provider="SleepingOwl\Admin\Providers\SleepingOwlServiceProvider" --tag="config"
```

## Параметры конфигурации
- [Главные](#main)
- [Datatables](#datatables)
- [Другие](#other)
- [ENV-настройки](#env-settings)
- [Автообновление Datatables](#autoupdate)


<a name="env-settings"></a>
#### `title`
Строка для отображения в заголовке страницы

#### `logo`
Логотип отображаемый в верхней панеле

#### `logo_mini`
Логотип отображаемый в верхней панели при минимизированной боковой панели

#### `menu_top` (только в v.6+)
Текст отображаемый над меню

<a name="datatables"></a>
#### `state_datatables` (только в v.6+) (default: `true`)
Сохранение состояния DataTables в localStorage

#### `state_tabs` (только в v.6+) (default: `false`)
Сохранение активности табов

#### `state_filters` (только в v.6+) (default: `false`)
Сохранение значений фильтров в datatables

<a name="other"></a>
#### `url_prefix` (default: `'admin'`)
Префикс адреса для административного модуля

#### `domain` (default: `false`)
Включение/отключение поддержки субдомена для админки

#### `middleware` (default: `['web', 'auth']`)
Посредник, который ограничивают административный модуль от доступа неавторизованных пользователей

<a name="env-settings"></a>
#### `enable_editor` (default: `false`)
Включение и добавление редактирования настроек

#### `env_keys_readonly` (default: `false`)
Делает поле ключей только для просмотра

#### `env_can_delete` (default: `true`)
Разрешает/запрещает удалять ключ/значение

#### `env_can_add` (default: `true`)
Разрешает/запрещает добавлять ключ/значение (при условии что `env_keys_readonly == false`)

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

#### `datatables_highlight` (default: `false`)
Подсветка столбцов DataTables при наведении мыши (глобальное включение / выключение).
Для включения на определенной datatable - добавить класс `.lightcolumn`

```php
//config
'datatables_highlight' => true,

//Section
//.table-primary, .table-secondary, .table-info, .table-success, .table-warning, .table-danger
//.table-light, .table-gray, .table-white, .table-black, .table-red, .table-dark
$display = AdminDisplay::datatablesAsync()
    ->setHtmlAttribute('class', 'table-primary table-striped table-hover lightcolumn');
```

<a name="autoupdate"></a>
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

#### `scroll_to_top` (default: `true`)
Включение/отключение кнопки перехода вверх на странице

#### `scroll_to_bottom` (default: `true`)
Включение/отключение кнопки перехода вниз страницы

#### `imageLazyLoad`
Включение/отключение ленивой загрузки изображений в таблицах и дататаблицах

#### `imageLazyLoadFile`
Изображение по умолчанию для отображения не загруженных страниц. Можно указать пустое изображение через `data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==` либо указать путь относительно паблик папки


#### `aliases`
Алиасы, которые инициализируются пакетом


## Следующий шаг
- [Описание работы системы](global)
- [Авторизация](authentication)
