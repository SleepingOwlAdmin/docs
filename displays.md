# Типы отображения данных


## Таблица (Table)

```php
$model->onDisplay(function () {
    $display = AdminDisplay::table();
    
    ...
    
    return $display;
});
```

### Указание столбцов

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

// or

$display->getScopes()->push('last');
```
