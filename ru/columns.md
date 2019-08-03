# Столбцы

- [Введение](#Введение)
- [Поддерживаемые типы](#Поддерживаемые-типы-types)
- [Заголовок столбца](#Заголовок-столбца)
- [API](#api)
- [Типы](#Типы)
    - [Action](#action)
    - [Checkbox](#checkbox) 
    - [Checkbox Inline Editable](#checkbox-editable)    
    - [Count](#count)
    - [Custom](#custom)
    - [DateTime](#datetime)    
    - [Link](#link)
    - [RelatedLink](#related-link)
    - [Url](#url)
    - [Text](#text)
    - [Count](#count)
    - [Email](#email)
    - [Image](#image)
    - [Lists](#lists)
    - [Order](#order)
    - [Control](#control)
- [Работа с Relation данными](#Работа-с-relation-данными)


*Расширение для класса [отображения данных](displays)*



## Введение

Данные классы предназначены для добавления колонок в таблицу, а также вывода информации из модели в форме редактирования.

**Пример использования**

```php
AdminDisplay::table()
    ->setColumns([
        AdminColumn::link('title')->setLabel('Title'),
        AdminColumn::datetime('date')->setLabel('Date')->setFormat('d.m.Y')->setWidth('150px')
    ])
```

```php
AdminForm::panel()
    ->addBody([
        AdminColumn::datetime('date')->setLabel('Date')->setFormat('d.m.Y')
    ])
```

Класс `SleepingOwl\Admin\Display\TableColumn`, от которого наследуются
все столбцы, реализует интерфейсы `Illuminate\Contracts\Support\Arrayable`,
`Illuminate\Contracts\Support\Renderable` и `SleepingOwl\Admin\Contracts\Initializable`.

<a name="supported-types"></a>
## Поддерживаемые типы

 - `AdminColumn::text($name, $label = null)`
 - `AdminColumn::datetime($name, $label = null)`
 - `AdminColumn::link($name, $label = null)`
 - `AdminColumn::relatedLink($name, $label = null)`
 - `AdminColumn::count($name, $label = null)`
 - `AdminColumn::custom($label = null, \Closure $callback = null)`
 - `AdminColumn::image($name, $label = null)`
 - `AdminColumn::email($name, $label = null)`
 - `AdminColumn::lists($name, $label = null)`
 - `AdminColumn::url($name, $label = null)`
 - `AdminColumn::action($name)`
 - `AdminColumn::checkbox($label = null)`
 - `AdminColumn::control($label = null)`
 - `AdminColumn::filter($name, $label = null)`
 - `AdminColumn::order()`
 - `AdminColumn::treeControl()`
 - `AdminColumnEditable::checkbox($name, $checkedLabel = null, $uncheckedLabel = null)`

<a name="column-heading"></a>
## Заголовок столбца

Каждый столбец таблицы имеет заголовок и хранится в виде отдельного класса
`SleepingOwl\Admin\Contracts\Display\TableHeaderColumnInterface`.

**Пример работы с заголовком**

```php
...
    ->setColumns([
        ...
        AdminColumn::link('title')->setLabel('Title')->setOrderable(false),
        ...
    ]);
```

**Или работая напрямую с классом заголовка**
```php
...
    ->setColumns([
        ...
        $link = AdminColumn::link('title')
        ...
    ]);

    $link->getHeader()
        ->setTitle('Title')
        ->setOrderable(false)
        ->setHtmlAttribute('class', 'bg-success text-center')
        ->setHtmlAttribute('data-tooltip', 'Test tooltip');
```


<a name="api"></a>
## API


## Методы доступные во всех элементах
В классах колонок используется трейт 
 - [HtmlAttributes](html_attributes), с помощью которого для них можно настраивать HTML атрибуты.
 - [Assets](assets#assets-trait), с помощью которого для них можно подключать ассеты.

<a name="set-label"></a>
#### setLabel
Установка заголовка колонки

    SleepingOwl\Admin\Display\TableColumn::setLabel(string $title): return self

#### setName
Установка ключа элемента

    SleepingOwl\Admin\Contracts\NamedColumnInterface::setName(string $name): return self

#### setWidth
Установка ширины колонки

    SleepingOwl\Admin\Display\TableColumn::setWidth(string $width): return self

#### setView
Установки view

    SleepingOwl\Admin\Display\TableColumn::setView(string|\Illuminate\View\View $view): return self

#### append

    SleepingOwl\Admin\Display\TableColumn::append(\SleepingOwl\Admin\Contracts\ColumnInterface $append): return self

#### setOrderable
Указание правила сортировки колонки таблицы. По умолчанию все колонки сортируются `->orderBy(column, direction)`

    SleepingOwl\Admin\Display\TableColumn::setOrderable(false|SleepingOwl\Admin\Contracts\Display\OrderByClauseInterface|Closure|string $orderable): return self

В случае необходимости вы можете изменить правила сортировки столбца (Например для столбца с типом `custom`)

```php
$display->setColumns([
    AdminColumn::custom(function($model) 
           return $model->first_name.' '.$model->last_name;
    })->setOrderable(function($query, $direction) {
        $query->orderBy('last_name', $direction);
    })

   // Или просто передать ключ поля
  ->setOrderable('last_name')

   // Или с помощью класса реализующего интерфейс SleepingOwl\Admin\Contracts\Display\OrderByClauseInterface
  ->setOrderable(new CustomOrderByClause())
]);
```

## Типы

### Action 
`SleepingOwl\Admin\Display\Column\Action`

Данный элемент используется для добавления Кнопки совершения какого либо действия с данными таблицы.

!> Для работы элемента необходимо наличие поля `checkbox` в таблице**

```php
$table = AdminDisplay::table()
    ->setActions([
        AdminColumn::action('export', 'Export')->setIcon('fa fa-share')->setAction(route('news.export')),
    ])
    ->setColumns([
        AdminColumn::checkbox(),
        ...
    ]);

// Изменить расположение кнопок на странице
$table->getActions()
    ->setPlacement('panel.buttons')
    ->setHtmlAttribute('class', 'pull-right');
```

#### setTitle
Установка названия кнопки

    SleepingOwl\Admin\Display\Column\Action::setTitle(string $title): return self

#### setAction
Установка ссылки, на которую будет отправлен запрос с выбранными элементами

    SleepingOwl\Admin\Display\Column\Action::setAction(string $action): return self

#### setMethod
Установка типа отправляемого запроса [POST, GET, ...]

    SleepingOwl\Admin\Display\Column\Action::setMethod(string $method): return self

#### useGet
Использовать GET запрос

    SleepingOwl\Admin\Display\Column\Action::useGet(): return self

#### usePost
Использовать POST запрос

    SleepingOwl\Admin\Display\Column\Action::usePost(): return self


#### usePut
Использовать PUT запрос

    SleepingOwl\Admin\Display\Column\Action::usePut(): return self

#### useDelete
Использовать DELETE запрос

    SleepingOwl\Admin\Display\Column\Action::useDelete(): return self

#### setIcon
Установка иконки для кнопки

    SleepingOwl\Admin\Display\Column\Action::setIcon(string $icon): return self

  
### Checkbox
`SleepingOwl\Admin\Display\Column\Checkbox`

Данный элемент предназначен для вывода чекбокса в таблице для выбора значений. Подробнее [Action](#action)

```php
AdminColumn::checkbox(),
```

 
### CheckBox Editable
`SleepingOwl\Admin\Display\Column\Editable\Checkbox`
Данный элемент позволяет менять значение столбцов типа boolean прямо в таблице.

```php
AdminColumnEditable::checkbox('visible')->setLabel('Отображение'),
//or
AdminColumnEditable::checkbox('visible','Видно', 'Не видно')->setLabel('Отображение'),
```

#### setUrl
Вы можете установить свой url для отправки данных и принятия их в Кастом контроллере

    SleepingOwl\Admin\Display\Column\Editable\Checkbox::setUrl(string $url): return self
    
#### setCheckedLabel
Отображаемый текст в таблице при значении True

    SleepingOwl\Admin\Display\Column\Editable\Checkbox::setCheckedLabel(string $label): return self
    
#### setUncheckedLabel
Отображаемый текст в таблице при значении False

    SleepingOwl\Admin\Display\Column\Editable\Checkbox::setUncheckedLabel(string $label): return self


### Custom
`SleepingOwl\Admin\Display\Column\Custom`

Данный элемент используется для добавления кастомного кода в качестве колонки таблицы

```php
AdminColumn::custom($title, function(\Illuminate\Database\Eloquent\Model $model) {
    return $model->id;
})->setWidth('150px'),
```

#### setCallback
Установка анонимной функции, которая будет вызвана для каждого элемента таблицы, с передачей в качестве аргумента объекта `Illuminate\Database\Eloquent\Model`

    SleepingOwl\Admin\Display\Column\Custom::setCallback(\Closure $callback): return self


### DateTime
`SleepingOwl\Admin\Display\Column\DateTime`

Данный элемент предназначен для вывода даты с указанием формата

```php
AdminColumn::datetime('date', 'Date')->setFormat('d.m.Y')->setWidth('150px'),
```

#### setFormat
Указание формата даты

    SleepingOwl\Admin\Display\Column\DateTime::setFormat(string $format): return self


### Link
`SleepingOwl\Admin\Display\Column\Link`

Данный элемент предназначен для вывода данных модели в виде ссылки на текущий документ. Может содержать третий параметр (сноска будет не ссылкой).

```php
AdminColumn::link('title', 'Title')->setLinkAttributes(['target' => '_blank']),
```

со сноской (название рубрики, алиаса, даты создания и прочее)

```php
AdminColumn::url('title', 'Title', 'news.category'),
```

#### setLinkAttributes
Установка атрибутов для ссылки

    SleepingOwl\Admin\Display\Column\Link::setLinkAttributes(array $linkAttributes): return self


### RelatedLink
`SleepingOwl\Admin\Display\Column\RelatedLink`

Данный элемент предназначен для вывода данных модели в виде ссылки на документ связанного раздела. Может содержать сноску третим параметром (сноска не будет ссылкой).

```php
AdminColumn::relatedLink('author.name', 'Author')
```

со сноской (название рубрики, алиаса, даты создания и прочее)

```php
AdminColumn::relatedLink('title', 'Title', 'news.category'),
```

#### setLinkAttributes
Установка атрибутов для ссылки

    SleepingOwl\Admin\Display\Column\Link::setLinkAttributes(array $linkAttributes): return self



### URL
`SleepingOwl\Admin\Display\Column\Url`

Данный элемент предназначен для вывода значения поля в виде ссылки.

```php
AdminColumn::url('title', 'Title'),
```

#### setLinkAttributes
Установка атрибутов для ссылки

    SleepingOwl\Admin\Display\Column\Url::setLinkAttributes(array $linkAttributes): return self
    

### Text
`SleepingOwl\Admin\Display\Column\Text`

Данный элемент предназначен для вывода значения поля в виде обычного текста. Может содержать сноску (не обязательно) третьим параметром.

```php
AdminColumn::text('title', 'Title'),
```

со сноской с любыми связаными полями из БД

```php
AdminColumn::text('title', 'Title', 'created_at'),
```


### Count
`SleepingOwl\Admin\Display\Column\Count`

Данный элемент предназначен для подсчета и вывода кол-ва элементов. Подсчет значений производится функцией `count`, т.е. передаваемое поле должно содержать массив элементов либо элемент с отношением `*Many`

```php
AdminColumn::count('list', 'Total'),
```


### Email
`SleepingOwl\Admin\Display\Column\Email`

Данный элемент предназначен для вывода полей содержащих email адрес в виде ссылки `<a href="mailto:"></a>`

```php
AdminColumn::email('email', 'Email'),
```


### Image
`SleepingOwl\Admin\Display\Column\Image`

Данный элемент предназначен для вывода изображений

```php
AdminColumn::image('avatar', 'Avatar'),
```

#### setImageWidth
Указание ширины изображения

    SleepingOwl\Admin\Display\Image::setImageWidth(string $width): return self



### Lists
`SleepingOwl\Admin\Display\Column\Lists`

Данный элемент предназначен для вывода списка значений поля содержащего массив элементов, либо связь с отношением `*Many`

```php
AdminColumn::lists('roles.title', 'Roles') // Вывод списка ролей из связанной таблицы

// or

AdminColumn::lists('tags', 'Tags') // Вывод списка тегов из поля содержащего массив тегов
```



### Order
`SleepingOwl\Admin\Display\Column\Order`

Данный элемент предназначен для сортировки элементов таблицы. **Модель к которой применяется это поле должна содержать трейт `SleepingOwl\Admin\Traits\OrderableModel`**. По умолчанию, поле по которому производится сортировка - `order`. Для указания альтернативного ключа необходимо в модели добавить метод:

```php
class Users extend Model {
    use \SleepingOwl\Admin\Traits\OrderableModel;
    
    ...

    /**
     * Get order field name.
     * @return string
     */
    public function getOrderField()
    {
        return 'custom_order_field_name';
    }
}
```

Также для корректности отображения записей в таблице не забывайте при выводе сортировать записи по этому полю `->orderBy('order', 'asc')`




### Control
`SleepingOwl\Admin\Display\Column\Control`

Данный элемент используется в табличном выводе для отображения кнопок действий связанных с элементом таблицы. Данный элемент добавляется автоматически ко всем элементам таблицы и предоставляет следующие действия
 - Редактирование элемента
 - Удаление
 - Восстановление
 
**Получение доступа к данному элементу**
```php
$display = AdminDisplay::table()->...;
 
$display->getColumns()->getControlColumn(); // return SleepingOwl\Admin\Display\Column\Control
```

При необходимости вы можете добавлять в таблицу дополнительные действия над элементом:

```php
$control = $display->getColumns()->getControlColumn();

$link = new \SleepingOwl\Admin\Display\ControlLink(function (\Illuminate\Database\Eloquent\Model $model) {
   return 'http://localhost/'.$model->getKey(); // Генерация ссылки
}, 'Button text', 50);

$control->addButton($link);

$button = new \SleepingOwl\Admin\Display\ControlButton(function (\Illuminate\Database\Eloquent\Model $model) {
   return 'http://localhost/delete/'.$model->getKey(); // Генерация ссылки
}, 'Button text', 50);

// Изменение метода сабмита формы кнопки
$button->setMethod('delete');

// Скрытие текста из кнопки
$button->hideText();

// Добавление иконки
$button->setIcon('fa fa-trash');

// Дополнительные HTML атрибуты для кнопки
$button->setHtmlAttribute('class', 'btn-danger btn-delete');

//Добавление атрибутов по условию
//Атрибуты установленные в этом методе перекрывают атрибуты 
//установленные методами setHtmlAttribute/setHtmlAttributes
$link->setAttributeCondition(function(Model $model) {
    if (isset($model->id)) {
        return ['class' => "btn-id-{$model->id}"];
    }
    
    return ['class' => 'btn-danger'];
});

// Условие видимости кнопки (не обязательно)
$button->setCondition(function(\Illuminate\Database\Eloquent\Model $model) {
   return auth()->user()->can('delete', $model);
});

$control->addButton($button);
```

 Также в ControlLink в качестве второго параметра (отвечает за текст на кнопке) можно передавать функцию-замыкание, по аналогии с первым параметром (отвечает за url-адрес ссылки). Это дает возможность генерировать динамические заголовки на кнопке для каждой строки в таблице, например, выводить туда название каждой конкретной модели и/или кол-во записей из какой-либо связи этой модели:

```php
$link = new \SleepingOwl\Admin\Display\ControlLink(function (\Illuminate\Database\Eloquent\Model $model) {
   return 'http://localhost/'.$model->getKey(); // Генерация ссылки
}, function (\Illuminate\Database\Eloquent\Model $model) {
   return $model->title . ' (' . $model->images_count . ')'; // Генерация текста на кнопке
}, 50);
```
 
**На данный момент существует два класса кнопок** 
 - `SleepingOwl\Admin\Display\ControlButton` - кнопка внутри формы для сабмита
 - `SleepingOwl\Admin\Display\ControlLink` - кнопка ссылка
 
 Также вы можете добавлять свои классы кнопок, реализовав интерфейс `SleepingOwl\Admin\Contracts\Display\ControlButtonInterface`
 

<a name="relations"></a>    
## Работа с Relation данными

Большинство колонок могут использовать связи модели.

Допустим у вас есть модель `App\User` и у данной модели есть связь многие ко многим `App\Role` и связь один к одному `App\Department`, т.е. пользователь может иметь несколько ролей и принадлежать отделу.

**Прежде всего для моделей необходимо [настроить связи](https://laravel.com/docs/eloquent-relationships)**

Для получения списка названий ролей нам необходимо выполнить что-то вроде `$user->roles->pluck('title')`, что равноценно получению данных в колонке (`roles.title`), т.е. когда класс попытается получить значение по данному ключу, он разобьет данный ключ на массив по знаку `.` и сделает следующее:

```php
// Попытается получить данные по первому сегменту
$roles = $user->getAttribute('roles'); // Вернет список ролей (коллекцию Collection моделей App\Role)
$value = $roles->pluck('title');
```

Для получения названия департамента нам необходимо выполнить что-то вроде `$user->department->title`, что равноценно получению данных в колонке (`department.title`), т.е. когда класс попытается получить значение по данному ключу, он разобьет данный ключ на массив по знаку `.` и сделает следующее:

```php
// Попытается получить данные по первому сегменту
$department = $user->getAttribute('department'); // Вернет объект App\Department
$value = $department->getAttribute('title');
```

Как мы видим работа с Relation данными достаточно проста, главное правильно настроить связи в моделях.