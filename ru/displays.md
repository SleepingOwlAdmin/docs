# Типы отображения данных

 - [Таблица (Table)](#Таблица-table)     
 - [Расширения](#extend)
     - [Указание столбцов](#Указание-столбцов-Расширение)
     - [Фильтры столбцов](#Фильтры-столбцов-Расширение)
     - [Relations (Eager Loading)](#extension-with)
     - [Изменение запроса](#Изменение-запроса-Расширение)
     - [Использование scope](#Изменение-запроса-Расширение)
     - [Действия над документами Actions](#Действия-над-документами-actions-Расширение)
	 - [API](#api)	   
 - [Datatables](#datatables)
 - [Datatables Async](#datatablesasync)
 - [Tree](#tree)
 - [Расширение таблиц ](#Расширение-таблиц)
 - [Использование в форме ](#Использование-в-форме)


## Таблица (Table)
Таблицы предназначены для вывода списка документов раздела.

На данный момент поддерживаются следующие типы вывода данных:
 - `AdminDisplay::table()` - обычная таблица (`SleepingOwl\Admin\Display\DisplayTable`)
 - `AdminDisplay::datatables()` - таблица с выводом данных используя плагин https://datatables.net/ (`SleepingOwl\Admin\Display\DisplayDatatables`)
 - `AdminDisplay::datatablesAsync()` (`SleepingOwl\Admin\Display\DisplayDatatablesAsync`)
 - `AdminDisplay::tree()` - вывод данных в виде дерева (`SleepingOwl\Admin\Display\DisplayTree`)

**Пример использования:**
```php
$model->onDisplay(function () {
    $display = AdminDisplay::table();
    
    ...
    
    return $display;
});
```


### Указание столбцов (Расширение)
`SleepingOwl\Admin\Display\Extension\Columns`

Типы столбцов и их описание можно посмотреть [здесь](columns)

```php
$display->setColumns([
  ...
  AdminColumn::link('title')->setLabel('Title'),
  AdminColumn::datetime('created_at')->setLabel('Created')->setFormat('d.m.Y'),
  ...
]);

// or 

$display->getColumns()->push(
  AdminColumn::text('title')
);
```


<a name="extension-column-filters"></a>
### Фильтры столбцов (Расширение)
`SleepingOwl\Admin\Display\Extension\ColumnFilters`

```php
$display->setColumnFilters([
  ...
  AdminColumnFilter::text()->setPlaceholder('Full Name'),
  ...
]);

// or 

$display->getColumnFilters()->push(
  AdminColumnFilter::text()->setPlaceholder('Full Name')
);
```

<a name="extension-with"></a>
### Eager Loading
Позволяет оптимизировать запросы к БД в случае использования связей с
другими моделями.
[Подробности](https://laravel.com/docs/5.2/eloquent-relationships#eager-loading)

```php
$display->with('country', 'companies');
```

<a name="extension-apply"></a>
### Изменение запроса (Расширение)
`SleepingOwl\Admin\Display\Extension\Apply`

Вы можете изменять запрос по желанию

```php
$display->setApply(function ($query) {
    $query->orderBy('title', 'asc');
});

// or 

$display->setApply([
  ...
  function ($query) {
      $query->orderBy('title', 'asc');
  },
  ...
]);

// or

$display->getApply()->push(function ($query) {
    $query->orderBy('title', 'asc');
});
```

<a name="extension-scope"></a>
### Использование scope (Расширение)
`SleepingOwl\Admin\Display\Extension\Scopes`

Вы можете применить [Eloquent scopes](https://laravel.com/docs/eloquent#query-scopes) к выводимым данным:

```php
$display->setScopes('last');

//or

$display->setScopes(['last', 'trashed']);

// or

$display->getScopes()->push('last');
```

<a name="extension-actions"></a>
### Действия над документами Actions (Расширение)
`SleepingOwl\Admin\Display\Extension\Actions`

Использует тип колонки таблицы [Action](columns#action)

```php
$table = AdminDisplay::table()
    ->setActions([
        AdminColumn::action('export', 'Export')->setIcon('fa fa-share')->setAction(route('news.export')),
    ])
    ->setColumns([
        AdminColumn::checkbox(),
        ...
    ]);

// Изменить разсположение положения кнопок на странице
$table->getActions()
    ->setPlacement('panel.buttons')
    ->setHtmlAttribute('class', 'pull-right');
```


## Api

В классах таблиц используется трейт:
 - [HtmlAttributes](html_attributes), с помощью которого для них можно настраивать HTML атрибуты.
 - [Assets](assets#assets-trait), с помощью которого для них можно подключать ассеты.

### Методы доступные во всех типах

#### extend
Добавление нового расширения к виду

    SleepingOwl\Admin\Display\Display::extend(string $name, \SleepingOwl\Admin\Contracts\Display\DisplayExtensionInterface $extension): return $extension

#### getExtensions
Получение списка всех расширений

    SleepingOwl\Admin\Display\Display::getExtensions() return \Illuminate\Support\Collection|array<mixed,\SleepingOwl\Admin\Contracts\Display\DisplayExtensionInterface>
    
#### with
[Eager loading](https://laravel.com/docs/5.2/eloquent-relationships#eager-loading)

    SleepingOwl\Admin\Display\Display::with(array|array<mixed,string> $relations): return self
    
#### setTitle
Указание заголовка для таблиц

    SleepingOwl\Admin\Display\Display::setTitle(string $title): return self
    
#### setNewEntryButtonText
Указание заголовка кнопки добавления записи

    SleepingOwl\Admin\Display\DisplayTable::setNewEntryButtonText(string $title): return self

#### setView
Изменения шаблона вывода данных

    SleepingOwl\Admin\Display\Display::setView(string|\Illuminate\View\View $view): return self
    
```php
$table->setView(view('display.custom.table.view'));

// Будет произведен поиск по пути sleeping_owl::default.display.custom.table.view
$table->setView('display.custom.table.view');
```

#### getActions
Получение объекта расширения

    SleepingOwl\Admin\Display\Display::getActions(): return SleepingOwl\Admin\Display\Extension\Actions

```php
$actions = $table->getActions();

$actions->setHtmlAttribite('class', 'custm-class');

$actions->push(AdminColumn::action());

// Установка места вывода кнопок
$actions->setPlacement(...);
```

#### setActions

    SleepingOwl\Admin\Display\Display::setActions(array|...SleepingOwl\Admin\Contracts\ActionInterface): return self


#### getApply
Получение объекта расширения

    SleepingOwl\Admin\Display\Display::getApply(): return SleepingOwl\Admin\Display\Extension\Apply
    
#### setApply

    SleepingOwl\Admin\Display\Display::setApply(array|...\Closure): return self
    

#### getScopes
Получение объекта расширения

    SleepingOwl\Admin\Display\Display::getScopes(): return SleepingOwl\Admin\Display\Extension\Scopes
    
#### setScopes

    SleepingOwl\Admin\Display\Display::setScopes(array|...(string|array)): return self

#### getFilters
Получение объекта расширения

    SleepingOwl\Admin\Display\Display::getFilters(): return SleepingOwl\Admin\Display\Extension\Filters
    
#### setFilters

    SleepingOwl\Admin\Display\Display::setFilters(array|...SleepingOwl\Admin\Contracts\FilterInterface): return self
    
#### setRepositoryClass
Переопределение класса репозитория. (Класс должен реализовывать интерфейс `SleepingOwl\Admin\Contracts\RepositoryInterface`)

    SleepingOwl\Admin\Display\Display::setRepositoryClass(string $repository): return self
    
    
## table()
`SleepingOwl\Admin\Display\DisplayTable`

#### setParameters
Передача в URL кнопки создания новой записи дополнительных параметров

    SleepingOwl\Admin\Display\DisplayTable::setParameters(array $parameters): return self
    
#### setParameter
Передача в URL кнопки создания новой записи дополнительного параметра

    SleepingOwl\Admin\Display\DisplayTable::setParameter(string $key, mixed $value): return self
    
#### paginate
Вывод данных с постраничной навигацией

    SleepingOwl\Admin\Display\DisplayTable::paginate(integer $perPage, string $pageName): return self
    
```php
$table->paginate(20, 'custom_page');
```
    
#### disablePagination
Отключение постраничной навигации

    SleepingOwl\Admin\Display\DisplayTable::disablePagination(): return self

#### usePagination
Проверка на использование постраничной навигации

    SleepingOwl\Admin\Display\DisplayTable::usePagination(): return boolean
    
#### getColumns
Получение объекта расширения

    SleepingOwl\Admin\Display\DisplayTable::getColumns(): return SleepingOwl\Admin\Display\Extension\Columns

```php
$columns = $table->getColumns();

$columns->push(AdminColumn::text());

$columns->setControlColumn(new \App\Display\Columns\CustomControlColumn());

$columns->setView(...);
```
    
#### setColumns
Указание списка столбцов для выводимой таблицы. В качестве аргумента можно передать как массив колонок так и объект `SleepingOwl\Admin\Contracts\ColumnInterface`

    SleepingOwl\Admin\Display\DisplayTable::setColumns(array|...SleepingOwl\Admin\Contracts\ColumnInterface): return self
    
```php
$table->setColumns(AdminColumn::text(...), AdminColumn::datetime(..));


$table->setColumns([
    AdminColumn::text(), 
    AdminColumn::datetime(..)
]);
```
    
#### getColumnFilters
Получение объекта расширения

    SleepingOwl\Admin\Display\DisplayTable::getColumnFilters(): return SleepingOwl\Admin\Display\Extension\ColumnFilters
    
```php
$filters = $table->geColumnFilters();

$filters->push(AdminColumnFilter::text());

$filters->setPlacement(...);
```

#### setColumnFilters

    SleepingOwl\Admin\Display\DisplayTable::setColumnFilters(array|...SleepingOwl\Admin\Contracts\ColumnFilterInterface): return self
    
#### setColumnsTotal
Вывод строки в таблице для агрегации результатов:

    SleepingOwl\Admin\Display\DisplayTable::setColumns(array|...SleepingOwl\Admin\Contracts\ColumnInterface): return self
    
```php
$table->setColumnsTotal([
        'Total: ', 
        '<number_total>',
        ...
    ],
    $table->getColumns()->all()->count()
);
```
Вторым параметром добавляем количество столбцов в таблице.

Для того, чтобы применить фильтр для текущей query можно сделать следующий запрос:

```php
$totalQuery = <Model>::query();
$table->getFilters()->initialize();
$table->getFilters()->modifyQuery($totalQuery);
```

Из **$totalQuery** уже можно скомпоновать агрегированные данные

#### getColumnsTotal
Получение объекта расширения с выводом агрегированной строки внизу таблицы

```php
$display->getColumnsTotal()->setPlacement('table.footer')
```



## datatables()
`SleepingOwl\Admin\Display\DisplayDatatables`

#### setDatatableAttributes
Указание параметров для таблицы

    SleepingOwl\Admin\Display\DisplayDatatables::setDatatableAttributes(array $datatableAttributes): return self
    
#### setOrder
Указание правила сортировки данных. https://datatables.net/examples/basic_init/table_sorting.html

    SleepingOwl\Admin\Display\DisplayDatatables::setOrder(array $order): return self
    
```php
$display->setOrder([[1, 'asc']]);
```

<a name="datatables-async"></a>
## datatablesAsync()
`SleepingOwl\Admin\Display\DisplayDatatablesAsync`


#### setName

    SleepingOwl\Admin\Display\DisplayDatatablesAsync::setName(string $name): return self
    
#### setDistinct

    SleepingOwl\Admin\Display\DisplayDatatablesAsync::setDistinct(boolean $distinct): return self


## tree()
`SleepingOwl\Admin\Display\DisplayTree`

Используется для вывода данных в виде дерева с поддержкой сортировки (drag & drop). Данный вид поддерживает работу с https://github.com/etrepat/baum, https://github.com/lazychaser/laravel-nestedset, а также самый простой вариант, когда дерево строится на основе `parent_id` (Также в таблице должно быть поле `order` для сортировки)

**Использование других библиотек работы с деревом:**
При использовании etrepat/baum возможны проблемы с наследованием секций связанными с моделью Дерева.

Для решения рассмотрим пример использования другой ветки https://github.com/gazsp/baum.
За работу с каждым типом дерева отвечает отдельный класс https://github.com/LaravelRUS/SleepingOwlAdmin/tree/development/src/Display/Tree

Для поддержки своего типа дерева необходимо добавить свой класс, для удобства его можно наследовать от SleepingOwl\Admin\Display\Tree\NestedsetType и реализовать те методы, которые он попросит. 

В случае использования gazsp/baum метод получения всего дерева с сортировкой по левому индексу будет отличаться от etrepat/baum и наш класс будет выглядеть так:

```php
<?php

namespace Admin\Tree;

use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Display\Tree\BaumNodeType;

/**
 * @see https://github.com/etrepat/baum
 */
class CustomBaumNodeType extends BaumNodeType
{
    /**
     * Get tree structure.
     *
     * @param \Illuminate\Database\Eloquent\Collection $collection
     *
     * @return mixed
     */
    public function getTree(\Illuminate\Database\Eloquent\Collection $collection)
    {
        return $collection->toSortedHierarchy();
    }
}
```
А дальше при инициализации DisplayTree мы указываем этот класс
```
AdminDisplay::tree(\Admin\Tree\CustomBaumNodeType::class)->...
```

**Сортировка:**
Данный класс регистрирует роут `admin.display.tree.reorder`, который отвечает за сортировку данных. При необходимости вы можете переопределить данный роут в `app/Admin/routes.php`.

```php
Route::post('{adminModel}/reorder', ['as' => 'admin.display.tree.reorder', function (ModelConfigurationInterface $model) {
    if ($model->getClass() == 'App\Post') {
        // ...
    } else {
        $model->fireDisplay()->getRepository()->reorder(
              Request::input('data')
        );
   }
}]);
```

**При добавлении дерева в таб может некорректно работать сортировка**





#### setValue
Указание заголовка для документов

    SleepingOwl\Admin\Display\DisplayTree::setValue(string $value): return self
    
#### setParentField
Указание ключа поля

    SleepingOwl\Admin\Display\DisplayTree::setParentField(string $parentField): return self
    
#### setOrderField
Указание ключа поля

    SleepingOwl\Admin\Display\DisplayTree::setOrderField(string $orderField): return self

#### setRootParentId

    SleepingOwl\Admin\Display\DisplayTree::setRootParentId(null|string $rootParentId): return self
    
#### setParameters
Передача в URL кнопки создания новой записи дополнительных параметров

    SleepingOwl\Admin\Display\DisplayTree::setParameters(array $parameters): return self
    
#### setParameter
Передача в URL кнопки создания новой записи дополнительного параметра

    SleepingOwl\Admin\Display\DisplayTree::setParameter(string $key, mixed $value): return self
    
#### setReorderable

    SleepingOwl\Admin\Display\DisplayTree::setReorderable(boolean $reorderable): return self
    
#### getTree
Получение объекта расширения (На данный момент не используется)

    SleepingOwl\Admin\Display\DisplayTree::getTree(): return SleepingOwl\Admin\Display\Extension\Tree
    
#### setRepositoryClass
Переопределение класса репозитория. (Класс должен реализовывать интерфейс `SleepingOwl\Admin\Contracts\TreeRepositoryInterface`)

    SleepingOwl\Admin\Display\DisplayTree::setRepositoryClass(string $repository): return self
    
<a name="extend"></a>
## Расширение таблиц
Класс `SleepingOwl\Admin\Display\Display` от которого наследуются все классы реализующие вывод данных позволяет расширять свое поведение. Расширения могут как влиять на вывод данных, модифицируя запрос перед получением списка записей из БД либо вывод HTML кода в шаблон.

Сейчас класс для вывода таблицы работает полностью за счет расширений, а именно, вызывая метод `setColumns` или `getColumns`, `setColumnFilters` или `getColumnFilters` вы обращаетесь к классам расширений.

#### Как использовать:
Использовать расширения можно как при создании нового типа `Display`, так и с существующими типами.

**Для работы расширений необходимо свой класс наследовать от `SleepingOwl\Admin\Display\Display`. Класс расширения должен реализовывать интерфейс `SleepingOwl\Admin\Contracts\Display\DisplayExtensionInterface`**

**Пример нового класса:**

```php
// Новый класс
namespace App\Display;

class CustomDisplay extends \SleepingOwl\Admin\Display\Display 
{
    /**
     * Display constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->extend('custom_extension', new \App\Display\Extension\CustomExtension());
    }
}
```

**Пример добавления расширения для существующего типа:**

```php
$display = AdminDisplay::table();
$display->extend('custom_extension', new \App\Display\Extension\CustomExtension());
```

После инициализации расширения работа с ним осуществляется следующим образом:

```php
// Получение объекта
$table->getCustomExtension()->...

// В случае если в классе расширения определен метод set(), возможна передача в него данных
$table->setCustomExtension(...)
```

Расширения делятся на два типа:
 - Модификация запроса 
 - Вывод HTML кода в шаблон Display
    - При реализации интерфейса `Illuminate\Contracts\Support\Renderable` вывод будет выполнен в общем стеке расширений
    - При реализации интерфейса `SleepingOwl\Admin\Contracts\Display\Placable` вывод будет выполнен в месте указанном в методе `getPlacement`

<a name="extend-query"></a>
### Модификация запроса
По умолчанию любое расширение может модифицировать запрос, который выполняет класс Display перед выводом данных. В момент выполнения запроса происходит вызов метода `modifyQuery` во всех расширениях и передача в него объекта `\Illuminate\Database\Eloquent\Builder`.

**Пример**
```php
public function modifyQuery(\Illuminate\Database\Eloquent\Builder $query)
{
    $query->orderBy('column', 'desc');
}
```


### Вывод HTML

Если расширение реализует интерфейс `Illuminate\Contracts\Support\Renderable`, то будет произведен вывод расширения в общем стеке расширений, т.е. для всех расширений будет последовательно вызван метод `render` https://github.com/LaravelRUS/SleepingOwlAdmin/blob/development/resources/views/default/display/table.blade.php#L28
Перед выводом происходит сортировка расширений по значению, взятому из метода `getOrder`

Если расширение реализует интерфейс `SleepingOwl\Admin\Contracts\Display\Placable`, то HTML код расширения будет помещен в определенном месте, указанном в методе `getPlacement`

Места, где можно разместить код реализованы через `@yield`
https://github.com/LaravelRUS/SleepingOwlAdmin/blob/development/resources/views/default/display/table.blade.php


## Использование в форме
При необходимости таблицу можно использовать в форме для вывода связанных записей.

Допустим у нас есть галерея (раздел `Gallery`) и фотографии в ней (`Photo`). У каждой фотографии есть `category_id` - идентификатор категории. После создания категории, в форме редактирования нужна возможность добавлять фотографии в эту категорию.

```php
// Create And Edit
$model->onCreateAndEdit(function($id = null) {

    $form = AdminForm::panel()->addHeader(
        AdminFormElement::text('title', 'Название галереи')->required(),
    );
    
    if (!is_null($id)) { // Если галерея создана и у нее есть ID
        $photos = AdminDisplay::table()
            ->setModelClass(Photo::class) // Обязательно необходимо указать класс модели в которой хранятся фотографии
            ->setApply(function($query) use($id) {
                $query->where('category_id', $id); // Фильтруем список фотографий по ID галереи
            })
            ->setParameter('category_id', $id) // При нажатии на кнопку "добавить" - подставлять идентификатор галереи
            ->setColumns(
                AdminColumn::link('name', 'Назавние фотографии'),
                AdminColumn::image('thumb', 'Фотгорафия')
                    ->setHtmlAttribute('class', 'text-center')
                    ->setWidth('100px')
            )
        
        $form->addBody($photos);
    }
});
```
