# Фильтры столбцов

 - [API](#api)
 - [Text](#filter-text)
 - [Date](#filter-date)
 - [Select](#filter-select)
 - [Range](#filter-range) 

Фильтры столбцов используются для фильтрации списка. 

В случае с `AdminDisplay::datatables()` поиск производится через API библиотеки `datatables`.

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
  AdminColumnFilter::select(new Country, 'Title')->setDisplay('title')->setPlaceholder('Select Country')->setColumnName('country_id')
]);
```

**При указании столбцов необходимо, чтобы кол-во столбцов поиска соответствовало кол-ву столбцов в таблице (если поиск по определенному столбцу не нужен, то необходимо передать `null`) и была соблюдена последовательность**

<a name="api"></a>
## API

В классах фильтров столбцов используется трейт:
 - [HtmlAttributes](html_attributes), с помощью которого для них можно настраивать HTML атрибуты.
 - [Assets](assets#assets-trait), с помощью которого для них можно подключать ассеты.

## Методы доступные во всех фильтрах

<a name="set-operator"></a>
### setOperator
Указание оператора, который будет использован при фильтрации. По умолчанию `equal`

```php
  static::setOperator(string $operator): return self
```

#### Список доступных операторов сравнения:

  - `SleepingOwl\Admin\Contracts\FilterInterface::EQUAL = equal` - равно
  - `SleepingOwl\Admin\Contracts\FilterInterface::NOT_EQUAL = not_equal` - не равно
  - `SleepingOwl\Admin\Contracts\FilterInterface::LESS = less` - меньше
  - `SleepingOwl\Admin\Contracts\FilterInterface::LESS_OR_EQUAL = less_or_equal` - меньше или равно
  - `SleepingOwl\Admin\Contracts\FilterInterface::GREATER = greater` - больше
  - `SleepingOwl\Admin\Contracts\FilterInterface::GREATER_OR_EQUAL = greater_or_equal` - больше или равно
  - `SleepingOwl\Admin\Contracts\FilterInterface::BEGINS_WITH = begins_with` - начинается с
  - `SleepingOwl\Admin\Contracts\FilterInterface::NOT_BEGINS_WITH = not_begins_with`- не начинается с
  - `SleepingOwl\Admin\Contracts\FilterInterface::CONTAINS = contains` - содержит
  - `SleepingOwl\Admin\Contracts\FilterInterface::NOT_CONTAINS = not_contains` - не содержит
  - `SleepingOwl\Admin\Contracts\FilterInterface::ENDS_WITH = ends_with` - заканчивается на
  - `SleepingOwl\Admin\Contracts\FilterInterface::NOT_ENDS_WITH = not_ends_with` - не заканчивается на
  - `SleepingOwl\Admin\Contracts\FilterInterface::BETWEEN = between` - между (значения указываются через `,`)
  - `SleepingOwl\Admin\Contracts\FilterInterface::NOT_BETWEEN = not_between` - не между (значения указываются через `,`)
  - `SleepingOwl\Admin\Contracts\FilterInterface::IN = in` - одно из (значения указываются через `,`)
  - `SleepingOwl\Admin\Contracts\FilterInterface::NOT_IN = not_in` - не одно из (значения указываются через `,`)


<a name="filter-text"></a>
## Text
Фильтрация данных по строке

```php
AdminColumnFilter::text()->setPlaceholder('Full Name')->setOperator(\SleepingOwl\Admin\Contracts\FilterInterface::CONTAINS)
```

### setPlaceholder
Указание плейсхолдера для поля.

```php
  static::setPlaceholder(string $placeholder): return self
```


<a name="filter-date"></a>
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


<a name="filter-select"></a>
## Select
Фильтрация данных по данным из выпадающего списка


<a name="filter-range"></a>
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