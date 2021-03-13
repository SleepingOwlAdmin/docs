# Фильтры столбцов

 - [API](#api)
 - [Text](#text)
 - [Date](#date)
 - [Select](#select)
 - [Range](#range)

Фильтры столбцов используются для фильтрации списка.

В случае с `AdminDisplay::datatables()` поиск производится через API библиотеки `datatables`.

**Пример использования:**

```php
$display = AdminDisplay::datatables();

$display->setColumnFilters([
  null, // Не ищем по первому столбцу

  // Поиск текста
  AdminColumnFilter::text()
    ->setPlaceholder('Full Name'),

  // Поиск по диапазону
  AdminColumnFilter::range()->setFrom(
      AdminColumnFilter::text()
        ->setPlaceholder('From')
  )->setTo(
      AdminColumnFilter::text()
        ->setPlaceholder('To')
  ),

  // Поиск по диапазону дат
  AdminColumnFilter::range()->setFrom(
      AdminColumnFilter::date()
        ->setPlaceholder('From Date')
        ->setFormat('d.m.Y')
  )->setTo(
      AdminColumnFilter::date()
        ->setPlaceholder('To Date')
        ->setFormat('d.m.Y')
  ),

  // Поиск по выпадающему списку значений
  AdminColumnFilter::select(new Country, 'Title')
    ->setDisplay('title')
    ->setPlaceholder('Select Country')
    ->setColumnName('country_id')
]);
```

**При указании столбцов необходимо, чтобы кол-во столбцов поиска соответствовало кол-ву столбцов в таблице (если поиск по определенному столбцу не нужен, то необходимо передать `null`) и была соблюдена последовательность**


Так же фильтры можно вынести из таблицы:

```php
$display = AdminDisplay::datatables();

$filters = [
  //нужные фильтры
];

$display->setColumnFilters($filters);
//любая доступная позиция
$display->getColumnFilters()->setPlacement('card.heading');
```


## API

В классах фильтров столбцов используется трейт:
 - [HtmlAttributes](html_attributes), с помощью которого для них можно настраивать HTML атрибуты.
 - [Assets](assets#assets-trait), с помощью которого для них можно подключать ассеты.

## Методы доступные во всех фильтрах


### setOperator
Указание оператора, который будет использован при фильтрации. По умолчанию `equal`

```php
  static::setOperator(string $operator): return self
```

#### Список доступных операторов сравнения:

  - `SleepingOwl\Admin\Contracts\Display\Extension\FilterInterface::EQUAL = equal` - равно
  - `SleepingOwl\Admin\Contracts\Display\Extension\FilterInterface::NOT_EQUAL = not_equal` - не равно
  - `SleepingOwl\Admin\Contracts\Display\Extension\FilterInterface::LESS = less` - меньше
  - `SleepingOwl\Admin\Contracts\Display\Extension\FilterInterface::LESS_OR_EQUAL = less_or_equal` - меньше или равно
  - `SleepingOwl\Admin\Contracts\Display\Extension\FilterInterface::GREATER = greater` - больше
  - `SleepingOwl\Admin\Contracts\Display\Extension\FilterInterface::GREATER_OR_EQUAL = greater_or_equal` - больше или равно
  - `SleepingOwl\Admin\Contracts\Display\Extension\FilterInterface::BEGINS_WITH = begins_with` - начинается с
  - `SleepingOwl\Admin\Contracts\Display\Extension\FilterInterface::NOT_BEGINS_WITH = not_begins_with`- не начинается с
  - `SleepingOwl\Admin\Contracts\Display\Extension\FilterInterface::CONTAINS = contains` - содержит
  - `SleepingOwl\Admin\Contracts\Display\Extension\FilterInterface::NOT_CONTAINS = not_contains` - не содержит
  - `SleepingOwl\Admin\Contracts\Display\Extension\FilterInterface::ENDS_WITH = ends_with` - заканчивается на
  - `SleepingOwl\Admin\Contracts\Display\Extension\FilterInterface::NOT_ENDS_WITH = not_ends_with` - не заканчивается на
  - `SleepingOwl\Admin\Contracts\Display\Extension\FilterInterface::BETWEEN = between` - между (значения указываются через `,`)
  - `SleepingOwl\Admin\Contracts\Display\Extension\FilterInterface::NOT_BETWEEN = not_between` - не между (значения указываются через `,`)
  - `SleepingOwl\Admin\Contracts\Display\Extension\FilterInterface::IN = in` - одно из (значения указываются через `,`)
  - `SleepingOwl\Admin\Contracts\Display\Extension\FilterInterface::NOT_IN = not_in` - не одно из (значения указываются через `,`)


## Text
Фильтрация данных по строке

```php
AdminColumnFilter::text()
  ->setPlaceholder('Full Name')
  ->setOperator(\SleepingOwl\Admin\Contracts\Display\Extension\FilterInterface::CONTAINS)
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

### setWidth (доступно в v6+, вернулось в v7.20+)
__Минимальная__ ширина блока
Доступно во всех фильтрах, в рейдж блоке и во внутренних частях рейндж блока

```php
  static::setWidth(string $width): return self

  AdminColumnFilter::text()
    ->setPlaceholder('Full Name')
    ->setColumnName('title')
    ->setWidth('20rem') //min-width: 20rem / em / px / %
    ->setOperator('contains'),
```


## Select
Фильтрация данных по данным из выпадающего списка.
В опции можно указать массив или передать модель:

```php
  //массивом
  AdminColumnFilter::select()
    ->setOptions([
      'sender' => 'Отправитель',
      'recipient' => 'Получатель',
    ])
    ->setWidth('15rem')
    ->setColumnName('payer_type')
    ->setPlaceholder('Все'),

  //моделью
  AdminColumnFilter::select()
    ->setModelForOptions(Sender::class)
    ->setDisplay(function($filter){
      return $filter->id . ' - ' . $filter->description;
    })
    ->setWidth('15rem')
    ->setFetchColumns('description') //id и так выбирается
    ->setColumnName('sender_id')
    ->setLoadOptionsQueryPreparer(function($element, $query) {
      //любая своя логика либо скоуп
      return $query->active();
    })
    ->setPlaceholder('Все отправители'),
```


## Range
Фильтрация данных по диазону.


### setInline(true) (dev или v7.20 +)
Выравнивание инпутов Range в одну строку


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
