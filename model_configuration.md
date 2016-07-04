# Конфигурация модели

Конфигурация моделей SleepingOwl Admin должны быть расположены в директории, которая указывается в конфиге `sleeping_owl.bootstrapDirectory` (*по умолчанию: `app/admin`*).

Вы можете хранить конфигурацию моделей в одном файле или разделить на несколько по желанию.

Ниже приведен пример того, как может выглядеть конфигурация модели:

```php
AdminSection::registerModel(Company::class, function (ModelConfiguration $model) {
    $model->setTitle('Companies');
    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::table()->setColumns([
            AdminColumn::link('title')->setLabel('Title')->setWidth('400px'),
            AdminColumn::text('address')->setLabel('Address')->setAttribute('class', 'text-muted'),
        ]);
        $display->paginate(15);
        return $display;
    });
    // Create And Edit
    $model->onCreateAndEdit(function() {
        return $form = AdminForm::panel()->addBody(
            AdminFormElement::text('title', 'Title')->required()->unique(),
            AdminFormElement::textarea('address', 'Address')->setRows(2),
            AdminFormElement::text('phone', 'Phone')
        );
        return $form;
    });
})
    ->addMenuPage(Company::class, 0)
    ->setIcon('fa fa-bank');
```

По умолчанию раздел будет доступен по ссылке `admin/companies`, т.е. будет взяно название класса в множественной форме. Для указания собственного пути, необходимо использовать метод `setAlias`

```php
...
$model->setAlias('subdir/companies');
...
```

## Всплывающие сообщения при совершении действий

Вы можете изменить текст сообщений, который отображается при добавлении, редактировании и удалении записи.

```php
AdminSection::registerModel(Company::class, function (ModelConfiguration $model) { 

    // Создание записи
    $model->setMessageOnCreate('Company created');
   
    // Редактирование записи
    $model->setMessageOnUpdate('Company updated');
    
    // Удаление записи
    $model->setMessageOnDelete('Company deleted');
   
    // Восстановление записи
    $model->setMessageOnRestore('Company restored');
});
```

## Запрет на выполнение действий.

Бывают случаи когда необходимо например запретить редактирование или удаление данных в разделе. Для этого целей существую специальные методы:

```php
AdminSection::registerModel(Company::class, function (ModelConfiguration $model) { 
    // Запрет на просмотр
    $model->disableDisplay();
    
    // Запрет на создание
    $model->disableCreating();
    
    // Запрет на редактирование
    $model->disableEditing();
    
    // Запрет на удаление
    $model->disableDeleting();
    
    // Запрет на восстановление
    $model->disableRestoring();
})
```

## Ограничение прав доступа

По умолчанию все пользователи имеют доступ к разделам админ панели. Если вы хотите настроить права доступа к каким либо разделам вам необходимо в первую очередь включить проверку прав

```php
AdminSection::registerModel(User::class, function (ModelConfiguration $model) {
    ...
    $model->enableAccessCheck();
    ...
});
```

После этого за проверку за каждое действие будет отвечать `Gate` https://laravel.com/docs/5.2/authorization#via-the-gate-facade

Как мы можем это использовать? В Laravel имеется для решения этой задачи отличное средство - `Policies` https://laravel.com/docs/5.2/authorization#policies

Поэтому необходимо создать класс, например `App\Policies\UserPolicy`

```php
<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{

    use HandlesAuthorization;

    /**
     * @param User   $user
     * @param string $ability
     *
     * @return bool
     */
    public function before(User $user, $ability, User $item)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    /**
     * @param User $user
     * @param User $item
     *
     * @return bool
     */
    public function display(User $user, User $item)
    {
        return true;
    }

    /**
     * @param User $user
     * @param User $item
     *
     * @return bool
     */
    public function create(User $user, User $item)
    {
        return true;
    }

    /**
     * @param User $user
     * @param User $item
     *
     * @return bool
     */
    public function edit(User $user, User $item)
    {
        return true;
    }

    /**
     * @param User $user
     * @param User $item
     *
     * @return bool
     */
    public function delete(User $user, User $item)
    {
        return true;
    }

    /**
     * @param User $user
     * @param User $item
     *
     * @return bool
     */
    public function restore(User $user, User $item)
    {
        return true;
    }
}

```

