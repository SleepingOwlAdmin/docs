# Конфигурация моделей через сервис провайдер

В SleepingOwlAdmin имеется возможность сконфигурировать модели разделов через сервис провайдер без использования директории `app/Admin`
Плюс данного способа в том, что конфигурация раздела описывается в классе в виде методов, а не анонимных функций и 
появляется полный доступ ко всем методам глобального конфигурационного класса.

## Активация 

Для начала вам необходимо активировать данный функционал через конфиг `sleeping_owl`, раскомментировав сервис провайдер `App\Providers\AdminSectionsServiceProvider`
и убедиться в его наличии файла. Если файл не существует, то необходимо выполнить команду `php artisan sleepingowl:install`,
файл будет создан автоматически.

## Начало работы

Для начала необходимо связать существующие Eloquent модели с классами, которые будут конфигурациями раздела.

Описание производится через добавление строк в параметр `$sections`, где в качестве ключа мы указываем 
название нашей модели, в качестве значения - класс который будет отвечать за конфигурацию.

```php
// App\Providers\AdminSectionsServiceProvider

/**
 * @var array
 */
protected $sections = [
    \App\Role::class => 'App\Http\Admin\Roles',
    \App\User::class => 'App\Http\Admin\Users',
];
```

После указания связей, запускаем консольную команду `php artisan sleepingowl:section:generate`, которая нам поможет в создании классов 
конфигурации, т.е. если указан класс `App\Http\Admin\Roles`, то для него будет создан файл `app/Http/Admin/Roles.php` с заранее 
заготовленным кодом.

!!! **При удалении конфигурационных файлов необходимо выполнить консольную команду `composer dump-autoload`** !!!

После создания файлов, они будут автоматически зарегестрированы системой.

## Работа с конфигурационным классом


**Пример готового класса**
```php
<?php

namespace App\Http\Admin;

use AdminColumn;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use SleepingOwl\Admin\Contracts\DisplayInterface;
use SleepingOwl\Admin\Contracts\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Section;

class Roles extends Section implements Initializable
{
    /**
     * @var \App\Role
     */
    protected $model;

    /**
     * Initialize class.
     */
    public function initialize()
    {
        // Добавление пункта меню и счетчика кол-ва записей в разделе
        $this->addToNavigation($priority = 500, function() {
            return \App\Role::count();
        });
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return 'fa fa-group';
    }

    /**
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     */
    public function getTitle()
    {
        return trans('core.title.roles');
    }

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        return AdminDisplay::table()->with('users')
           ->setHtmlAttribute('class', 'table-primary')
           ->setColumns(
               AdminColumn::text('id', '#')->setWidth('30px'),
               AdminColumn::link('label', 'Label')->setWidth('100px'),
               AdminColumn::text('name', 'Name')
           )->paginate(20);
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
        return AdminForm::panel()->addBody([
            AdminFormElement::text('name', 'Key')->required(),
            AdminFormElement::text('label', 'Label')->required()
        ]);
    }

    /**
     * @return FormInterface
     */
    public function onCreate()
    {
        // Создание и редактирование записи идентичны, поэтому перенаправляем на метод редактирования
        return $this->onEdit(null);
    }
    
    /**
     * Переопределение метода содержащего заголовок создания записи
     *
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     */
    public function getCreateTitle()
    {
        return 'Добавление роли';
    }
    
    /**
     * Переопределение метода для запрета удаления записи
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @return bool
     */
    public function isDeletable(\Illuminate\Database\Eloquent\Model $model)
    {
        return false;
    }
    
    /**
     * Переопределение метода содержащего ссылку на редактирование записи
     *
     * @param string|int $id
     *
     * @return string
     */
    public function getEditUrl($id)
    {
        return 'Ссылка на страницу редактирования';
    }

    /**
     * Переопределение метода содержащего ссылку на удаление записи
     *
     * @param string|int $id
     *
     * @return string
     */
    public function getDeleteUrl($id)
    {
        return 'Ссылка на удаление записи';
    }
}
```

Как можно заметить код стал более читабельным. Помимо этого появилась возможность переопределения методов глобалного конфигурационного класса 
и у вас появляются неограниченные возможности для гибкой настройки ваших разделов.

Если класс реализует интерфейс `SleepingOwl\Admin\Contracts\Initializable`, то автоматически будет вызван метод `initialize`, 
в котром можно поместить код, который нужно выполнить после регистрации класса, например добавление раздела в меню (Если это сделать в конструкторе класса,
то раздел не будет добавлен в меню, т.к. класс еще не будет зарегестрирован).


## Заключение

Также в сервис провайдер можно вынести регистрацию пунктов меню, роутов и т.д.

**Пример:**

```php
class AdminSectionsServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $sections = [
        Role::class => 'App\Http\Admin\Roles',
        User::class => 'App\Http\Admin\Users',
    ];

    /**
     * Register sections.
     *
     * @return void
     */
    public function boot(\SleepingOwl\Admin\Admin $admin)
    {
        parent::boot($admin);

        $this->registerNRoutes();
        $this->registerNavigation();
        $this->registerMediaPackages();
    }

    private function registerNavigation()
    {
        \AdminNavigation::setFromArray([
            [
                'title' => trans('core.title.organisation'),
                'icon' => 'fa fa-group',
                'priority' => 1000,
                'pages' => [
                    (new Page(User::class))->setPriority(0),
                    (new Page(Role::class))->setPriority(300)
                ]
            ]
        ]);
    }

    private function registerNRoutes()
    {
        $this->app['router']->group(['prefix' => config('sleeping_owl.url_prefix'), 'middleware' => config('sleeping_owl.middleware')], function ($router) {
            $router->get('', ['as' => 'admin.dashboard', function () {
                $content = 'Define your dashboard here.';
                return AdminSection::view($content, 'Dashboard');
            }]);
        });
    }

    private function registerMediaPackages()
    {
        PackageManager::add('front.controllers')
            ->js(null, asset('js/controllers.js'));
    }
}
```

что позволит польностью отказаться от директории `app/Admin`
