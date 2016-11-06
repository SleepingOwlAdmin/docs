# Description: how to works this system

System start working with include service provider `SleepingOwl\Admin\Providers\SleepingOwlServiceProvider` in your Laravel app

```php
// config/app.php
...
'providers' => [
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
],
```

After including package `SleepingOwl` will registrate own components:

- Config connection sleeping_owl.php
- Регистрация view шаблонов c namespace `sleeping_owl::`
- Регистрация языковых файлов с namespace `sleeping_owl::`
- Регистрация media assets из файла https://github.com/LaravelRUS/SleepingOwlAdmin/blob/master/resources/assets.php
- Публикация media библиотек в `public/packages/sleepingowl`
- Регистрация сервис провайдеров из конфига `sleeping_owl` (Это сделано для того, чтобы вам не пришлось вручную
подключать кучу лишних сервис провайдеров и вы всегда могли изменить набор)
- Регистрация фасадов из конфига `sleeping_owl`
- Регистрация консольных команд

Если вам необходимо заменить системный шаблон, то необходимо поместить его `resources\views\vendor\sleeping_owl\default\`, т.е.
если есть шаблон по пути `sleepingowl\src\resources\default\display\extensions\columns.blade.php`, то путь в системе должен быть
`resources\views\vendor\sleeping_owl\default\display\extensions\columns.blade.php`

### Registratible service containers:

- AdminSection - `sleeping_owl` - `SleepingOwl\Admin\Admin`
- AdminTemplate - `sleeping_owl.template` - `SleepingOwl\Admin\Templates\TemplateDefault`
- AdminNavigation - `sleeping_owl.navigation` - `SleepingOwl\Admin\Navigation`
- WysiwygManager - `sleeping_owl.wysiwyg` - `SleepingOwl\Admin\Wysiwyg\Manager`

Также для удобства работы с данными, классы полей, таблиц, форм и т.д. собраны в отдельные группы (https://github.com/LaravelRUS/SleepingOwlAdmin/blob/master/src/Providers/AliasesServiceProvider.php),
доступ к данным каждой группы также осуществляется через сервис контейнер

- AdminColumnFilter - `sleeping_owl.column_filter`
- AdminDisplay - `sleeping_owl.display`
- AdminColumn - `sleeping_owl.table.column`
- AdminColumnEditable - `sleeping_owl.table.column.editable`
- AdminDisplayFilter - `sleeping_owl.display.filter`
- AdminForm - `sleeping_owl.form`
- AdminFormElement - `sleeping_owl.form.element`

**If you want to add new field type,you need to make the next steps**

```php
\AdminColumn::add('field_type', \App\Fields\CustomField::class);
// или
app('sleeping_owl.table.column')->add('field_type', \App\Fields\CustomField::class);

//После чего поле будет доступно следующим образом

\AdminColumn::field_type()->...
// или
app('sleeping_owl.table.column')->field_type()->...
```

### Connect files

После регистрации всех компонентов происходит поиск файлов в директории `app/Admin` и их подключение.
- Первым делом происходит подключение `bootstrap.php`
- Далее файлы конфигурации моделей

**После того, как во всех сервис провайдерах приложения будет вызван метод `boot`, будет произведено**
*(Вызов производится по событию `app()->booted` для того, чтобы вы имели возможность регистрировать модели
не только через файлы в папке `app/Admin`, но и через сервис провайдеры)*:
- Подключение `app/Admin/routes.php` *(При наличии файла)*
- Регистрация системных роутов
- Подключение `app/Admin/navigation.php` *(При наличии файла)*

!!! **После регистрации системных роутов, создание новых разделов может привести к ошибкам при использовании алиасов** !!!


### First screen (Dashboard)
В стандартную сборку SleepingOwlAdmin включен пустой шаблон дашборда с возможностью вставки в него виджетов https://github.com/LaravelRUS/SleepingOwlAdmin-docs/blob/master/widgets.md

If you want you can переопределить view шаблона дэшборда для разметки блоков для виджетов, либо переопределить роут и указать контроллер который отвечает за дашборд
```php
Route::get('', ['as' => 'admin.dashboard', 'uses' => '\App\Http\Controllers\DashboardController@index']);
```
