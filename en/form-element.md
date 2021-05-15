# Form elements (Fields)

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

As form element can be some class with interface  `Illuminate\Contracts\Support\Renderable`.
All form element should implement interface `SleepingOwl\Admin\Contracts\FormElementInterface`


<a name="text"></a>
## Text

```php
AdminFormElement::text(string $key, string $label = null)
// $key - Model key
// $label - Title
```

<a name="number"></a>
## Number

```php
AdminFormElement::number(string $key, string $label = null)
// $key - Model key
// $label - Title
```

<a name="password"></a>
## Password

```php
AdminFormElement::password(string $key, string $label = null)
// $key - Model key
// $label - Title
```
#### Methods
```php
$field->allowEmptyValue(); // If password set, skip "`"required" validation rule

$field->hashWithBcrypt(); // Before saving hash password with bcrypt
$field->hashWithMD5(); // Before saving hash password with md5
$field->hashWithSHA1(); // Before saving hash password with sha1
```

<a name="hidden"></a>
## Hidden
```php
AdminFormElement::hidden(string $key)
// $key - Model key
```

<a name="date"></a>
## Date
```php
AdminFormElement::date(string $key, string $label = null)
// $key - Model key
// $label - Title
```

#### Methods
```php
$field->setFormat(string $fieldat); // Database date format
$field->setPickerFormat(string $fieldat); // Picker date format (Default: `sleeping_owl.dateFormat`)
$field->setCurrentDate(); // Set current date by default
```

<a name="datetime"></a>
## Datetime
```php
AdminFormElement::datetime(string $key, string $label = null)
// $key - Model key
// $label - Title
```

#### Methods
```php
$field->setFormat(string $fieldat); // Database date format
$field->setPickerFormat(string $fieldat); // Picker date format (Default: `sleeping_owl.datetimeFormat`)
$field->setCurrentDate(); // Set current date by default
$field->setSeconds(bool); // Show seconds
```

<a name="timestamp"></a>
## Timestamp
```php
AdminFormElement::timestamp(string $key, string $label = null)
// $key - Model key
// $label - Title
```

<a name="time"></a>
## Time
```php
AdminFormElement::time(string $key, string $label = null)
// $key - Model key
// $label - Title
```

#### Methods
```php
$field->setFormat(string $fieldat); // Database date format
$field->setPickerFormat(string $fieldat); // Picker date format (Default: `sleeping_owl.timeFormat`)
$field->setCurrentDate(); // Set current date by default
```

<a name="file"></a>
## File
File uploading via ajax and return relative file path

```php
AdminFormElement::file(string $key, string $label = null)
// $key - Model key
// $label - Title
```

#### Methods
```php
$field->setUploadPath(Closure $uploadPath); // Setting file upload path
// Example
$field->setUploadPath(function(\Illuminate\Http\UploadedFile $file) {
    // $file - file object
    return public_path('files');
});

$field->setUploadFileName(Closure $uploadPath); // Setting file name
// Example
$field->setUploadFileName(function(\Illuminate\Http\UploadedFile $file) {
    // $file - file object
    return $file->getClientOriginalName().'.'.$file->getClientOriginalExtension();
});

$field->maxSize(int $size); // Setting max file size
$field->minSize(int $size); // Setting min file size
```


<a name="image"></a>
## Image
File uploading via ajax and return relative file path
Use validation rule `image`

```php
AdminFormElement::image(string $key, string $label = null)
// $key - Model key
// $label - Title
```

#### Methods
```php
$field->setUploadPath(Closure $uploadPath); // Setting file upload path
// Example
$field->setUploadPath(function(\Illuminate\Http\UploadedFile $file) {
    // $file - file object
    return public_path('files');
});

$field->setUploadFileName(Closure $uploadPath); // Setting file name
// Example
$field->setUploadFileName(function(\Illuminate\Http\UploadedFile $file) {
    // $file - file object
    return $file->getClientOriginalName().'.'.$file->getClientOriginalExtension();
});

