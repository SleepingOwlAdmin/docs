# Колонки таблицы
Расширение [отображения данных](displays) 

- [Введение](#introduction)
- [Методы доступные во всех элементах](#supported-types)
- [Поддерживаемые типы](#supported-types)
- [Заголовок столбца](#column-heading)
- [Методы доступные во всех элементах](#all-methods)
- Типы
    - [Text](#text)
    - [DateTime](#datetime)
    - [Link](#link)
    - [RelatedLink](#related-link)
    - [Url](#url)
    - [Lists](#lists)
    - [Count](#count)
    - [Email](#email)
    - [Image](#image)
    - [Order](#order)
    - [Custom](#custom)
    - [Action](#action)
    - [Checkbox](#checkbox)
    - [Control](#control)

<a name="introduction"></a>
## Введение

Данные классы предназначены для добавления колонок в таблицу, а также вывод информации из модели в форме редактирования.

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

**Или работая напрямую с класом заголовка**
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

# API

<a name="all-methods"></a>
## Методы доступные во всех элементах
В классах колонок используется трейт 
 - [HtmlAttributes](html_attributes.md), с помощью которого для них можно настраивать HTML атрибуты.
 - [Assets](assets_trait.md), с помощью которого для них можно подключать ассеты.

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
Указание правила сортировки колонки таблицы. По умочалчанию все колонки сортируются `->orderBy(column, direction)`

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

<a name="action"></a>
## Action 
`SleepingOwl\Admin\Display\Column\Action`

Данный элемент используется для добавления Кнопки совершения какого либо действия с данными таблицы.
**Для работы элемента необходимо наличие поля `checkbox` в таблице**

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

<a name="checkbox"></a>    
## Checkbox
`SleepingOwl\Admin\Display\Column\Checkbox`

Данный элемент предназначен для вывода чекбокса в таблице для выбора значений. Подробнее [Action](#action)

```php
AdminColumn::checkbox(),
```

<a name="custom"></a>
## Custom
`SleepingOwl\Admin\Display\Column\Custom`

Данный элемент используется для добавления кастомного кода в качестве колонки таблицы


```php
AdminColumn::custom(function(\Illuminate\Database\Eloquent\Model $model) {
    return $model->id;
})->setWidth('150px'),
```

#### setCallback
Установка анонимной функции, которая будет вызвана для каждого элемента таблицы, с передачей в качестве аргумента объекта `Illuminate\Database\Eloquent\Model`

    SleepingOwl\Admin\Display\Column\Custom::setCallback(\Closure $callback): return self

<a name="datetime"></a>
## DateTime
`SleepingOwl\Admin\Display\Column\DateTime`

Данный элемент предназначен для вывода даты с указанием формата

```php
AdminColumn::datetime('date', 'Date')->setFormat('d.m.Y')->setWidth('150px'),
```

#### setFormat
Указание формата даты

    SleepingOwl\Admin\Display\Column\DateTime::setFormat(string $format): return self

<a name="link"></a>    
## Link
`SleepingOwl\Admin\Display\Column\Link`

Данный элемент предназначен для вывода данных модели в виде ссылки на текущий документ

```php
AdminColumn::link('title', 'Title')->setLinkAttributes(['target' => '_blank']),
```

#### setLinkAttributes
Установка атрибутов для ссылки

    SleepingOwl\Admin\Display\Column\Link::setLinkAttributes(array $linkAttributes): return self

<a name="related-link"></a>    
## RelatedLink
`SleepingOwl\Admin\Display\Column\RelatedLink`

Данный элемент предназначен для вывода данных модели в виде ссылки на документ связанного раздела

```php
AdminColumn::relatedLink('author.name', 'Author')
```

#### setLinkAttributes
Установка атрибутов для ссылки

    SleepingOwl\Admin\Display\Column\Link::setLinkAttributes(array $linkAttributes): return self


<a name="url"></a>    
## URL
`SleepingOwl\Admin\Display\Column\Url`

Данный элемент предназначен для вывода значения поля в виде ссылки

```php
AdminColumn::url('title', 'Title'),
```

#### setLinkAttributes
Установка атрибутов для ссылки

    SleepingOwl\Admin\Display\Column\Url::setLinkAttributes(array $linkAttributes): return self
    
<a name="text"></a>    
## Text
`SleepingOwl\Admin\Display\Column\Text`

Данный элемент предназначен для вывода значения поля в виде обычного текста

```php
AdminColumn::text('title', 'Title'),
```

<a name="count"></a>    
## Count
`SleepingOwl\Admin\Display\Column\Count`

Данный элемент предназначен для подсчета и вывода кол-ва элементов. Подсчет значений производится функцией `count`, т.е. передаваемое поле должно содержать массив элементов либо элемент с отношением `*Many`

```php
AdminColumn::count('list', 'Total'),
```

<a name="email"></a>    
## Email
`SleepingOwl\Admin\Display\Column\Email`

Данный элемент предназначен для вывода полей содержащих email адрес в виде ссылкы `<a href="mailto:"></a>`

```php
AdminColumn::email('email', 'Email'),
```

<a name="image"></a>    
## Image
`SleepingOwl\Admin\Display\Column\Image`

Данный элемент предназначен для вывода изображений

```php
AdminColumn::image('avatar', 'Avatar'),
```

#### setImageWidth
Указание ширины изображения

    SleepingOwl\Admin\Display\Image::setImageWidth(string $width): return self


<a name="lists"></a>    
## Lists
`SleepingOwl\Admin\Display\Column\Lists`

Данный элемент предназначен для вывода списка значений поля содержащего массив элементов, либо связь с отношением `*Many`

```php
AdminColumn::lists('roles.title', 'Roles') // Вывод списка ролей из связанной таблицы

// or

AdminColumn::lists('tags', 'Tags') // Вывод списка тегов из поля содержащего массив тегов
```


<a name="order"></a>    
## Order
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

<a name="control"></a>    
## Control
`SleepingOwl\Admin\Display\Column\Control`

Данный элемент используется в табличном выводе для отображения кнопок действий связанных с элементом таблицы. Данный элемент добавляется автоматически ко всем элементам таблицы и предоставляет следующие дейтсвия
 - Редактирование элемента
 - Удаление
 - Восстановление
 
**Получение доступа к данном элементу**
```php
$display = AdminDisplay::table()->...;
 
$display->getColumns()->getControlColumn(); // return SleepingOwl\Admin\Display\Column\Control
```
При необходимости вы можете добавлять в таблицу ндополнительные действия над элементом:
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
**На данный момент существует два класса кнопок** 
 - `SleepingOwl\Admin\Display\ControlButton` - кнопка внутри формы для сабмита
 - `SleepingOwl\Admin\Display\ControlLink` - кнопка ссылка
 
 Также вы можете добавлять свои классы кнопок, реализовав инттерфейс `SleepingOwl\Admin\Contracts\Display\ControlButtonInterface`
