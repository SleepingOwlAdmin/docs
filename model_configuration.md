# Конфигурация модели

Конфигурация моделей SleepingOwl Admin должны быть расположены в директории `bootstrapDirectory` (*по умолчанию: `app/admin`*).

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
        return AdminForm::panel()->addBody(
            AdminFormElement::text('title', 'Title')->required()->unique(),
            AdminFormElement::textarea('address', 'Address')->setRows(2),
            AdminFormElement::text('phone', 'Phone')
        );        
    });
})
    ->addMenuPage(Company::class, 0)
    ->setIcon('fa fa-bank');
```

По умолчанию раздел будет доступен по ссылке `admin/companies`, т.е. будет взято название класса в множественной форме. Для указания собственного пути, необходимо использовать метод `setAlias`

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

Бывают случаи, когда необходимо например запретить редактирование или удаление данных в разделе. Для этого целей существую специальные методы:

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

По умолчанию все пользователи имеют доступ к разделам админ панели. Если вы хотите настроить права доступа к каким-либо разделам вам необходимо в первую очередь включить проверку прав:

```php
AdminSection::registerModel(User::class, function (ModelConfiguration $model) {
    ...
    $model->enableAccessCheck();
    ...
});
```

После этого за проверку за каждое действие будет отвечать `Gate` https://laravel.com/docs/5.2/authorization#via-the-gate-facade

Как мы можем это использовать? В Laravel имеется для решения этой задачи отличное средство - `Policies` https://laravel.com/docs/5.2/authorization#policies

Поэтому необходимо создать класс, например, `App\Policies\UserPolicy`

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

Данный класс содержит методы вызываемые в момент проверки прав доступа к определенным опрациям, в первую очередь вызывается метод `before`, в котором производится глобальная проверка прав, если он возвращает true, то дальнейшая проверка не проводится, если ничего не возвращает, то дальше происходим вызов метода, отвечающего за конкретное действие и передается два параметра:
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

Теперь остается зарегистрировать policy в `App\Providers\AuthServiceProvider`

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