Данный класс содержит методы вызываемые в момент проверки прав доступа к определенным опреациям, в первую очередь вызывается метод `before`, в котором производится глобальная проверка прав, если он возвращает true, то дальнейшая проверка не проводится, если ничего не возвращает, то дальше происходим вызов метода, отвечающего за конкретное действие и передается два параметра:
  - Объект текущего пользователя
  - Объект для которого нужно проверить права доступа
  - 
Например если мы хотим чтобы пользователь мог создавать записи и редактировать только свои записи в блоге:
```php
public function create(User $user, Post $post)
{
    return true;
}

public function edit(User $user, Post $post)
{
    return $post->isAutoredBy($user);
}
```

Теперь остается зарегестрировать policy в `App\Providers\AuthServiceProvider`

```php
protected $policies = [
    ...
    \App\User::class => \App\Policies\UserPolicy::class
    ...
];
```

После чего раздел будет использовать этот policy для проверки прав доступа.

Данный механизм позволяет очень гибко настраивать права доступа к каждому разделу.

## События

У вас есть возможность подписаться на события создания, редактирования, удаления и восстановления записей в разделе.

```php
AdminSection::registerModel(Company::class, function (ModelConfiguration $model) { 

    // Создание записи
    $model->creating(function(ModelConfiguration $model, Company $company) {
        // Если вернуть false, то создание будет прервано
    });
    
    $model->created(function(ModelConfiguration $model, Company $company) {
    
    });
    
    // Обновление записи
    $model->updating(function(ModelConfiguration $model, Company $company) {
        // Если вернуть false, то обновление будет прервано
    });
    
    $model->updated(function(ModelConfiguration $model, Company $company) {
    
    });
    
    // Удаление записи
    $model->deleting(function(ModelConfiguration $model, Company $company) {
        // Если вернуть false, то удаление будет прервано
    });
    
    $model->deleted(function(ModelConfiguration $model, Company $company) {
    
    });
    
    // Восстановление записи
    $model->restoring(function(ModelConfiguration $model, Company $company) {
        // Если вернуть false, то восстановление будет прервано
    });
    
    $model->restored(function(ModelConfiguration $model, Company $company) {
    
    });
});
```

Также чисто теоретически можно подписаться на событие следующим образом

```php
Even::listen('sleeping_owl.section.updating:'.Company::class, function(ModelConfiguration $model, Company $company) {

});
```

## Переопределение контроллера

В случае если вы хотите использовать собственный контроллер используйте метод `setControllerClass`

```php
AdminSection::registerModel(User::class, function (ModelConfiguration $model) {
    ...
    $model->setControllerClass(UserController::class);
    ...
});
```

```php
namespace App\Http\Controllers;

class UserController extends \SleepingOwl\Admin\Http\Controllers\AdminController
{
    ...
}
```

# API (Доступные методы)

### setAlias
Установка алиаса ссылки для раздела *(По умолчанию название класса модели во множественном числе)*

    \SleepingOwl\Admin\Model\ModelConfiguration SleepingOwl\Admin\Model\ModelConfiguration::setAlias(string $alias)

```php
$model->setAlias('manage/user');
```

### setTitle
Установка заголовка для раздела *(По умолчанию название класса модели во множественном числе)*

    \SleepingOwl\Admin\Model\ModelConfiguration SleepingOwl\Admin\Model\ModelConfiguration::setTitle(string $title)


### setCreateTitle
Установка заголовка для страницы создания

    \SleepingOwl\Admin\Model\ModelConfiguration SleepingOwl\Admin\Model\ModelConfiguration::setCreateTitle(string $title)

### setUpdateTitle
Установка заголовка для страницы редактирования

    \SleepingOwl\Admin\Model\ModelConfiguration SleepingOwl\Admin\Model\ModelConfiguration::setUpdateTitle(string $title)

### onDisplay
Описание данных для вывода списка записей на страницы 

    \SleepingOwl\Admin\Model\ModelConfiguration SleepingOwl\Admin\Model\ModelConfiguration::onDisplay(\Closure $callback)

