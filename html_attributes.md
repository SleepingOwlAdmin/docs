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

```php
$column = new TableColumn();

$column->setHtmlAttribute('class', 'bg-primary');
$column->setHtmlAttribute('class', 'text-right');
$column->setHtmlAttribute('id', 'row-3');
$column->setHtmlAttribute('data-valie', 'test');

// Or

$column->setHtmlAttributes([
   'class' => ['bg-primary', 'text-right'],
   'id' => 'row-3',
   'data-valie' => 'test'
]);

// return <td class="bg-primary text-right" id="row-3" data-valie="test">test</td>

// Переопределение класса
$column->replaceHtmlAttribute('class', 'new-class');

// return <td class="new-class" id="row-3" data-valie="test">test</td>

// Проверка на существование класса 
$column->hasClassProperty('new-class'); // return true

// Проверка на существование атрибута
$column->hasHtmlAttribute('data-value'); // return true

// Удаление атрибута
$column->removeHtmlAttribute('data-value');

// Удаление всех атрибутов
$column->clearHtmlAttributes();


// Преобразование атрибутов в строку
$column->htmlAttributesToString();
// return "class="new-class" id="row-3" data-valie="test""
```