$field->setUploadSettings(array settings); // Image resize settings 
// See http://image.intervention.io/
// Example
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

$field->maxSize(int $size); // Setting max file size
$field->minSize(int $size); // Setting min file size
```

<a name="images"></a>
## Images
File uploading via ajax and return relative file path
Use validation rule `image`

This field by default set to model array of images

```php
AdminFormElement::images(string $key, string $label = null)
// $key - Model key
// $label - Title
```

#### Methods
All method of [image](#image)

```php
$field->storeAsJson(); // Encode data to json
$field->storeAsComaSeparatedValue(); // Encode data to string with "," separator
```


<a name="textarea"></a>
## Textarea

```php
AdminFormElement::textarea(string $key, string $label = null)
// $key - Model key
// $label - Title
```

#### Methods
```php
$field->setRows(int $rows); // Setting row numbers
```

<a name="select"></a>
## Select
```php
AdminFormElement::select(string $key, string $label = null)
// $key - Model key
// $label - Title
```

#### Methods
```php
$field->setModelForOptions(string|\Illuminate\Database\Eloquent\Model $model, string $titleKey = null) // Setting model for options
$field->setDisplay(string $titleKey) // Setting model options title
$field->setFetchColumns(...$columns) // Setting model query select fields
$field->setLoadOptionsQueryPreparer(Closure $callback) // Modify query
// Example
$field->setLoadOptionsQueryPreparer(function($item, $query) {
	return $query->where('column', 'value')->were('owner_id', Auth::user()->id)
})

$field->setOptions(array $options) // Settings array of options

$field->setEnum(array $options) // Settings options enums

$field->nullable() // Allow blank
$field->exclude(array $keys) // Exclude options by key
```

<a name="multiselect"></a>
## MultiSelect
```php
AdminFormElement::multiSelect(string $key, string $label = null)
// $key - Model key
// $label - Title
```

#### Methods
All method from [Select](#select)

```php
$field->taggable() // Allow select tags
```

<a name="wysiwyg"></a>
## Wysiwyg
```php
AdminFormElement::wysiwyg(string $key, string $label = null, string $editor = null)
// $key - Model key
// $label - Title
// $editor - Editor key
```

#### Methods

```php
$field->setFilteredValueToField(string $field) // Setting field key for compiled HTML value (For example if used markdown)
$field->disableFilter() // Disable compiling data to HTML (For example if used markdown)

$field->setEditor(string $editor) // Setting editor name (ckeditor, tinymce, simplemde, ...)
$field->setHeight(int $height) // Setting editor height
$field->setParameters(array $parameters) // Additionals params (Will be json encoded)
```

<a name="ckeditor"></a>
## Ckeditor
Alias for `wysiwyg`

```php
AdminFormElement::ckeditor(string $key, string $label = null)
// $key - Model key
// $label - Title
```

<a name="checkbox"></a>
## Checkbox
```php
AdminFormElement::checkbox(string $key, string $label = null)
// $key - Model key
// $label - Title
```

<a name="radio"></a>
## Radio
All method from [Select](#select)
```php
AdminFormElement::radio(string $key, string $label = null)
// $key - Model key
// $label - Title
```

<a name="html"></a>
## Html

```php
AdminFormElement::html(string $html)
```

<a name="custom"></a>
## Custom

```php
AdminFormElement::custom(Closure $callback = null)
// $callback - callback before saving
```

#### Methods

```php
$field->setCallback(Closure $callback) // callback before saving
$field->setDisplay(Closure|string $display) // HTML for displaing

// Example
$field->setDisplay(function(Model $model) {
   return (string);
})
```

<a name="view"></a>
## View
Extends [Custom](#custom)

```php
AdminFormElement::view(string $view, array $data = [], Closure $callback = null)
// $view - view path
// $data - array of data for view (will be add Form model)
// $callback - callback before saving
```

#### Methods

```php
$field->setCallback(Closure $callback) // callback before saving
$field->setView(string $path) // view path
$field->setData(array $data) // array of data for view (will be add Form model)
```

<a name="upload"></a>
## Upload
Field `upload` uses `<input type="upload" />`.

By add this field to form will be add html attribute `enctype="multipart/form-data"`. You can add this attribute manually

```php
return AdminForm::panel()
    ....
    ->setHtmlAttribute('enctype', 'multipart/form-data');