### onCreate
Описание формы для страницы создания записи (Форму редактирования необходимо будет описывать отдельно)

    \SleepingOwl\Admin\Model\ModelConfiguration SleepingOwl\Admin\Model\ModelConfiguration::onCreate(\Closure|null $callback)

### onEdit
Описание формы для страницы редактирования записи (Форму создания необходимо будет описывать отдельно)

    \SleepingOwl\Admin\Model\ModelConfiguration SleepingOwl\Admin\Model\ModelConfiguration::onEdit(\Closure|null $callback)

##### Arguments
* $callback **Closure|null** В функцию будет передан идентификатор записи


### onCreateAndEdit
Описание формы для страницы создания и редактирования записи

    \SleepingOwl\Admin\Model\ModelConfiguration SleepingOwl\Admin\Model\ModelConfiguration::onCreateAndEdit(\Closure|null $callback)

##### Arguments
* $callback **Closure|null** В функцию будет передан идентификатор записи


### onDelete
Код, который будет выполнен в момент удаления записи

    \SleepingOwl\Admin\Model\ModelConfiguration SleepingOwl\Admin\Model\ModelConfiguration::onDelete(\Closure|null $callback)

##### Arguments
* $callback **Closure|null** В функцию будет передан идентификатор записи


### onDestroy
Код, который будет выполнен в момент окончательного удаления записи (в случае если запись помечена как удаленная)

    \SleepingOwl\Admin\Model\ModelConfiguration SleepingOwl\Admin\Model\ModelConfiguration::onDestroy(\Closure|null $callback)

##### Arguments
* $callback **Closure|null** В функцию будет передан идентификатор записи

### onRestore
Код, который будет выполнен в момент восстановления записи

    \SleepingOwl\Admin\Model\ModelConfiguration SleepingOwl\Admin\Model\ModelConfiguration::onRestore(\Closure|null $callback)

##### Arguments
* $callback **Closure|null** В функцию будет передан идентификатор записи


### disableDisplay
Запрет страницы просмотра списка записей раздела

    \SleepingOwl\Admin\Model\ModelConfiguration SleepingOwl\Admin\Model\ModelConfiguration::disableDisplay()


### disableCreating
Запрет создания записей

    \SleepingOwl\Admin\Model\ModelConfiguration SleepingOwl\Admin\Model\ModelConfiguration::disableCreating()

### disableEditing
Запрет редактирования записей

    \SleepingOwl\Admin\Model\ModelConfiguration SleepingOwl\Admin\Model\ModelConfiguration::disableEditing()

### disableDeleting
Запрет удаления записей

    \SleepingOwl\Admin\Model\ModelConfiguration SleepingOwl\Admin\Model\ModelConfiguration::disableDeleting()


### disableDestroying
Запрет окончательного удаления записей (в случае если запись помечена как удаленная)

    \SleepingOwl\Admin\Model\ModelConfiguration SleepingOwl\Admin\Model\ModelConfiguration::disableDestroying()

### disableRestoring
Запрет восстановления записей

    \SleepingOwl\Admin\Model\ModelConfiguration SleepingOwl\Admin\Model\ModelConfiguration::disableRestoring()


### enableAccessCheck
Включение проверки прав доступа для раздела (Для проверки прав доступа используется `Gate`. По умолчанию доступ запрещен для всех)

    \SleepingOwl\Admin\Model\ModelConfiguration SleepingOwl\Admin\Model\ModelConfiguration::enableAccessCheck()

### disableAccessCheck
Выключение проверки прав доступа

    \SleepingOwl\Admin\Model\ModelConfiguration SleepingOwl\Admin\Model\ModelConfiguration::disableAccessCheck()

### setMessageOnCreate
Установка текста сообщения отображаемого после создания записи

    mixed SleepingOwl\Admin\Model\ModelConfiguration::setMessageOnCreate(string $messageOnCreate)

### setMessageOnUpdate
Установка текста сообщения отображаемого после обновления записи

    \SleepingOwl\Admin\Model\ModelConfiguration SleepingOwl\Admin\Model\ModelConfiguration::setMessageOnUpdate(string $messageOnUpdate)

### setMessageOnDelete
Установка текста сообщения отображаемого после удаления записи

    \SleepingOwl\Admin\Model\ModelConfiguration SleepingOwl\Admin\Model\ModelConfiguration::setMessageOnDelete(string $messageOnDelete)

