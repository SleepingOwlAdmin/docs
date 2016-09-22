# Фильтры данных
Расширение [отображения данных](displays.md) 

Используются для фильтрации списка данных на основе параметров запроса. Являются разновидностью фильтрации данных, без использования формы.

Т.е., например, у вас есть таблица с новостями из различных категорий (`category_id`) и вы хотите отобразить новости из определенной категории:

```php
$display = AdminDisplay::table()
    ->setFilters(
        AdminDisplayFilter::field('category_id')->setTitle('Category ID [:value]')
    )
    ->setColumns(
        AdminColumn::link('title', 'Заголовок'),
        AdminColumn::link('category', 'Категория'),
        AdminColumn::datetime('created_at', 'Дата публикации')->setWidth('150px')
    )->paginate(20);
```

В этом примере показан простейший пример применения фильтра. И если теперь в бразуере указать `?category_id=1`, то при формировании запроса для выборки данных в него будет вставлено условие `where category_id = 1` и в заголовке таблицы будет отображена строка `Category ID [1]`

### Типы фильтров:
 - Фильтр по полю
 - Фильтр по [eloquent scopes](https://laravel.com/docs/5.2/eloquent#query-scopes)
 - Произвольный фильтр

## API (Методы доступные во всех фильтрах)

#### setName
Указание ключа поля, по которому будет производиться фильтрация

    SleepingOwl\Admin\Display\Filter\FilterBase::setName(string $name): return self
    
#### setAlias
Указание алиаса для поля, который будет использоваться вместо ключа поля для получение значения из запроса.

    SleepingOwl\Admin\Display\Filter\FilterBase::setAlias(string $alias): return self
    
```php
AdminDisplayFilter::field('category_id')->setAlias('category'); // ?category=1
```

#### setTitle
Указание заголовка в случае применении этого фильтра. Т.е. как только для фильтр сработает, над списком результатов будет выведен заголовок для фильтра, если сработало несколько фильтров, то заголовки будут разделены знаком ` | `

    SleepingOwl\Admin\Display\Filter\FilterBase::setTitle(\Closure|string $title): return self
    
```php
AdminDisplayFilter::field('category_id')->setTitle('Category ID [:value]'); 

// or

AdminDisplayFilter::field('category_id')->setTitle(function($value) {
    return "Category ID [{$value}]";
}); 
```

#### setValue
Принудительное указание значения для фильтрации. **При указании значения фильтр не будет обращаться к параметрам запроса**

    SleepingOwl\Admin\Display\Filter\FilterBase::setValue(mixed $value): return self
    

```php
AdminDisplayFilter::field('category_id')->setValue(1);
```

## Фильтр по полю
Данный фильтр привязан к полю модели.

```php
AdminDisplayFilter::field('category_id');
```

### API

#### setOperator
Указание оператора сравнения. Помимо обычного сравнения вы можете указать как именно фильтр должен проверять значение. 

    SleepingOwl\Admin\Display\Filter\FilterBase::setOperator(string $operator): return self
    
 - `equal` - `column = value`
 - `not_equal` - `column != value`
 - `less` - `column < value`
 - `less_or_equal` - `column <= value`
 - `greater` - `column > value`
 - `greater_or_equal` - `column >= value`
 - `begins_with` - `column like value%`
 - `not_begins_with` - `column not like value%`
 - `contains` - `column like %value%`
 - `not_contains` - `column not like %value%`
 - `ends_with` - `column like %value`
 - `not_ends_with` - `column not like %value`
 - `is_empty` - `column = ''`
 - `is_not_empty` - `column != ''`
 - `is_null` - `column is null`
 - `is_not_null` - `column is not null`
 - `between` - `column between value`
 - `not_between` - `column not between value`
 - `in` - `column in value`
 - `not_in` - `column not in value`

```php
AdminDisplayFilter::field('category_id')->setOperator('in'); // ?category_id[]=1&category_id[]=2&category_id[]=5
```

## Фильтр по [eloquent scopes](https://laravel.com/docs/5.2/eloquent#query-scopes)
Этот фильтр будет применять `scope` к вашему запросу. Допустим вы выводите список новостей и хотитет иметь возможность фильтровать ваши записи по `scope`, который имеется в модели `App\Post`, с помощью которой вы формируете список.

```php
<?php

namespace App;
class Post extends Model
{
    ...
    
    /**
     * @param     $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
    
    /**
     * @param     $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }
}
```

```php
$display = AdminDisplay::table()
    ->setFilters(
        AdminDisplayFilter::scope('latest'); // ?latest
        AdminDisplayFilter::scope('type'); // ?type=news | ?latest&type=news
    );
```

## Произвольный фильтр
Используется в случае если вы хотите задать фильтр с произвольным запросом

```php
AdminDisplayFilter::custom('custom_filter')->setCallback(function($query, $value) {
    $query->where('myField', $value);
}); // ?custom_filter=test
```

