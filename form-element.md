# Элементы формы (Поля)

 - [Text](#text)
 - [Number](#number)
 - [Password](#password)
 - [Hidden](#hidden)
 - [Date](#date)
 - [Datetime](#datetime)
 - [Timestamp](#timestamp)
 - [Time](#time)
 - [File](#file)
 - [Image](#image)
 - [Images](#images)
 - [Textarea](#textarea)
 - [Select](#select)
 - [Multi Select](#multiselect)
 - [Wysiwyg](#wysiwyg)
 - [Ckeditor](#ckeditor)
 - [Checkbox](#checkbox)
 - [Radio](#radio)
 - [Html](#html)
 - [Custom](#custom)
 - [View](#view)
 - [Upload](#upload)
 - [API](#api)

В качестве элемента формы может выступать любой класс, которые реализует интерфейс `Illuminate\Contracts\Support\Renderable`.
Для полноцнной работы класс поля должен реализовать интерфейс `SleepingOwl\Admin\Contracts\FormElementInterface`


<a name="text"></a>
## Text

```php
AdminFormElement::text(string $key, string $label = null)
// $key - Ключ поля
// $label - Заголовок
```

<a name="number"></a>
## Number

```php
AdminFormElement::number(string $key, string $label = null)
// $key - Ключ поля
// $label - Заголовок
```

<a name="password"></a>
## Password

```php
AdminFormElement::password(string $key, string $label = null)
// $key - Ключ поля
// $label - Заголовок
```
#### Доступные методы
```php
$field->allowEmptyValue(); // Если пароль указан для текущего поля, то при валидации будет игнорироваться правило `required`

$field->hashWithBcrypt(); // Перед сохранением применить к паролю функцию bcrypt
$field->hashWithMD5(); // Перед сохранением применить к паролю функцию md5
$field->hashWithSHA1(); // Перед сохранением применить к паролю функцию sha1
```

<a name="hidden"></a>
## Hidden
```php
AdminFormElement::hidden(string $key)
// $key - Ключ поля
```

<a name="date"></a>
## Date
```php
AdminFormElement::date(string $key, string $label = null)
// $key - Ключ поля
// $label - Заголовок
```

#### Доступные методы
```php
$field->setFormat(string $fieldat); // Указание формата хранения даты в БД
$field->setPickerFormat(string $fieldat); // Указание формата отображения даты в поле (По умолчанию значение из конфига `dateFormat`)
$field->setCurrentDate(); // Установка текущей даты, если значение не указано
```

<a name="datetime"></a>
## Datetime
```php
AdminFormElement::datetime(string $key, string $label = null)
```

#### Доступные методы
```php
$field->setFormat(string $fieldat); // Указание формата хранения даты в БД
$field->setPickerFormat(string $fieldat); // Указание формата отображения даты в поле (По умолчанию значение из конфига `datetimeFormat`)
$field->setCurrentDate(); // Установка текущей даты, если значение не указано
$field->setSeconds(bool); // Показывать секунды в поле
```

<a name="timestamp"></a>
## Timestamp
```php
AdminFormElement::timestamp()
```

<a name="time"></a>
## Time
```php
AdminFormElement::time()
```

#### Доступные методы
```php
$field->setFormat(string $fieldat); // Указание формата хранения даты в БД
$field->setPickerFormat(string $fieldat); // Указание формата отображения даты в поле (По умолчанию значение из конфига `timeFormat`)
$field->setCurrentDate(); // Установка текущей даты, если значение не указано
```

<a name="file"></a>
## File
Загрузка файлов происходит через ajax и возвращает строку (относительный путь до файла).
```php
AdminFormElement::file(string $key, string $label = null)
// $key - Ключ поля
// $label - Заголовок
```

#### Доступные методы
```php
$field->setUploadPath(Closure $uploadPath); // Указание пути, куда будут сохраняться файлы
// Пример
$field->setUploadPath(function(\Illuminate\Http\UploadedFile $file) {
    // $file - объект загружаемого файла
    return public_path('files');
});

$field->setUploadFileName(Closure $uploadPath); // Указание имени файла
// Пример
$field->setUploadPath(function(\Illuminate\Http\UploadedFile $file) {
    // $file - объект загружаемого файла
    return $file->getClientOriginalName().'.'.$file->getClientOriginalExtension();
});

$field->maxSize(int $size); // Указание максимального размера загружаемого изображения
$field->minSize(int $size); // Указание минимального размера загружаемого изображения
```


<a name="image"></a>
## Image
Загрузка файлов происходит через ajax и возвращает строку (относительный путь до файла).
При загрузке изображений, файлы проходят валидацию `image`

```php
AdminFormElement::image(string $key, string $label = null)
// $key - Ключ поля
// $label - Заголовок
```

#### Доступные методы
```php
$field->setUploadPath(Closure $uploadPath); // Указание пути, куда будут сохраняться файлы
// Пример
$field->setUploadPath(function(\Illuminate\Http\UploadedFile $file) {
    // $file - объект загружаемого файла
    return public_path('files');
});

$field->setUploadFileName(Closure $uploadPath); // Указание имени файла
// Пример
$field->setUploadPath(function(\Illuminate\Http\UploadedFile $file) {
    // $file - объект загружаемого файла
    return $file->getClientOriginalName().'.'.$file->getClientOriginalExtension();
});

$field->setUploadSettings(array settings); // Указание настроек для обработки загружаемого изображения. 
// В качестве ключей массива используются названия функций http://image.intervention.io/
// Пример
$field->setUploadSettings([
    'orientate' => [],
    'resize' => [1280, null, function ($constraint) {
        $constraint->upsize();
        $constraint->aspectRatio();
    }],
    'fit' => [200, 300, function ($constraint) {
        $constraint->upsize();
        $constraint->aspectRatio();
    }]
]);

$field->maxSize(int $size); // Указание максимального размера загружаемого изображения
$field->minSize(int $size); // Указание минимального размера загружаемого изображения
```

<a name="images"></a>
## Images
Загрузка файлов происходит через ajax и возвращает строку (относительный путь до файла).
При загрузке изображений, файлы проходят валидацию `image`

При сохранении поля в модель передается массив изображений. 

```php
AdminFormElement::images(string $key, string $label = null)
// $key - Ключ поля
// $label - Заголовок
```

#### Доступные методы
Для данного поля доступны все методы поля `image`

```php
$field->storeAsJson(); // При сохранении преобразовать массив в json строку
$field->storeAsComaSeparatedValue(); // При сохранении преобразовать массив в строку с разделителем ","
```


<a name="textarea"></a>
## Textarea

```php
AdminFormElement::textarea(string $key, string $label = null)
// $key - Ключ поля
// $label - Заголовок
```

#### Доступные методы
```php
$field->setRows(int $rows); // Указание кол-ва строк
```

<a name="select"></a>
## Select
``php
AdminFormElement::select(string $key, string $label = null)
// $key - Ключ поля
// $label - Заголовок
```

#### Доступные методы
```php
$field->setModelForOptions(string|\Illuminate\Database\Eloquent\Model $model, string $titleKey = null) // Указание модели в качестве элементов списка
$field->setDisplay(string $titleKey) // Указание поля модели, используемого в качестве заголовка
$field->setFetchColumns(...$columns) // При использовании модели указание списка загружаемых полей
$field->setLoadOptionsQueryPreparer(Closure $callback) // При использовании модели перед загрузкой списка возможность изменения запроса
// Пример
$field->setLoadOptionsQueryPreparer(function($item, $query) {
	return $query->where('column', 'value')->were('owner_id', Auth::user()->id)
})

$field->setOptions(array $options) // Указание элементов списка

$field->setEnum(array $options) // Указание элементов списка (без ключей)

$field->nullable() // Возможность оставлять поле пустым
$field->exclude(array $keys) // Исключение из списика элементов
```

<a name="multiselect"></a>
## MultiSelect
```php
AdminFormElement::multiSelect(string $key, string $label = null)
// $key - Ключ поля
// $label - Заголовок
```

#### Доступные методы
Доступны все методы поля `select`

```php
$field->taggable() // Возможность указывать собственные варианты
$field->isDeleteRelatedItem() // Если значение было ранее выбрано и сейчас убирается из списика, удалить его. (необходимо протестировать)
```

<a name="wysiwyg"></a>
## Wysiwyg
```php
AdminFormElement::wysiwyg(string $key, string $label = null, string $editor = null)
// $key - Ключ поля
// $label - Заголовок
// $editor - ключ редактора
```

#### Доступные методы

```php
$field->setFilteredValueToField(string $field) // Указание поля, где будет храниться преобразованный текст в HTML (Используется для редакторов типа markdown)
$field->disableFilter() // Отключить фильтр (При использовании markdown редактора, перед сохранением значения, он его компилирует в HTML)

$field->setEditor(string $editor) // указание редактора текста (Доступны редакторы ckeditor, tinymce, simplemde)
$field->setHeight(int $height) // указание высоты редактора
$field->setParameters(array $parameters) // передача дополнительных настроек в редактор (Будут преобразованы в json)
```

<a name="ckeditor"></a>
## Ckeditor
Алиас для поля `wysiwyg` с подключением редактора `ckeditor`

```php
AdminFormElement::ckeditor(string $key, string $label = null)
// $key - Ключ поля
// $label - Заголовок
```

<a name="checkbox"></a>
## Checkbox
```php
AdminFormElement::checkbox(string $key, string $label = null)
// $key - Ключ поля
// $label - Заголовок
```

<a name="radio"></a>
## Radio
Доступны все методы из поля `select`

```php
AdminFormElement::radio(string $key, string $label = null)
// $key - Ключ поля
// $label - Заголовок
```

<a name="html"></a>
## Html
Поле для вывода обычного HTML кода

```php
AdminFormElement::html(string $html)
```

<a name="custom"></a>
## Custom
Поле для вывода д

```php
AdminFormElement::custom(Closure $callback = null)
// $callback - функция, которая будет вызвана при сохранении поля
```

#### Доступные методы

```php
$field->setCallback(Closure $callback) // Функция, которая будет вызвана при сохранении поля
$field->setDisplay(Closure|string $display) // Контент, который будет выведен для поля
// Пример
$field->setDisplay(function(Model $model) {
   return (string);
})
```

<a name="view"></a>
## View
Поле для 

```php
AdminFormElement::view(string $view, array $data = [], Closure $callback = null)
// $view - путь до шаблона
// $data - массив который будет передан в шаблон (также туда будет передана модель)
// $callback - функция, которая будет вызвана при сохранении поля
```

#### Доступные методы

```php
$field->setCallback(Closure $callback) // Функция, которая будет вызвана при сохранении поля
$field->setView(string $path) // путь до шаблона
$field->setData(array $data) // массив который будет передан в шаблон (также туда будет передана модель)
```

<a name="upload"></a>
## Upload
Поле `AdminFormElement::upload('image', 'Image')` используется для загрузки файлов на сервер посредством `<input type="upload" />`.

При добавлении поля, форма должна автоматически получить html атрибут `enctype="multipart/form-data"`. Если этого не произошло, вы можете добавить атрибут вручную:

```php
return AdminForm::panel()
    ....
    ->setHtmlAttribute('enctype', 'multipart/form-data');
```

Для работы с этим полем существует специальный трейт `KodiComponents\Support\Upload`, который поможет с загрузкой прикрепленного файла и сохранением ссылки на него в БД. (При желании данный трейт можно использовать отдельно, используя composer пакет `kodicomponents/support`)

**Пример использования:**

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

#### Валидация
Данный тип поля поддерживает валидацию загружаемых файлов
 - https://laravel.com/docs/5.2/validation#rule-image
 - https://laravel.com/docs/5.2/validation#rule-mimetypes
 - https://laravel.com/docs/5.2/validation#rule-mimes

```php
AdminFormElement::upload('image', 'Image')->addValidationRule('image')

// or for file

AdminFormElement::upload('pdf', 'PDF')->addValidationRule('mime:pdf'),
```

#### Ограничение использования трейта
**!!!Трейт переопределет методы `getAttribute`, `mutateAttribute`, `setAttribute`, в случае, если они переопределены у вас в модели, могут возникнуть проблемы в работе!!!**

---


<a name="api"></a>
## API

### addValidationRule
Добавление [правила валидации](https://laravel.com/docs/5.3/validation#available-validation-rules)

```php
$field->addValidationRule(string $rule, string $message = null)
```

### setValidationRules
Добавление [правил валидации](https://laravel.com/docs/5.3/validation#available-validation-rules) в виде массива

### required
Поле обязательно для заполнения

```php
$field->required(string $message = null)
```

### unique
Поле должно быть уникальным

```php
$field->unique(string $message = null)
```

### addValidationMessage
Изменение сообщения для правила валидации

```php
$field->addValidationMessage(string $rule, string $message)
```

### setView
Указания шаблона для отображения. При передачи пути до шаблона, поиск будет производиться с учетом view namespace `sleepingowl::`
При передачи объекта `\Illuminate\View\View`, в него будут перданы данные поля и произведен вывод

```php
$field->setView(\Illuminate\View\View|string $view)
```

### setPath
Указание ключа поля.

```php
$field->setPath(string $path)
```

### setLabel
Указание заголовка поля.

```php
$field->setName(string $label)
```

### setDefaultValue
Указание значения по умолчанию

```php
$field->setDefaultValue(mixed $defaultValue)
```

### setHelpText
Указание вспомогательного текста

```php
$field->setHelpText(string|\Illuminate\Contracts\Support\Htmlable $helpText)
```

### setReadonly
Установка атрибута "только для чтения"

```php
$field->setReadonly(bool $status)
```

### mutateValue
Изменение значения поля перед передачей в модель

```php
$field->mutateValue(Closure $mutator)
```

**Пример**
```php
$field->mutateValue(function($value) {
    return bcrypt($value);
})
```


---

<a name="validation-examples"></a>
### Примеры указания правил валидации

Для каждого элемента формы `AdminFormElement` можно указывать павила валидации.

**Пример**
```php
AdminFormElement::text('title', 'Title')
    ->required()
    ->unique();
```

Если вы хотите переопределить стандартное сообщение для правила, вы можете воспользоваться одним из сопособов:

```php
AdminFormElement::text('title', 'Title')
    ->required('Поле обязательно для заполнения')
    ->unique('Поле должно содержать уникальное значение')

// Или

AdminFormElement::text('title', 'Title')
    ->addValidationRule('required', 'Поле обязательно для заполнения')
    ->addValidationRule('number', 'Поле должно быть числом');

// Или

AdminFormElement::text('title', 'Title')
    ->required()
    ->addValidationMessage('required', 'Поле обязательно для заполнения');
```