### setMessageOnDestroy
Установка текста сообщения отображаемого после окончательного удаления записи (в случае если запись помечена как удаленная)

    \SleepingOwl\Admin\Model\ModelConfiguration SleepingOwl\Admin\Model\ModelConfiguration::setMessageOnDestroy(string $messageOnDestroy)

### setMessageOnRestore
Установка текста сообщения отображаемого после восстановления записи

    \SleepingOwl\Admin\Model\ModelConfiguration SleepingOwl\Admin\Model\ModelConfiguration::setMessageOnRestore(string $messageOnRestore)


### setControllerClass
Установка названия класса, который будет использован для работы с данными раздела

    \SleepingOwl\Admin\Model\ModelConfiguration SleepingOwl\Admin\Model\ModelConfiguration::setControllerClass(string $controllerClass)

### setIcon
Установка иконки для раздела (Будет отображаться в меню)

    \SleepingOwl\Admin\Model\ModelConfigurationManager SleepingOwl\Admin\Model\ModelConfigurationManager::setIcon(string $icon)


### addToNavigation
Добавление раздела в меню

    \SleepingOwl\Admin\Navigation\Page SleepingOwl\Admin\Model\ModelConfigurationManager::addToNavigation(integer $priority, string|\Closure|\KodiComponents\Navigation\Contracts\BadgeInterface $badge)

##### Arguments
* $priority **integer** Приоритет вывода в списке
* $badge **string|Closure|KodiComponents\Navigation\Contracts\BadgeInterface** Текст или класс бейджа, который отображается рядом с пунктом меню (Например кол-во записей)

### creating
Событие срабатываемое в процессе создания записи (В случае если метод возвращает false, запись не будет создана) 

     SleepingOwl\Admin\Model\ModelConfigurationManager::creating(Closure $callback)

##### Arguments
* $callback **Closure|null** В функцию будет передан `ModelConfigurationInterface $config` и `\Illuminate\Database\Eloquent\Model $model`

### created
Событие срабатываемое после создания записи

     SleepingOwl\Admin\Model\ModelConfigurationManager::created(Closure $callback)

##### Arguments
* $callback **Closure|null** В функцию будет передан `ModelConfigurationInterface $config` и `\Illuminate\Database\Eloquent\Model $model`

### updating
Событие срабатываемое в процессе обновления записи (В случае если метод возвращает false, запись не будет обновлена)

     SleepingOwl\Admin\Model\ModelConfigurationManager::updating(Closure $callback)

##### Arguments
* $callback **Closure|null** В функцию будет передан `ModelConfigurationInterface $config` и `\Illuminate\Database\Eloquent\Model $model`

### updated
Событие срабатываемое после обновления записи

     SleepingOwl\Admin\Model\ModelConfigurationManager::updated(Closure $callback)

### deleting
Событие срабатываемое в процессе удаления записи (В случае если метод возвращает false, запись не будет удалена)

     SleepingOwl\Admin\Model\ModelConfigurationManager::deleting(Closure $callback)

##### Arguments
* $callback **Closure|null** В функцию будет передан `ModelConfigurationInterface $config` и `\Illuminate\Database\Eloquent\Model $model`

### deleted
Событие срабатываемое после удаления записи

     SleepingOwl\Admin\Model\ModelConfigurationManager::deleted(Closure $callback)

##### Arguments
* $callback **Closure|null** В функцию будет передан `ModelConfigurationInterface $config` и `\Illuminate\Database\Eloquent\Model $model`

### restoring
Событие срабатываемое в процессе восстановления записи (В случае если метод возвращает false, запись не будет восстановлена)

     SleepingOwl\Admin\Model\ModelConfigurationManager::restoringClosure $callback)

##### Arguments
* $callback **Closure|null** В функцию будет передан `ModelConfigurationInterface $config` и `\Illuminate\Database\Eloquent\Model $model`

### restored
Событие срабатываемое после восстановления записи

     SleepingOwl\Admin\Model\ModelConfigurationManager::restored(Closure $callback)

##### Arguments
* $callback **Closure|null** В функцию будет передан `ModelConfigurationInterface $config` и `\Illuminate\Database\Eloquent\Model $model`
