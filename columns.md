# Колонки таблицы

Данные классы предназначены для добавления колонок в таблицу, а также вывод информации из модели в форме редактирования

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
`Illuminate\Contracts\Support\Renderable` и `SleepingOwl\Admin\Contracts\Initializable`

В классах столбцов используется трейт [HtmlAttributes](html_attributes), с помощью которого для всех столбцов можно настраивать HTML атрибуты.

## Поддерживаемые типы

 - `AdminColumn::text($name, $label = null)`
 - `AdminColumn::datetime($name, $label = null)`
 - `AdminColumn::link($name, $label = null)`
 - `AdminColumn::relatedLink($name, $label = null, \Illuminate\Database\Eloquent\Model $model = null)`
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
 
## Заголовок стобца

Каждый столбец таблицы имеет заголовок и хранится в виде отдельного класса
`SleepingOwl\Admin\Contracts\Display\TableHeaderColumnInterface`

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

# Методы доступные во всех элементах

### setLabel
Установка заголовка колонки
    \SleepingOwl\Admin\Display\TableColumn SleepingOwl\Admin\Display\TableColumn::setLabel(string $title)

### setName
Установка ключа элемента

    \SleepingOwl\Admin\Contracts\NamedColumnInterface SleepingOwl\Admin\Contracts\NamedColumnInterface::setName(string $name)
    
### setWidth
Установка ширины колонки
    \SleepingOwl\Admin\Display\TableColumn SleepingOwl\Admin\Display\TableColumn::setWidth(string $width)
    
### setView
Установки view
    \SleepingOwl\Admin\Display\TableColumn SleepingOwl\Admin\Display\TableColumn::setView(string|\Illuminate\View\View $view)
    
### append

    \SleepingOwl\Admin\Display\TableColumn SleepingOwl\Admin\Display\TableColumn::append(\SleepingOwl\Admin\Contracts\ColumnInterface $append)

### setOrderable

    \SleepingOwl\Admin\Display\TableColumn SleepingOwl\Admin\Display\TableColumn::setOrderable(boolean $orderable)
    
### setHtmlAttribute
Установка HTML атрибута

    \SleepingOwl\Admin\Display\TableColumn SleepingOwl\Admin\Display\TableColumn::setHtmlAttribute(string $key, string|array $attribute)
    
### setHtmlAttributes
Установка HTML атрибутов в виде массива

    \SleepingOwl\Admin\Display\TableColumn SleepingOwl\Admin\Display\TableColumn::setHtmlAttributes(array $attributes)
    
### replaceHtmlAttribute
Замена установленного HTML атрибута

    \SleepingOwl\Admin\Display\TableColumn SleepingOwl\Admin\Display\TableColumn::replaceHtmlAttribute(string $key, string|array $attribute)
    
### hasClassProperty
Проверка на существование HTML класса

    boolean SleepingOwl\Admin\Display\TableColumn::hasClassProperty(string $class)
    
### hasHtmlAttribute
Проверка на существование HTML атрибута

    boolean SleepingOwl\Admin\Display\TableColumn::hasHtmlAttribute(\KodiComponents\Support\srtring $key)
    
### removeHtmlAttribute
Удаление HTML атрибута

    \SleepingOwl\Admin\Display\TableColumn SleepingOwl\Admin\Display\TableColumn::removeHtmlAttribute(string $key)
    
### clearHtmlAttributes
Удаление всех HTML атрибутов

    \SleepingOwl\Admin\Display\TableColumn SleepingOwl\Admin\Display\TableColumn::clearHtmlAttributes()
    
# Action
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
    
// Изменить разсположение положения кнопок на странице
$table->getActions()
    ->setPlacement('panel.buttons')
    ->setHtmlAttribute('class', 'pull-right');
```


### setTitle
Установка названия кнопки

    \SleepingOwl\Admin\Display\Column\Action SleepingOwl\Admin\Display\Column\Action::setTitle(string $title)

### setAction
Установка ссылки на которую будет отправлен запрос с выбранными элементами

    \SleepingOwl\Admin\Display\Column\Action SleepingOwl\Admin\Display\Column\Action::setAction(string $action)
    
### setMethod
Установка типа отправляемого запроса [POST, GET, ...]

    \SleepingOwl\Admin\Display\Column\Action SleepingOwl\Admin\Display\Column\Action::setMethod(string $method)
    
### useGet
Использовать GET запрос

    \SleepingOwl\Admin\Display\Column\Action SleepingOwl\Admin\Display\Column\Action::useGet()

### usePost
Использовать POST запрос

    \SleepingOwl\Admin\Display\Column\Action SleepingOwl\Admin\Display\Column\Action::usePost()
    

### usePut
Использовать PUT запрос

    \SleepingOwl\Admin\Display\Column\Action SleepingOwl\Admin\Display\Column\Action::usePut()

### useDelete
Использовать DELETE запрос

    \SleepingOwl\Admin\Display\Column\Action SleepingOwl\Admin\Display\Column\Action::useDelete()
    
### setIcon
Установка иконки для кнопки

    \SleepingOwl\Admin\Display\Column\Action SleepingOwl\Admin\Display\Column\Action::setIcon(string $icon)
    
# Custom
Данный элемент используется для добавления кастомного кода в качестве колонки таблицы


```php
AdminColumn::custom(function(\Illuminate\Database\Eloquent\Model $model) {
    return $model->id;
})->setWidth('150px'),
```

### setCallback
Установка анонимной функции, которая будет вызвана для каждого элемента таблицы, с передачей в качестве аргумента объекта `Illuminate\Database\Eloquent\Model`

    \SleepingOwl\Admin\Display\Column\Custom SleepingOwl\Admin\Display\Column\Custom::setCallback(\Closure $callback)

# DateTime
Данный элемент предназначен для вывода даты с указанием формата

```php
AdminColumn::datetime('date', 'Date')->setFormat('d.m.Y')->setWidth('150px'),
```

### setFormat
Указание формата даты

    \SleepingOwl\Admin\Display\Column\DateTime SleepingOwl\Admin\Display\Column\DateTime::setFormat(string $format)
    
# Link
Данный элемент предназначен для вывода данных модели в виде ссылки на текущий документ

``php
AdminColumn::link('title', 'Title')->setLinkAttributes(['target' => '_blank']),
```

### setLinkAttributes
Установка атрибутов для ссылки

    \SleepingOwl\Admin\Display\Column\Link SleepingOwl\Admin\Display\Column\Link::setLinkAttributes(array $linkAttributes)
