# Формы

Используются для построения форм.

На текущий момент существую следующие виды форм:
 - `AdminForm::form()`
 - `AdminForm::panel()` - в основе которой лежит [Bootstrap конпонент `panel`](http://getbootstrap.com/components/#panels)
 - `AdminForm::tabbed()` - для группировки элементов формы в табы

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

## panel
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

# API (методы доступные во всех классах)

В классах форм используется трейт:
 - [HtmlAttributes](html_attributes.md), с помощью которого для них можно настраивать HTML атрибуты.
 - [Assets](assets_trait.md), с помощью которого для них можно подключать ассеты.

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
    
# Элементы формы (Поля)
В качестве элемента формы может выступать любой класс, которые реализует интерфейс `Illuminate\Contracts\Support\Renderable`.

## AdminColumn
в случае необходимости можно использовать колонки таблиц

```php
AdminForm::form()->setElements([
    AdminFormElement::upload('image', 'Image'), // Элемент загрузки картинки
    AdminColumn::image('image', 'Image') // Вывод загружененой картинки
])
```

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

## Upload
Поле `AdminFormElement::upload('image', 'Image')` используется для загрузки файлов на сервер посредством `<input type="upload" />`.

При добавлении поля, форма должна автоматически получить html атрибут `enctype="multipart/form-data"`. Если этого не произошло, вы можете добавить атрибут вручную:

```php
return AdminForm::panel()
    ....
    ->setHtmlAttribute('enctype', 'multipart/form-data');
```

Для работы с этим полем существует специальный трейт `KodiComponents\Support\Upload`, который поможет с загрузкой прикрепленного файла и сохранением ссылки на него в БД. (При желании данный трейт можно использовать отдельно, используя composer пакет `kodicomponents/support`)

Пример использования:

```php
class User extends Model
{
    use \KodiComponents\Support\Upload;
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'image' => 'image', // or file | upload
    ];
}
```

После добавления трейта в модель необходимо в `$casts` указать поля, которые должны работать с файлами. Для файлов необходимо указать тип `file` или `upload`, для изображений `image`. **В качестве файла ожидается объект `Illuminate\Http\UploadedFile`**

Если тип файла указан `image`, то можно указать правила обработки изображения (Для работы с изображениями используется пакет http://image.intervention.io/)

```php
/**
 * @return array
 */
public function getUploadSettings()
{
    return [
        'image' => [ // Ключ поля
            // Название функции, которую необходимо применить к изображению http://image.intervention.io/api/fit и параметры передаваемые в нее
            'fit' => [300, 300, function ($constraint) {
                $constraint->upsize();
                $constraint->aspectRatio();
            }],
            'crop' => [300, 300], // http://image.intervention.io/api/crop
            ...
        ],
        'image_small' => [
            ...
        ]
    ];
}
```

По умолчанию путь сохранения файла: `public\storage\{table_name}\{field_name}\{file_name_hash:2chars}\{uniqid}.{ext}`.
При желании можно указать свой формат имени файла

```php
/**
 * @param UploadedFile $file
 *
 * @return string
 */
protected function getUploadFilename(\Illuminate\Http\UploadedFile $file)
{
    return md5($this->id).'.'.$file->getClientOriginalExtension();
}
```
Путь хранения файла пока что изменить невозможно.

В случае если у вас несколько файлов изображений, например, миниатюра и большое изображение и вы хотите загружать их через одно поле, то можно сделать следующим образом:

```php
/**
 * The attributes that should be cast to native types.
 *
 * @var array
 */
protected $casts = [
    'image' => 'image',
    'thumb' => 'image',
];

/**
 * @return array
 */
public function getUploadSettings()
{
    return [
        'image' => [
            'orientate' => [],
            'resize' => [1280, null, function ($constraint) {
                $constraint->upsize();
                $constraint->aspectRatio();
            }]
        ],
        'thumb' => [
            'orientate' => [],
            'fit' => [200, 300, function ($constraint) {
                $constraint->upsize();
                $constraint->aspectRatio();
            }]
        ]
    ];
}

/**
 * @param \Illuminate\Http\UploadedFile $file
 */
public function setUploadImageAttribute(\Illuminate\Http\UploadedFile $file = null)
{
    if (is_null($file)) {
        return;
    }

    foreach ($this->getUploadFields() as $field) {
        $this->{$field.'_file'} = $file;
    }
}
```

И в форме указываем `AdminFormElement::upload('upload_image', 'Image')`, т.е. прикрепленный файл через поле с ключем `upload_image` будет передан в модель в созданный нами мутатор `setUploadImageAttribute`, где файл будет передан в нужные нам поля и сохранен согласно их правилам.

Также для загруженного файла доступны ссылка на файл и абсолюьтный путь. Например рассмотрим поле с ключем `image`:

 - `$user->image` `public\storage\users\image\23n4b23hj4b.jpg`
 - `$user->image_path` `\var\www\site.com\public\storage\users\image\23n4b23hj4b.jpg`
 - `$user->image_url` `http:\\site.com\storage\users\image\23n4b23hj4b.jpg`
 - 
 
### Валидация
Данный тип поля поддерживает валидацию загружаемых файлов 
 - https://laravel.com/docs/5.2/validation#rule-image
 - https://laravel.com/docs/5.2/validation#rule-mimetypes
 - https://laravel.com/docs/5.2/validation#rule-mimes

```php
AdminFormElement::upload('image', 'Image')->addValidationRule('image')

// or for file

AdminFormElement::upload('pdf', 'PDF')->addValidationRule('mime:pdf'),
```

### Ограничение использования трейта
**!!!Трейт переопределет методы `getAttribute`, `mutateAttribute`, `setAttribute`, в случае, если они переопределены у вас в модели, могут возникнуть проблемы в работе!!!**
