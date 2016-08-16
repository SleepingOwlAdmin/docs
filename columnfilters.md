# Фильтры столбцов

Фильтры столбцов используются для фильтрации списка. 

В случае с `AdminDisplay::datatables()` поиск производится через API библиотеки `datatable`.

**Пример использования:**

```php
$display = AdminDisplay::datatables();

$display->setColumnFilters([
  null, // Не ищем по первому столбцу
  
  // Поиск текста
  AdminColumnFilter::text()->setPlaceholder('Full Name'),
  
  // Поиск по диапазону 
  AdminColumnFilter::range()->setFrom(
      AdminColumnFilter::text()->setPlaceholder('From')
  )->setTo(
      AdminColumnFilter::text()->setPlaceholder('To')
  ),
  
  // Поиск по диапазону дат
  AdminColumnFilter::range()->setFrom(
      AdminColumnFilter::date()->setPlaceholder('From Date')->setFormat('d.m.Y')
  )->setTo(
      AdminColumnFilter::date()->setPlaceholder('To Date')->setFormat('d.m.Y')
  ),
  
  // Поиск по выпадающему списку значений
  AdminColumnFilter::select()->setPlaceholder('Country')->setModel(new Country)->setDisplay('title')
]);
```

**При указании столбцов необходимо, чтобы кол-во столбцов поиска соответствовало кол-ву столбцов в таблице (если поиск по определенному столбцу не нужен, то необходимо передать `null`) и была соблюдена последовательность**

# API

В классах фильтров столбцов используется трейт:
 - [HtmlAttributes](html_attributes.md), с помощью которого для них можно настраивать HTML атрибуты.
 - [Assets](assets_trait.md), с помощью которого для них можно подключать ассеты.

## Методы доступные во всех фильтрах

### setOperator
Указание оператора, который будет использован при фильтрации. По умолчанию `equal`

```php
  static::setOperator(string $operator): return self
```

#### Список доступных операторов сравнения:

  - `equal` - равно
  - `not_equal` - не равно
  - `less` - меньше
  - `less_or_equal` - меньше или равно
  - `greater` - больше
  - `greater_or_equal` - больше или равно
  - `begins_with` - начинается с
  - `not_begins_with`- не начинается с
  - `contains` - содержит
  - `not_contains` - не содержит
  - `ends_with` - заканчивается на
  - `not_ends_with` - не заканчивается на
  - `between` - между (значения указываются через `,`)
  - `not_between` - не между (значения указываются через `,`)
  - `in` - одно из (значения указываются через `,`)
  - `not_in` - не одно из (значения указываются через `,`)


## Text
Фильтрация данных по строке

```php
AdminColumnFilter::text()->setPlaceholder('Full Name')->setOperator('contains')
```

### setPlaceholder
Указание плейсхолдера для поля.

```php
  static::setPlaceholder(string $placeholder): return self
```


## Date
Фильтрация данных по дате

```php
AdminColumnFilter::date()->setPlaceholder('Date')->setFormat('d.m.Y')
```

### setFormat
Указание формата даты в которой приходит дата из инпута

```php
  static::setFormat(string $format): return self
```

### setPickerFormat
Указание формата даты отображаемой в инпуте и понятной для Javascript

```php
  static::setPickerFormat(string $pickerFormat): return self
```

### setSearchFormat
Указание формата даты в котором данные хранятся в БД

```php
  static::setSearchFormat(string $searchFormat): return self
```

### setWidth
Ширина инпута

```php
  static::setWidth(int $width): return self
```

## Select
Фильтрация данных по данным из выпадающего списка


## Range
Фильтрация данных по диазону.


### setFrom
Указание поля начала диапазона

```php
  static::setFrom(ColumnFilterInterface $from): return self
```

### setTo
Указание поля конца диапазона

```php
  static::setTo(ColumnFilterInterface $from): return self
```
