# Описание работы системы

Работа системы начинается в тот момент, когда вы подключаете сервис провайдер `SleepingOwl\Admin\Providers\SleepingOwlServiceProvider` в ваше Laravel приложение

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

После подключения, пакет `SleepingOwl` произведет регистрацию своих компонентов:

- Подключение конфига sleeping_owl.php
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

## Регистрируемые сервис контейнеры:

```php
// AdminSection
'sleeping_owl' => ['SleepingOwl\Admin\Admin', 'SleepingOwl\Admin\Contracts\AdminInterface']

// AdminTemplate
'sleeping_owl.template' => ['SleepingOwl\Admin\Contracts\Template\TemplateInterface']

'sleeping_owl.breadcrumbs' => ['SleepingOwl\Admin\Contracts\Template\Breadcrumbs']

// AdminWidgets
'sleeping_owl.widgets' => ['SleepingOwl\Admin\Contracts\Widgets\WidgetsRegistryInterface', 'SleepingOwl\Admin\Widgets\WidgetsRegistry']

// MessagesStack
'sleeping_owl.message' => ['SleepingOwl\Admin\Widgets\Messages\MessageStack']

// AdminNavigation
'sleeping_owl.navigation' => ['SleepingOwl\Admin\Navigation', 'SleepingOwl\Admin\Contracts\Navigation\NavigationInterface']

// WysiwygManager
'sleeping_owl.wysiwyg' => ['SleepingOwl\Admin\Wysiwyg\Manager', 'SleepingOwl\Admin\Contracts\Wysiwyg\WysiwygMangerInterface']

// Meta
'sleeping_owl.meta' => ['assets.meta', 'SleepingOwl\Admin\Contracts\Template\MetaInterface', 'SleepingOwl\Admin\Templates\Meta'],
```
Также для удобства работы с данными, классы полей, таблиц, форм и т.д. собраны в отдельные группы (https://github.com/LaravelRUS/SleepingOwlAdmin/blob/master/src/Providers/AliasesServiceProvider.php),
доступ к данным каждой группы также осуществляется через сервис контейнер

- AdminColumnFilter - `sleeping_owl.column_filter`
- AdminDisplay - `sleeping_owl.display`
- AdminColumn - `sleeping_owl.table.column`
- AdminColumnEditable - `sleeping_owl.table.column.editable`
- AdminDisplayFilter - `sleeping_owl.display.filter`
- AdminForm - `sleeping_owl.form`
- AdminFormElement - `sleeping_owl.form.element`

**Если вы хотите добавить, допустим, новый тип поля, вам необходимо сделать следующее**

```php
\AdminColumn::add('field_type', \App\Fields\CustomField::class);
// или
app('sleeping_owl.table.column')->add('field_type', \App\Fields\CustomField::class);

//После чего поле будет доступно следующим образом

\AdminColumn::field_type()->...
// или
app('sleeping_owl.table.column')->field_type()->...
```

## Подключение файлов

После регистрации всех компонентов происходит поиск файлов в директории `app/Admin` и их подключение.
- Первым делом происходит подключение `bootstrap.php`
- Далее файлы конфигурации моделей

**После того, как во всех сервис провайдерах приложения будет вызван метод `boot`, будет произведено**:

?> Вызов производится по событию `app()->booted` для того, чтобы вы имели возможность регистрировать модели не только через файлы в папке `app/Admin`, но и через сервис провайдеры

- Подключение `app/Admin/routes.php` *(При наличии файла)*
- Регистрация системных роутов
- Подключение `app/Admin/navigation.php` *(При наличии файла)*

!> После регистрации системных роутов, создание новых разделов может привести к ошибкам при использовании алиасов


## Рабочий стол (Dashboard)
В стандартную сборку SleepingOwlAdmin включен пустой шаблон дашборда с возможностью вставки в него виджетов https://github.com/SleepingOwlAdmin/docs/blob/master/ru/widgets.md

При желании вы можете переопределить view шаблона дэшборда для разметки блоков для виджетов, либо переопределить роут и указать контроллер который отвечает за дашборд
```php
Route::get('', ['as' => 'admin.dashboard', 'uses' => '\App\Http\Controllers\DashboardController@index']);
```
