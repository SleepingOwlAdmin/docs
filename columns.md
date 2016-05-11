# Столбцы таблицы

Создает новый столбец в таблица вывода списка записей.

**Пример использования**

```php
AdminDisplay::table()
    ->setColumns([
        AdminColumn::link('title')->setLabel('Title'),
        AdminColumn::datetime('date')->setLabel('Date')->setFormat('d.m.Y')->setWidth('150px')
    ])
```

Класс `SleepingOwl\Admin\Display\TableColumn`, от которого наследуются 
все столбцы, реализует интерфейсы `Illuminate\Contracts\Support\Arrayable` и 
`Illuminate\Contracts\Support\Renderable`

В классах столбцов используется трейт [HtmlAttributes](html_attributes.md),
с помощью которого для всех столбцов можно настраивать HTML атрибуты.

## Поддерживаемые типы

 - `AdminColumn::action($name)`
 - `AdminColumn::checkbox()`
 - `AdminColumn::count($name)`
 - `AdminColumn::custom()`
 - `AdminColumn::datetime($name)`
 - `AdminColumn::email($name)`
 - `AdminColumn::string($name)`
 - `AdminColumn::link($name)`
 - `AdminColumn::relatedLink($name)`
 - `AdminColumn::lists($name)`
 - `AdminColumn::image($name)`
 - `AdminColumn::order()`
 
## Заголовок стобца

Каждый столбец таблицы имеет заголовок и хранится в виде отдельного класса
`SleepingOwl\Admin\Contracts\Display\TableHeaderColumnInterface`

**Пример работы с заголовком**

```php
...
    ->setColumns([
        ...
        AdminColumn::link('title')
            ->setLabel('Title')
            ->setOrderable(false),
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

## Запрет на сортировку по столбцу
```php
AdminColumn::link('title')->setOrderable(false);
```
