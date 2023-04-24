# HTML атрибуты

Данный trait используется для организации работы с HTML атрибутами в классах. Это может пригодится, если вы создаете например класс,
который на выходе будет преобразован в HTML и необходимо дать пользователю возможность указать css классы, идентификатор и другие атрибуты 
для элемента.

Допустим у нас есть класс `TableColumn`, который преобразуется в `<td>{{ $value }}</td>` и вы хотите дать пользователю
возможность указывать атрибуты, чтобы на выходе получить `<td class="bg-primary" id="row-3" data-value="test"></test>`

Для этого классу необходимо подключить данный trait

```php
<?php

namespace SleepingOwl\Admin\Display;

use KodiComponents\Support\HtmlAttributes;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Renderable;

class TableColumn implements Arrayable, Renderable
{
    use HtmlAttributes;
    
    public function toArray()
    {
        return [
            'value' => 'test',
            'attributes' => $this->htmlAttributesToString(),
        ];
    }

    public function render()
    {
        return view(
            'table_column',
            $this->toArray()
        );
    }
}
```

```html
<td {{ $attributes }}>{{ $value }}</td>
```

И теперь можно данному классу можно назначать атрибуты

## API

<a name="set"></a>
## setHtmlAttribute
Указание HTML атрибута

```php
$column->setHtmlAttribute('class', 'bg-primary');
$column->setHtmlAttribute('class', 'text-right');
$column->setHtmlAttribute('id', 'row-3');
$column->setHtmlAttribute('data-value', 'test');

// Или в виде массива

$column->setHtmlAttributes([
   'class' => ['bg-primary', 'text-right'],
   'id' => 'row-3',
   'data-value' => 'test'
]);

// return <td class="bg-primary text-right" id="row-3" data-value="test">test</td>
```

<a name="replace"></a>
## replaceHtmlAttribute
Переопределение класса

```php
$column->replaceHtmlAttribute('class', 'new-class');

// return <td class="new-class" id="row-3" data-value="test">test</td>
```

<a name="has-class"></a>
## hasClassProperty
Проверка на существование класса

```php
$column->setHtmlAttribute('class', 'new-class');
$column->hasClassProperty('new-class'); // return true
```

<a name="has-attribute"></a>
## hasHtmlAttribute
Проверка на существование атрибута

```php
$column->setHtmlAttribute('data-value', 'test');
$column->hasHtmlAttribute('data-value'); // return true
```

<a name="remove"></a>
## removeHtmlAttribute
Удаление атрибута

```php
$column->removeHtmlAttribute('data-value');
```

<a name="clear-all"></a>
## clearHtmlAttributes
Удаление всех атрибутов

```php
$column->clearHtmlAttributes();
```

<a name="to-string"></a>
## htmlAttributesToString
Преобразование атрибутов в строку

```php
$column->htmlAttributesToString();
// return "class="new-class" id="row-3" data-value="test""
```