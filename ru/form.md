# Формы

 - [Default](#form)
 - [Panel](#panel)
 - [Tabbed](#tabbed)
 - [API](#api)
 - [Tabs](#tabs)
 - [Columns](#columns)

<a name="form"></a>
## form
 * Класс `\SleepingOwl\Admin\Form\FormDefault`
 * View `resources\views\default\form\default.blade.php`

Данный тип формы выводит элементы без дизайна. При желании внешний вид формы можно настроит с помощью HTML атрибутов

```php
$form = AdminForm::form()->setElements([
    AdminFormElement::text('title', 'Title'),
]);

$form->addElement(
    AdminFormElement::date('created_at', 'Created at')
);

$form->setHtmlAttribute('class', 'panel panel-default');
$form->getButtons()->setHtmlAttribute('class', 'panel-footer');
```

<a name="panel"></a>
## panel
в основе которой лежит [Bootstrap конпонент `panel`](http://getbootstrap.com/components/#panels)

 * Класс `\SleepingOwl\Admin\Form\FormPanel`
 * View `resources\views\default\form\panel.blade.php`

Данный тип формы автоматически добавляет к форме html атрибут `class="panel panel-default"` и к кнопкам формы `class="panel-footer"` и позволяет размещать элементы формы в блоки `header`, `body`, `footer`

```php
$form = AdminForm::panel()
    ->addHeader([
        AdminFormElement::text('title', 'Title'),
    ])
    ->addBody(
        AdminFormElement::wysiwyg('text', 'Text', 'ckeditor')->required()
    )
    ->addFooter(
        AdminFormElement::select('type', 'Type'), ...)
    );

$form->addItem(AdminFormElement::date('created_at', 'Created at'));

$form->addElement(AdminFormElement::date('created_at', 'Created at')); // Поместит элемент без блока

$form->setElements([
    AdminFormElement::date('created_at', 'Created at')
]); // Поместит список элементов без блока
```

Блоки формы - это классы, реализующие интерфейс `SleepingOwl\Admin\Contracts\Form\PanelInterface`, при необходимости вы можете создать свой класс блока и добавлять его в форму:

```php
$form->addElement(new \App\Form\Panel\CustomBlockClass([
    AdminFormElement::text('title', 'Title')
]));
```

### API

#### addItem
Добавление элемента в форму. Если в форме уже есть блоки (`header`, `body`, `footer`), то элемент будет добавлен в последний добавленый блок, если блоков нет, то будет создан блок `body` и в него помещен элемент.

    SleepingOwl\Admin\Form\FormDefault::addItem(mixed $item): return self

#### addHeader
Добавление элементов в блок `panel-heading`

    SleepingOwl\Admin\Form\FormPanel::addHeader(array|\SleepingOwl\Admin\Contracts\FormElementInterface $items): return self
    
#### addBody
Добавление элементов в блок `panel-body`. Если предыдущий блок `body`, то между ними будет вставлен элемент `<hr />`

    SleepingOwl\Admin\Form\FormPanel::addBody(array|\SleepingOwl\Admin\Contracts\FormElementInterface $items): return self
    
#### addFooter
Добавление элементов в блок `panel-footer`

    SleepingOwl\Admin\Form\FormPanel::addFooter(array|\SleepingOwl\Admin\Contracts\FormElementInterface $items): return self

<a name="tabbed"></a>
## tabbed
Разновидность форм, в которой элементы можно разделять на вкладки.

```php
AdminForm::tabbed()->setElements([
    'tab1' => [
        ....
    ],
    'tab2' => [
        ....
    ]
]);
```

<a name="api"></a>
# API (методы доступные во всех классах)

В классах форм используется трейт:
 - [HtmlAttributes](html_attributes.md), с помощью которого для них можно настраивать HTML атрибуты.
 - [Assets](assets.md#assets-trait), с помощью которого для них можно подключать ассеты.

#### setButtons
Указание класса отвечающего за вывод кнопок формы. По умолчанию `SleepingOwl\Admin\Form\FormButtons`

    SleepingOwl\Admin\Form\FormDefault::setButtons(\SleepingOwl\Admin\Contracts\FormButtonsInterface $buttons): return self

#### setView
Указание view отвечающего за вывод формы

    SleepingOwl\Admin\Form\FormDefault::setView(\Illuminate\View\View|string $view): return self
    
#### setAction
Указание ссылки, на которую будут отправлены данные формы.

    SleepingOwl\Admin\Contracts\FormInterface::setAction(string $action): return self
    
#### setElements
Добавление массива элементов в форму

    SleepingOwl\Admin\Contracts\Form\ElementsInterface::setElements(array $elements): return self
    

#### addElement
Добавление элемента в форму

    SleepingOwl\Admin\Form\FormElements::addElement(mixed $element): return self

## AdminColumn
в случае необходимости можно использовать колонки таблиц

```php
AdminForm::form()->setElements([
    AdminFormElement::upload('image', 'Image'), // Элемент загрузки картинки
    AdminColumn::image('image', 'Image') // Вывод загружененой картинки
])
```

<a name="tabs"></a>
## Табы
Вы можете в качестве элемента формы помещать табы. **Делайте названия табов уникальные при размещении несколько разделов со вкладками, т.к. табы могут включаться некорректно.**

```php
$tabs = AdminDisplay::tabbed();
$tabs->setTabs(function ($id) {
    $tabs = [];

    $tabs[] = AdminDisplay::tab(AdminForm::elements([
        AdminFormElement::text('title', 'Title')->required(),
    ]))->setLabel('SEO');

    $tabs[] = AdminDisplay::tab(new \SleepingOwl\Admin\Form\FormElements([
        AdminFormElement::date('created_at', 'Created at')->required()
    ]))->setLabel('Dates');

    return $tabs;
});

$tabs->appendTab([
    AdminFormElement::text('title', 'Title')->required(),
], 'Tab 1');


$tabs1 = AdminDisplay::tabbed();
    
$tabs1 = ....;


AdminForm::form()
    ->addElement($tabs)
    ->setElements([
        AdminFormElement::upload('image', 'Image'), // Элемент загрузки картинки
        AdminColumn::image('image', 'Image') // Вывод загружененой картинки
    ])
    ->addElement($tabs1);
    
// or

$form = AdminForm::panel()
    ->addHeader([
        $tabs
    ]);
    
// or

$form = AdminForm::panel()
    ->setElements([
        AdminFormElement::upload('image', 'Image'),
        $tabs
    ]);
```

<a name="columns"></a>
## Columns
Позволяет разбивать форму на несколько столбцов. Колонки могут быть использованы в табах и наоборот.

```php
$columns = AdminFormElement::columns([
    [
        AdminFormElement::text('title', 'Title')->required()
    ],
    // or 
    function() {
        return [
            AdminFormElement::text('title', 'Title')->required()
        ];
    },
    // or
    new \SleepingOwl\Admin\Form\Columns\Column([
        AdminFormElement::date('created_at', 'Created At')->required()
    ])
]);

$columns->addColumn([
    AdminFormElement::date('created_at', 'Created At')->required()
]);

// or 

$columns->addColumn(function() {
    return [
        AdminFormElement::date('created_at', 'Created At')->required()
    ];
});

// or

$columns->addColumn(new \SleepingOwl\Admin\Form\Columns\Column([
    AdminFormElement::date('created_at', 'Created At')->required()
]));



$columns->addColumn($subColumns = AdminFormElement::columns([
    [
        AdminFormElement::text('description', 'Description')
    ]
]);

$subColumns->addColumn(...)

$form = AdminForm::panel()->addBody($columns);
```

#### Пример использования колонок с табами
```php

$tabs = AdminDisplay::tabbed([
    'Tab 1' => new FormElements([
        AdminFormElement::text('title', 'Title')->required()
    ]),
    'Tab 2' => new FormElements([
        AdminFormElement::select('type', 'Type'),
        AdminFormElement::date('event_at', 'Event at')->setFormat('Y-m-d H:i:00')
    ])
]);

$columns = AdminFormElement::columns();

$columns->addColumn([$tabs]);

$columns->addColumn([
    AdminFormElement::date('created_at', 'Created at')
]);

// Or

$tabs->appendTab(new FormElements([$columns]));
```