# Конфигурация моделей через сервис провайдер

В SleepingOwlAdmin имеется возможность сконфигурировать модели разделов через сервис провайдер без использования директории `app/Admin`.
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
        
        $this->creating(function($config, \Illuminate\Database\Eloquent\Model $model) {
            ...
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
в котром можно поместить код, который нужно выполнить после регистрации класса, например добавление раздела в меню (Если это сделать в конструкторе класса, то раздел не будет добавлен в меню, т.к. класс еще не будет зарегестрирован).

Иногда необходимо в методе `initialize` работать с данными, которые в момент вызова не инициализированы, для этого можно воспользоваться следующим приемом:

```php
/**
 * Initialize class.
 */
public function initialize()
{
    app()->booted(function() {
        \AdminNavigation::getPages()->findById(...)->addPage(...)
    });
}
```


## Заключение

Также в сервис провайдер можно вынести регистрацию пунктов меню, роутов и т.д., что позволит польностью отказаться от директории `app/Admin`.

**Пример:**

```php
use SleepingOwl\Admin\Navigation\Page;
use AdminSection;
use PackageManager;

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

# API

Параметры
----------


### $class
Название класса модели используемого разделом

    protected string $class

### $model
Инстанс класса модели 

    protected \Illuminate\Database\Eloquent\Model $model

### $alias
Путь в ссылке, по которому доступен раздел (**По умолчанию** название модели во множественном числе)

    protected string $alias

### $controllerClass
Название класса используемого в качестве контроллера для работы с разделом

    protected string $controllerClass

### $title
Название раздела

    protected string $title

### $icon
Иконка раздела (Используется также при генерации пунктов меню навигации)

    protected string $icon

### $checkAccess
Параметр отвечающий за проверку прав доступа к разделу, если `true`, то будет включена проверка прав

    protected boolean $checkAccess = false

Методы
-------

### __construct
Конструктор класса

    mixed SleepingOwl\Admin\Model\ModelConfigurationManager::__construct(string $class)

* Доступ: **public**
* This method is defined by `SleepingOwl\Admin\Model\ModelConfigurationManager`

### isCreatable
Проверка на возможность создание записи в разделе (Если не существует метод `onCreate` вернет `false`)

    boolean SleepingOwl\Admin\Model\ModelConfigurationManager::isCreatable()

* Доступ: **public**
* This method is defined by `SleepingOwl\Admin\Model\ModelConfigurationManager`


### isDisplayable
Проверка на возможность отображение списка записей раздела (Если не существует метод `onDisplay` вернет `false`)

    boolean SleepingOwl\Admin\Model\ModelConfigurationManager::isDisplayable()

* Доступ: **public**
* Метод определен в классе `SleepingOwl\Admin\Model\ModelConfigurationManager`

### isDeletable
Проверка на возможность удаления записи раздела

    boolean SleepingOwl\Admin\Model\ModelConfigurationManager::isDeletable(\Illuminate\Database\Eloquent\Model $model)

* Доступ: **public**
* Метод определен в классе `SleepingOwl\Admin\Model\ModelConfigurationManager`

### isDestroyable
Проверка на возможность окончательного удаления записи раздела

    boolean SleepingOwl\Admin\Model\ModelConfigurationManager::isDestroyable(\Illuminate\Database\Eloquent\Model $model)

* Доступ: **public**
* Метод определен в классе `SleepingOwl\Admin\Model\ModelConfigurationManager`

### isRestorable
Проверка на возможность восстановления записи раздела

    boolean SleepingOwl\Admin\Model\ModelConfigurationManager::isRestorable(\Illuminate\Database\Eloquent\Model $model)

* Доступ: **public**
* Метод определен в классе `SleepingOwl\Admin\Model\ModelConfigurationManager`

### isRestorableModel

    boolean SleepingOwl\Admin\Model\ModelConfigurationManager::isRestorableModel()

* Доступ: **public**
* Метод определен в классе `SleepingOwl\Admin\Model\ModelConfigurationManager`

### isEditable
Проверка на возможность редактирование записи в разделе (Если не существует метод `onEdit` вернет `false`)

    boolean SleepingOwl\Admin\Model\ModelConfigurationManager::isEditable(\Illuminate\Database\Eloquent\Model $model)

* Доступ: **public**
* This method is defined by `SleepingOwl\Admin\Model\ModelConfigurationManager`

### fireCreate
Запуск построения формы создания записи

    FormInterface|void SleepingOwl\Admin\Model\SectionModelConfiguration::fireCreate()

* Доступ: **public**

### fireFullEdit
Запуск построения формы редактирования записи

    \SleepingOwl\Admin\Model\SectionModelConfiguration SleepingOwl\Admin\Model\SectionModelConfiguration::fireFullEdit(integer $id)

* Доступ: **public**

### fireDelete
Метод вызывается в момент удаления записи

    void SleepingOwl\Admin\Model\SectionModelConfiguration::fireDelete(int $id)

* Доступ: **public**

### fireDestroy
Метод вызывается в момент удаления записи (Удаление в случае если запись была помечена как удалена `SoftDelete`)

    mixed SleepingOwl\Admin\Model\SectionModelConfiguration::fireDestroy(int $id)

* Доступ: **public**

### fireRestore
Метод вызывается в момент восстановления записи

    boolean|mixed SleepingOwl\Admin\Model\SectionModelConfiguration::fireRestore(int $id)

* Доступ: **public**

### getClass
Получение названия класса модели 

    string SleepingOwl\Admin\Model\ModelConfigurationManager::getClass()

* Доступ: **public**
* This method is defined by `SleepingOwl\Admin\Model\ModelConfigurationManager`

### getModel
Получение инстанса класса модели

    \Illuminate\Database\Eloquent\Model SleepingOwl\Admin\Model\ModelConfigurationManager::getModel()

* Доступ: **public**
* This method is defined by `SleepingOwl\Admin\Model\ModelConfigurationManager`


### getTitle
Получение заголовка раздела

    string SleepingOwl\Admin\Model\ModelConfigurationManager::getTitle()

* Доступ: **public**
* Метод определен в классе `SleepingOwl\Admin\Model\ModelConfigurationManager`

### getIcon
Получение иконки раздела

    string SleepingOwl\Admin\Model\ModelConfigurationManager::getIcon()

* Доступ: **public**
* Метод определен в классе `SleepingOwl\Admin\Model\ModelConfigurationManager`

### setIcon
Установка нового значения иконки

    \SleepingOwl\Admin\Model\ModelConfigurationManager SleepingOwl\Admin\Model\ModelConfigurationManager::setIcon(string $icon)

* Доступ: **public**
* Метод определен в классе `SleepingOwl\Admin\Model\ModelConfigurationManager`

### getAlias
Получение алиаса модели

    string SleepingOwl\Admin\Model\ModelConfigurationManager::getAlias()

* Доступ: **public**
* Метод определен в классе `SleepingOwl\Admin\Model\ModelConfigurationManager`

### getRepository
Получение объекта репозитория для данной модели

    \SleepingOwl\Admin\Contracts\RepositoryInterface SleepingOwl\Admin\Model\ModelConfigurationManager::getRepository()

* Доступ: **public**
* Метод определен в классе `SleepingOwl\Admin\Model\ModelConfigurationManager`

### getCreateTitle
Получение заголовка для страницы создания

    string|\Symfony\Component\Translation\TranslatorInterface SleepingOwl\Admin\Model\ModelConfigurationManager::getCreateTitle()

* Доступ: **public**
* Метод определен в классе `SleepingOwl\Admin\Model\ModelConfigurationManager`

### getEditTitle
Получение заголовка для страницы редактирования

    string|\Symfony\Component\Translation\TranslatorInterface SleepingOwl\Admin\Model\ModelConfigurationManager::getEditTitle()

* Доступ: **public**
* Метод определен в классе `SleepingOwl\Admin\Model\ModelConfigurationManager`

### can
Метод используется для проверки прав доступа (По умолчанию для проверки прав используется `Gate`). В данном методе
можно указать свои правила для проверки прав.

    boolean SleepingOwl\Admin\Model\ModelConfigurationManager::can(string $action, \Illuminate\Database\Eloquent\Model $model)

* Доступ: **public**
* Метод определен в классе `SleepingOwl\Admin\Model\ModelConfigurationManager`

### getControllerClass
Получение название класса контроллера

    null|string SleepingOwl\Admin\Model\ModelConfigurationManager::getControllerClass()

* Доступ: **public**
* Метод определен в классе `SleepingOwl\Admin\Model\ModelConfigurationManager`

* Доступ: **public**
* Метод определен в классе `SleepingOwl\Admin\Model\ModelConfigurationManager`

### getDisplayUrl
Получение ссылки на просмотр списка записей

    string SleepingOwl\Admin\Model\ModelConfigurationManager::getDisplayUrl(array $parameters)

* Доступ: **public**
* Метод определен в классе `SleepingOwl\Admin\Model\ModelConfigurationManager`

### getCreateUrl
Получение ссылки на форму создания записи

    string SleepingOwl\Admin\Model\ModelConfigurationManager::getCreateUrl(array $parameters)

* Доступ: **public**
* Метод определен в классе `SleepingOwl\Admin\Model\ModelConfigurationManager`

### getStoreUrl
Получение ссылки на страницу обработки данных и создания записи

    string SleepingOwl\Admin\Model\ModelConfigurationManager::getStoreUrl()

* Доступ: **public**
* Метод определен в классе `SleepingOwl\Admin\Model\ModelConfigurationManager`

### getEditUrl
Получение ссылки на форму редактирования записи

    string SleepingOwl\Admin\Model\ModelConfigurationManager::getEditUrl(string|integer $id)

* Доступ: **public**
* Метод определен в классе `SleepingOwl\Admin\Model\ModelConfigurationManager`

### getUpdateUrl
Получение ссылки на страницу обработки данных и обновления записи

    string SleepingOwl\Admin\Model\ModelConfigurationManager::getUpdateUrl(string|integer $id)

* Доступ: **public**
* Метод определен в классе `SleepingOwl\Admin\Model\ModelConfigurationManager`

### getDeleteUrl
Получение ссылки на страницу удаления записи

    string SleepingOwl\Admin\Model\ModelConfigurationManager::getDeleteUrl(string|integer $id)

* Доступ: **public**
* Метод определен в классе `SleepingOwl\Admin\Model\ModelConfigurationManager`

### getDestroyUrl
Получение ссылки на страницу окончательного удаления записи (в случае если запись помечена как удаленная) 

    string SleepingOwl\Admin\Model\ModelConfigurationManager::getDestroyUrl(string|integer $id)

* Доступ: **public**
* Метод определен в классе `SleepingOwl\Admin\Model\ModelConfigurationManager`

### getRestoreUrl
Получение ссылки на страницу восстановления записи

    string SleepingOwl\Admin\Model\ModelConfigurationManager::getRestoreUrl(string|integer $id)

* Доступ: **public**
* Метод определен в классе `SleepingOwl\Admin\Model\ModelConfigurationManager`


### getMessageOnCreate
Получение текста отображаемого после успешного создания записи

    string SleepingOwl\Admin\Model\ModelConfigurationManager::getMessageOnCreate()

* Доступ: **public**
* Метод определен в классе `SleepingOwl\Admin\Model\ModelConfigurationManager`

### getMessageOnUpdate
Получение текста отображаемого после успешного обновления записи

    string SleepingOwl\Admin\Model\ModelConfigurationManager::getMessageOnUpdate()

* Доступ: **public**
* Метод определен в классе `SleepingOwl\Admin\Model\ModelConfigurationManager`

### getMessageOnDelete
Получение текста отображаемого после успешного удаления записи

    string SleepingOwl\Admin\Model\ModelConfigurationManager::getMessageOnDelete()

* Доступ: **public**
* Метод определен в классе `SleepingOwl\Admin\Model\ModelConfigurationManager`

### getMessageOnRestore
Получение текста отображаемого после успешного восстановления записи

    string SleepingOwl\Admin\Model\ModelConfigurationManager::getMessageOnRestore()

* Доступ: **public**
* Метод определен в классе `SleepingOwl\Admin\Model\ModelConfigurationManager`


### getMessageOnDestroy
Получение текста отображаемого после успешного окончательного удаления записи (в случае если запись помечена как удаленная) 

    string SleepingOwl\Admin\Model\ModelConfigurationManager::getMessageOnDestroy()

* Доступ: **public**
* Метод определен в классе `SleepingOwl\Admin\Model\ModelConfigurationManager`


### addToNavigation
Добавление раздела в меню

    \SleepingOwl\Admin\Navigation\Page SleepingOwl\Admin\Model\ModelConfigurationManager::addToNavigation(integer $priority, string|\Closure|\KodiComponents\Navigation\Contracts\BadgeInterface $badge)

* Доступ: **public**
* Метод определен в классе `SleepingOwl\Admin\Model\ModelConfigurationManager`


##### Arguments
* $priority **integer** Приоритет вывода в списке
* $badge **string|Closure|KodiComponents\Navigation\Contracts\BadgeInterface** Текст или класс бейджа, который отображается рядом с пунктом меню (Например кол-во записей)

### creating
Событие срабатываемое в процессе создания записи (В случае если метод возвращает `false`, запись не будет создана)

     SleepingOwl\Admin\Model\ModelConfigurationManager::creating(Closure $callback)

* Доступ: **public**
* Метод определен в классе `SleepingOwl\Admin\Model\ModelConfigurationManager`

#### Arguments
* $callback **Closure|null** В функцию будет передан `ModelConfigurationInterface $config` и `\Illuminate\Database\Eloquent\Model $model`

### created
Событие срабатываемое после создания записи

     SleepingOwl\Admin\Model\ModelConfigurationManager::created(Closure $callback)

* Доступ: **public**
* Метод определен в классе `SleepingOwl\Admin\Model\ModelConfigurationManager`

#### Arguments
* $callback **Closure|null** В функцию будет передан `ModelConfigurationInterface $config` и `\Illuminate\Database\Eloquent\Model $model`


### updating
Событие срабатываемое в процессе обновления записи (В случае если метод возвращает `false`, запись не будет обновлена)

     SleepingOwl\Admin\Model\ModelConfigurationManager::updating(Closure $callback)

* Доступ: **public**
* Метод определен в классе `SleepingOwl\Admin\Model\ModelConfigurationManager`

#### Arguments
* $callback **Closure|null** В функцию будет передан `ModelConfigurationInterface $config` и `\Illuminate\Database\Eloquent\Model $model`

### updated
Событие срабатываемое после обновления записи

     SleepingOwl\Admin\Model\ModelConfigurationManager::updated(Closure $callback)

* Доступ: **public**
* Метод определен в классе `SleepingOwl\Admin\Model\ModelConfigurationManager`

#### Arguments
* $callback **Closure|null** В функцию будет передан `ModelConfigurationInterface $config` и `\Illuminate\Database\Eloquent\Model $model`

### deleting
Событие срабатываемое в процессе удаления записи (В случае если метод возвращает `false`, запись не будет удалена)

     SleepingOwl\Admin\Model\ModelConfigurationManager::deleting(Closure $callback)

* Доступ: **public**
* Метод определен в классе `SleepingOwl\Admin\Model\ModelConfigurationManager`

#### Arguments
* $callback **Closure|null** В функцию будет передан `ModelConfigurationInterface $config` и `\Illuminate\Database\Eloquent\Model $model`

### deleted
Событие срабатываемое после удаления записи

     SleepingOwl\Admin\Model\ModelConfigurationManager::deleted(Closure $callback)

* Доступ: **public**
* Метод определен в классе `SleepingOwl\Admin\Model\ModelConfigurationManager`

#### Arguments
* $callback **Closure|null** В функцию будет передан `ModelConfigurationInterface $config` и `\Illuminate\Database\Eloquent\Model $model`

### restoring
Событие срабатываемое в процессе восстановления записи (В случае если метод возвращает `false`, запись не будет восстановлена)

     SleepingOwl\Admin\Model\ModelConfigurationManager::restoring(Closure $callback)

* Доступ: **public**
* Метод определен в классе `SleepingOwl\Admin\Model\ModelConfigurationManager`

#### Arguments
* $callback **Closure|null** В функцию будет передан `ModelConfigurationInterface $config` и `\Illuminate\Database\Eloquent\Model $model`

### restored
Событие срабатываемое после восстановления записи

     SleepingOwl\Admin\Model\ModelConfigurationManager::restored(Closure $callback)

* Доступ: **public**
* Метод определен в классе `SleepingOwl\Admin\Model\ModelConfigurationManager`

#### Arguments
* $callback **Closure|null** В функцию будет передан `ModelConfigurationInterface $config` и `\Illuminate\Database\Eloquent\Model $model`
