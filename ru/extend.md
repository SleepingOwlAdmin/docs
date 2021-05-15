# Добавление новых элементов

 - [Display](#display)
    - [Column](#column)
    - [Column Editable](#column-editable)
    - [Column Filter](#column-filter)
    - [Filter](#display-filter)
 - [Form](#form)
    - [Element](#form-element)


Для расширения возможностей админ панели вы можете создавать свои классы и использовать их в качестве элементов.

**Пример**

```php
$display = \AdminDisplay::table();
$display->setColumns([
	\AdminColumn::link('title') // Передача через фасад
	new \App\Display\Column\CustomColumn(...)
])
```

Для удобства использования и возможности выноса элементов в отдельные пакеты в системе реализована регистрация классов
через класс `SleepingOwl\Admin\AliasBinder`, который помогает связать класс с коротким именем и создавать новый объект 
при запросе класса по ключу.

**Пример: допустим вы решили добавить новый элемент формы:**
```php

class AppServiceProvider extends ServiceProvider
{
	public function boot() 
	{
		$formElementContainer = app('sleeping_owl.form.element');
		
		$formElementContainer->add('email', App\Form\Element::class);
		// или
		\AdminFormElement::add('email', App\Form\Element::class);
	}
}
```

Регистрация всех основных элементов происходит в классе [AliasesServiceProvider](https://github.com/LaravelRUS/SleepingOwlAdmin/blob/development/src/Providers/AliasesServiceProvider.php)

Особенности при регистрации контейнеров рассмотрим отдельно для каждого типа.

<a name="display"></a>
## Display

 - Контейнер `sleeping_owl.display`
 - Фасад `AdminDisplay`

При добавлении класса необходимо, чтобы он реализовывал интерфейс `SleepingOwl\Admin\Contracts\DisplayInterface`
Для удобства существует абстрактный класс, в котором реализованы базовые возможности `SleepingOwl\Admin\Display\Display`

#### Список доступных элементов
```php
'datatables'      => \SleepingOwl\Admin\Display\DisplayDatatables::class,
'datatablesAsync' => \SleepingOwl\Admin\Display\DisplayDatatablesAsync::class,
'tab'             => \SleepingOwl\Admin\Display\DisplayTab::class,
'tabbed'          => \SleepingOwl\Admin\Display\DisplayTabbed::class,
'table'           => \SleepingOwl\Admin\Display\DisplayTable::class,
'tree'            => \SleepingOwl\Admin\Display\DisplayTree::class,
'page'            => \SleepingOwl\Admin\Navigation\Page::class,
```


<a name="column"></a>
## Column

 - Контейнер `sleeping_owl.table.column`
 - Фасад `AdminColumn`
 
При добавлении класса необходимо, чтобы он реализовывал интерфейс `SleepingOwl\Admin\Contracts\ColumnInterface`
Для удобства существует абстрактный класс, в котором реализованы базовые возможности 
 - `SleepingOwl\Admin\Display\TableColumn` - класс без привязки к Eloquent модели
 - `SleepingOwl\Admin\Display\Column\NamedColumn` - с привязкой к Eloquent модели
 
#### Список доступных элементов
```php
'action'      => \SleepingOwl\Admin\Display\Column\Action::class,
'checkbox'    => \SleepingOwl\Admin\Display\Column\Checkbox::class,
'control'     => \SleepingOwl\Admin\Display\Column\Control::class,
'count'       => \SleepingOwl\Admin\Display\Column\Count::class,
'custom'      => \SleepingOwl\Admin\Display\Column\Custom::class,
'datetime'    => \SleepingOwl\Admin\Display\Column\DateTime::class,
'filter'      => \SleepingOwl\Admin\Display\Column\Filter::class,
'image'       => \SleepingOwl\Admin\Display\Column\Image::class,
'lists'       => \SleepingOwl\Admin\Display\Column\Lists::class,
'order'       => \SleepingOwl\Admin\Display\Column\Order::class,
'text'        => \SleepingOwl\Admin\Display\Column\Text::class,
'link'        => \SleepingOwl\Admin\Display\Column\Link::class,
'relatedLink' => \SleepingOwl\Admin\Display\Column\RelatedLink::class,
'email'       => \SleepingOwl\Admin\Display\Column\Email::class,
'treeControl' => \SleepingOwl\Admin\Display\Column\TreeControl::class,
```


<a name="column-editable"></a>
## Column Editable

 - Контейнер `sleeping_owl.table.column.editable`
 - Фасад `AdminColumnEditable`
 
При добавлении класса необходимо, чтобы он реализовывал интерфейс 
 - `SleepingOwl\Admin\Contracts\ColumnInterface`
 - `SleepingOwl\Admin\Contracts\Display\ColumnEditableInterface`
 
#### Список доступных элементов
```php
'checkbox'    => \SleepingOwl\Admin\Display\Column\Editable\Checkbox::class,
```


<a name="column-filter"></a>
## Column Filter

 - Контейнер `sleeping_owl.column_filter`
 - Фасад `AdminColumnFilter`
 
При добавлении класса необходимо, чтобы он реализовывал интерфейс `SleepingOwl\Admin\Contracts\ColumnFilterInterface`
Для удобства существует абстрактный класс, в котором реализованы базовые возможности `SleepingOwl\Admin\Display\Column\Filter\BaseColumnFilter`

#### Список доступных элементов
```php
'text' => \SleepingOwl\Admin\Display\Column\Filter\Text::class,
'date' => \SleepingOwl\Admin\Display\Column\Filter\Date::class,
'daterange' => \SleepingOwl\Admin\Display\Column\Filter\DateRange::class,
'range' => \SleepingOwl\Admin\Display\Column\Filter\Range::class,
'select' => \SleepingOwl\Admin\Display\Column\Filter\Select::class,
```

<a name="display-filter"></a>
## Display Filter

 - Контейнер `sleeping_owl.display.filter`
 - Фасад `AdminDisplayFilter`
 
При добавлении класса необходимо, чтобы он реализовывал интерфейс `SleepingOwl\Admin\Contracts\FilterInterface`
Для удобства существует абстрактный класс, в котором реализованы базовые возможности `SleepingOwl\Admin\Display\Filter\FilterBase`

#### Список доступных элементов
```php
'field'   => \SleepingOwl\Admin\Display\Filter\FilterField::class,
'scope'   => \SleepingOwl\Admin\Display\Filter\FilterScope::class,
'custom'  => \SleepingOwl\Admin\Display\Filter\FilterCustom::class,
'related' => \SleepingOwl\Admin\Display\Filter\FilterRelated::class,
```

<a name="form"></a>
## Form

 - Контейнер `sleeping_owl.display.filter`
 - Фасад `AdminDisplayFilter`
 
При добавлении класса необходимо, чтобы он реализовывал интерфейс 
 - `SleepingOwl\Admin\Contracts\FormInterface`
 - `SleepingOwl\Admin\Contracts\DisplayInterface`
 
Для удобства класс формы можно наследовать от `SleepingOwl\Admin\Form\FormDefault`

#### Список доступных элементов
```php
'form' => \SleepingOwl\Admin\Form\FormDefault::class,
'elements' => \SleepingOwl\Admin\Form\FormElements::class,
'tabbed' => \SleepingOwl\Admin\Form\FormTabbed::class,
'panel' => \SleepingOwl\Admin\Form\FormPanel::class,
```

<a name="form-element"></a>
## Form Element

 - Контейнер `sleeping_owl.form.element`
 - Фасад `AdminFormElement`
 
При добавлении класса необходимо, чтобы он реализовывал интерфейс `SleepingOwl\Admin\Contracts\FormElementInterface`
Для удобства существует абстрактный класс, в котором реализованы базовые возможности 
 - `SleepingOwl\Admin\Form\FormElement` - класс без привязки к Eloquent модели
 - `SleepingOwl\Admin\Form\Element\NamedFormElement` - с привязкой к Eloquent модели

#### Список доступных элементов
```php
'columns'           => \SleepingOwl\Admin\Form\Columns\Columns::class,
'text'              => \SleepingOwl\Admin\Form\Element\Text::class,
'time'              => \SleepingOwl\Admin\Form\Element\Time::class,
'date'              => \SleepingOwl\Admin\Form\Element\Date::class,
'daterange'         => \SleepingOwl\Admin\Form\Element\DateRange::class,
'timestamp'         => \SleepingOwl\Admin\Form\Element\Timestamp::class,
'textaddon'         => \SleepingOwl\Admin\Form\Element\TextAddon::class,
'select'            => \SleepingOwl\Admin\Form\Element\Select::class,
'multiselect'       => \SleepingOwl\Admin\Form\Element\MultiSelect::class,
'hidden'            => \SleepingOwl\Admin\Form\Element\Hidden::class,
'checkbox'          => \SleepingOwl\Admin\Form\Element\Checkbox::class,
'ckeditor'          => \SleepingOwl\Admin\Form\Element\CKEditor::class,
'custom'            => \SleepingOwl\Admin\Form\Element\Custom::class,
'password'          => \SleepingOwl\Admin\Form\Element\Password::class,
'textarea'          => \SleepingOwl\Admin\Form\Element\Textarea::class,
'view'              => \SleepingOwl\Admin\Form\Element\View::class,
'image'             => \SleepingOwl\Admin\Form\Element\Image::class,
'images'            => \SleepingOwl\Admin\Form\Element\Images::class,
'file'              => \SleepingOwl\Admin\Form\Element\File::class,
'radio'             => \SleepingOwl\Admin\Form\Element\Radio::class,
'wysiwyg'           => \SleepingOwl\Admin\Form\Element\Wysiwyg::class,
'upload'            => \SleepingOwl\Admin\Form\Element\Upload::class,
'html'              => \SleepingOwl\Admin\Form\Element\Html::class,
'number'            => \SleepingOwl\Admin\Form\Element\Number::class,
'dependentselect'   => \SleepingOwl\Admin\Form\Element\DependentSelect::class,
```