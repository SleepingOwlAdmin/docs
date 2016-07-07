# Типы отображения данных


## Таблица (Table)
Таблицы предназначения для вывода списка документов раздела.

На данные момент поддерживаются следующие типы вывода данных:
 - `AdminDisplay::table()` - обычная таблица
 - `AdminDisplay::datatables()` - таблица с выводом данных используя плагин https://datatables.net/
 - `AdminDisplay::datatablesAsync()`
 - `AdminDisplay::tree()` - вывод данных в виде дерева

```php
$model->onDisplay(function () {
    $display = AdminDisplay::table();
    
    ...
    
    return $display;
});
```

### Расширение таблиц
Класс `SleepingOwl\Admin\Display\Display` от которого наследуются все классы реализующие вывод данных позволяет расширять свое поведение за счет расширений. Расширения могут как влиять на вывод данных, модифицируя запрос перед получением списка записей из БД либо вывод HTML кода в шаблон.

Сейчас класс для вывода таблицы работает полностью за счет расширений, а именно, вызывая метод `setColumns` или `getColumns`, `setColumnFilters` или `getColumnFilters` вы обращаетесь к классам расширений.

#### Как это работает:

Допустим у нас есть таблица: 
```php
$display = AdminDisplay::table();
```

TODO: дописать


### Указание столбцов
Типы столбцов и их описание можно посмотреть [здесь](columns.md)

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

### Фильтры столбцов

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

### Eager Loading

```php
$display->with('country', 'companies');
```

### Изменение запроса
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

### Применение scope
Вы можете применить eloquent scope к выводимым данным:

```php
$display->setScopes('last');

//or

$display->setScopes(['last', 'trashed']);

// or

$display->getScopes()->push('last');
```
