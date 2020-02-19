# Столбцы Editable

- [Введение](#Введение)
- [Поддерживаемые типы](#Поддерживаемые-типы)
- [Заголовок столбца](#Заголовок-столбца)
- [API](#api)
- [Типы](#Типы)
    - [Checkbox](#checkbox-editable)
    - [Text](#text-editable)
    - [Textarea](#textarea-editable)
    - DateTime  
    - Select   


*Расширение для класса [отображения данных](displays)*


## Введение

Данные классы предназначены для добавления редактируемых колонок в таблицу. Данные колонки реализованы с помощь библиотеки [X-editable v1.5.1](http://vitalets.github.io/x-editable/) 

**Пример использования**

```php
...
use AdminColumnEditable;
...

AdminDisplay::table()
    ->setColumns([
        AdminColumnEditable::text('name')->setLabel('Название'),       
        AdminColumnEditable::textarea('content')->setLabel('Описание'),       
        AdminColumnEditable::select('category_id')->setWidth('250px')
                        ->setModelForOptions(new Category)
                        ->setLabel('Категория')
                        ->setDisplay('name')
                        ->setLoadOptionsQueryPreparer(function($element, $query) {
                            return $query->MyScoupe();
                        })->setTitle('Выберите категорию:'),
        
        AdminColumnEditable::checkbox('visible')->setLabel('Отображение')->setWidth('30px'),

                        
    ])
...
```

Класс `SleepingOwl\Admin\Display\TableColumn`, от которого наследуются
все столбцы, реализует интерфейсы `Illuminate\Contracts\Support\Arrayable`,
`Illuminate\Contracts\Support\Renderable` и `SleepingOwl\Admin\Contracts\Initializable`.


## Поддерживаемые типы

 - `AdminColumnEditable::text($name, $label = null)`
 - `AdminColumnEditable::select($name, $label = null)`
 - `AdminColumnEditable::textarea($name, $label = null)`
 - `AdminColumnEditable::datetime($name, $label = null)` 
 - `AdminColumnEditable::checkbox($name, $checkedLabel = null, $uncheckedLabel = null)`



## Заголовок столбца

Каждый столбец таблицы имеет заголовок и хранится в виде отдельного класса
`SleepingOwl\Admin\Contracts\Display\TableHeaderColumnInterface`.

**Пример работы с заголовком**

```php
...
    ->setColumns([
        ...
        AdminColumn::link('title')->setLabel('Title')->setOrderable(false),
        ...
    ]);
```

**Или работая напрямую с классом заголовка**
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



## API

<a name="all-methods"></a>
## Методы доступные во всех элементах
Во всех Editable элементах доступны методы обычных [столбцов таблиц](https://sleepingowladmin.ru/docs/columns#api) 

Помимо этого существуют специальные методы. 

<a name="set-label"></a>
#### setUrl
Вы можете установить свой url для отправки данных и принятия их в Кастом контроллере

    SleepingOwl\Admin\Display\Column\Editable\Checkbox::setUrl(string $url): return self
    
#### setTitle
Установка сообщения в форме редактирования значения.
    
    SleepingOwl\Admin\Display\Column\Editable\Checkbox::setTitle(string $title): return self
    
#### setEditableMode
Устанавливает способ появления формы редактирования. Внутри ячейки - 'inline' или по умолчанию во всплывающем окне - 'popup'
        
    SleepingOwl\Admin\Display\Column\Editable\Checkbox::setEditableMode(string $mode): return self


## Типы

<a name="checkbox_editable"></a>    

### CheckBox Editable
`SleepingOwl\Admin\Display\Column\Editable\Checkbox`
Данный элемент позволяет менять значение столбцов типа boolean прямо в таблице.

```
AdminColumnEditable::checkbox('visible')->setLabel('Отображение'),
//or
AdminColumnEditable::checkbox('visible','Видно', 'Не видно')->setLabel('Отображение'),
```


    
#### setCheckedLabel
Отображаемый текст в таблице при значении True

    SleepingOwl\Admin\Display\Column\Editable\Checkbox::setCheckedLabel(string $label): return self
    
#### setUncheckedLabel
Отображаемый текст в таблице при значении False

    SleepingOwl\Admin\Display\Column\Editable\Checkbox::setUncheckedLabel(string $label): return self



  
### Text Editable
`SleepingOwl\Admin\Display\Column\Editable\Text`
Данный элемент позволяет менять текстовое значение прямо в таблице.

```
AdminColumnEditable::text('name')->setLabel('Имя'),
```


   
### Textarea Editable
`SleepingOwl\Admin\Display\Column\Editable\Textarea`
Данный элемент позволяет менять текстовое значение прямо в таблице. В форме редактирования появится textarea.

```
AdminColumnEditable::textarea('description')->setLabel('Описание'),
```