```

Use this trait `KodiComponents\Support\Upload` to work with this field,

**Example**

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

Use cast `file` or `upload` for files, and `image` for images.

If cast is `image`, you can use http://image.intervention.io/ for resize.

```php
/**
 * @return array
 */
public function getUploadSettings()
{
    return [
        'image' => [ // Model key
            // see http://image.intervention.io/api/fit
            'fit' => [300, 300, function ($constraint) {
                $constraint->upsize();
                $constraint->aspectRatio();
            }],
            // see http://image.intervention.io/api/crop
            'crop' => [300, 300],
            ...
        ],
        'image_small' => [
            ...
        ]
    ];
}
```

By default upload path is: `public\storage\{table_name}\{field_name}\{file_name_hash:2chars}\{uniqid}.{ext}`.

You can change default filename:

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

#### Model file fields

 - `$user->image` `public\storage\users\image\23n4b23hj4b.jpg`
 - `$user->image_path` `\var\www\site.com\public\storage\users\image\23n4b23hj4b.jpg`
 - `$user->image_url` `http:\\site.com\storage\users\image\23n4b23hj4b.jpg`
 -

#### Validation
This field supports
 - https://laravel.com/docs/5.2/validation#rule-image
 - https://laravel.com/docs/5.2/validation#rule-mimetypes
 - https://laravel.com/docs/5.2/validation#rule-mimes

```php
AdminFormElement::upload('image', 'Image')->addValidationRule('image')

// or for file

AdminFormElement::upload('pdf', 'PDF')->addValidationRule('mime:pdf'),
```

**!!!This trait uses `getAttribute`, `mutateAttribute`, `setAttribute` method!!!**

---


<a name="api"></a>
## API

### addValidationRule
Adding validation [rule](https://laravel.com/docs/5.3/validation#available-validation-rules)

```php
$field->addValidationRule(string $rule, string $message = null)
```

### setValidationRules
Adding [rules](https://laravel.com/docs/5.3/validation#available-validation-rules) as array

### required
Filed must be required

```php
$field->required(string $message = null)
```

### unique
Filed must be unique

```php
$field->unique(string $message = null)
```

### addValidationMessage
Change validation message for rule

```php
$field->addValidationMessage(string $rule, string $message)
```

### setView
Setting view template.

```php
$field->setView(\Illuminate\View\View|string $view)
```

### setPath
Setting model field key

```php
$field->setPath(string $path)
```

### setLabel
Setting title

```php
$field->setName(string $label)
```

### setDefaultValue
Setting default value

```php
$field->setDefaultValue(mixed $defaultValue)
```

### setHelpText
Setting help text

```php
$field->setHelpText(string|\Illuminate\Contracts\Support\Htmlable $helpText)
```

### setReadonly
Setting read only field

```php
$field->setReadonly(bool $status)
```

<a name="api-setValueSkipped"></a>
### `setValueSkipped(bool|Closure $valueSkipped)`
Sets flag to skip saving attribute value to model. By default `false`.

**If setting value must be skipped validation rules will be applied but there will be no value in model.**

For instance, when creating users you want to check if `password` and `password_confirmation` fields match, 
but you don't need `password_confirmation` to be saved in model's attributes:

```php
AdminFormElement::text('password', 'Password')->required();
AdminFormElement::text('password_confirmation', 'Password confirmation')
    ->setValueSkipped(true)
    ->required()
    ->addValidationRule('same:password', 'Passwords must match!');
```

### mutateValue
Mutate field value before form saving

```php
$field->mutateValue(Closure $mutator)
```

**Example**
```php
$field->mutateValue(function($value) {
    return bcrypt($value);
})
```
