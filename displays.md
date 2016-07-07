# Типы отображения данных


## Таблица (Table)
Таблицы предназначения для вывода списка документов раздела.

На данные момент поддерживаются следующие типы вывода данных:
 - `AdminDisplay::table()` - обычная таблица (`SleepingOwl\Admin\Display\DisplayTable`)
 - `AdminDisplay::datatables()` - таблица с выводом данных используя плагин https://datatables.net/ (`SleepingOwl\Admin\Display\DisplayDatatables`)
 - `AdminDisplay::datatablesAsync()` (`SleepingOwl\Admin\Display\DisplayDatatablesAsync`)
 - `AdminDisplay::tree()` - вывод данных в виде дерева (`SleepingOwl\Admin\Display\DisplayTree`)

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


### Указание столбцов (Расширение)
`SleepingOwl\Admin\Display\Extension\Columns`

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

### Eager Loading
Позволяет оптимизировать запросы к БД в случае использования связей с другими моделями. [Подробности](https://laravel.com/docs/5.2/eloquent-relationships#eager-loading)

```php
$display->with('country', 'companies');
```

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

### Применение scope (Расширение)
`SleepingOwl\Admin\Display\Extension\Scopes`

Вы можете применить [Eloquent scopes](https://laravel.com/docs/5.2/eloquent#query-scopes) к выводимым данным:

```php
$display->setScopes('last');

//or

$display->setScopes(['last', 'trashed']);

// or

$display->getScopes()->push('last');
```

### Действия над документами Actions (Расширение)
`SleepingOwl\Admin\Display\Extension\Actions`

Использует тип колонки таблицы [Action](columns.md#action)

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
