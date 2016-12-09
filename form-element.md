# Элементы формы (Поля)

В качестве элемента формы может выступать любой класс, которые реализует интерфейс `Illuminate\Contracts\Support\Renderable`.
Для полноцнной работы класс поля должен реализовать интерфейс `SleepingOwl\Admin\Contracts\FormElementInterface`

## Список доступный полей формы

### Text

```php
AdminFormElement::text(string $key, string $label = null)
// $key - Ключ поля
// $label - Заголовок
```

### Number

```php
AdminFormElement::number(string $key, string $label = null)
// $key - Ключ поля
// $label - Заголовок
```

### Password

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


### Hidden
```php
AdminFormElement::hidden(string $key)
// $key - Ключ поля
```

### Date
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

### Datetime
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

### Timestamp
```php
AdminFormElement::timestamp()
```

### Time
```php
AdminFormElement::time()
```

#### Доступные методы
```php
$field->setFormat(string $fieldat); // Указание формата хранения даты в БД
$field->setPickerFormat(string $fieldat); // Указание формата отображения даты в поле (По умолчанию значение из конфига `timeFormat`)
$field->setCurrentDate(); // Установка текущей даты, если значение не указано
```


### Upload

```php
AdminFormElement::upload(string $key, string $label = null)
// $key - Ключ поля
// $label - Заголовок
```


### File
Загрузка файлов происходит чере ajax и возвращает строку (относительный путь до файла).
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


### Image
Загрузка файлов происходит чере ajax и возвращает строку (относительный путь до файла).
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
// В качестве ключей массиа используются названия функций http://image.intervention.io/
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
// В качестве ключей массиа используются названия функций http://image.intervention.io/
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

### Images
Загрузка файлов происходит чере ajax и возвращает строку (относительный путь до файла).
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


### Textarea

```php
AdminFormElement::textarea(string $key, string $label = null)
// $key - Ключ поля
// $label - Заголовок
```

#### Доступные методы
```php
$field->setRows(int $rows); // Указание кол-ва строк
```

### Select
```php
AdminFormElement::select(string $key, string $label = null)
// $key - Ключ поля
// $label - Заголовок
```

#### Доступные методы
```php
$field->setModelForOptions(string|\Illuminate\Database\Eloquent\Model $model, string $titleKey = null) // Указание модели в качестве элементов списка
$field->setDisplay(string $titleKey) // Укзание поля модели, используемого в качестве заголовка
$field->setFetchColumns(...$columns) // При использовании модели указание списка загружаемых полей
$field->setLoadOptionsQueryPreparer(Closure $callback) // При использовании модели перед загрузкой списка возможность изменения запроса
// Пример
$field->setLoadOptionsQueryPreparer(function($item, $query) {
	return $query->where('column', 'value')->were('owner_id', Auth::user()->id)
})

$field->setOptions(array $options) // Указание элементов списка

$field->setEnum(array $options) // Указание элементов списка (без ключей)

$field->nullable() // Возможность оставлять поле пустым
$field->exclude(array $keys) // Исключение из спсика элементов
```

### MultiSelect
```php
AdminFormElement::multiSelect(string $key, string $label = null)
// $key - Ключ поля
// $label - Заголовок
```

#### Доступные методы
Доступны все методы поля `select`

```php
$field->taggable() // Возможность указывать собственные варианты
$field->isDeleteRelatedItem() // Если значение было ранее выбрано и сейчас убирается из спсика, удалить его. (необходимо протестировать)
```

### Wysiwyg
```php
AdminFormElement::wysiwyg(string $key, string $label = null, string $editor = null)
// $key - Ключ поля
// $label - Заголовок
// $editor - ключ редактора
```

#### Доступные методы

```php
$field->setFilteredValueToField(string $field) // Указание поля, где будет храниться преобразованный текст в HTML (Используется для режакторов типа markdown)
$field->disableFilter() // Отключить фильтр (При использовании markdown редактора, перед сохранением значения, он его компилирует в HTML)

$field->setEditor(string $editor) // указание редактора текста (Доступны редакторы ckeditor, tinymce, simplemde)
$field->setHeight(int $height) // указание высоты редактора
$field->setParameters(array $parameters) // передача дополнительных настроек в редактор (Будут преобразованы в json)
```

### Ckeditor
Алиас для поля `wysiwyg` с подключеним редактора `ckeditor`

```php
AdminFormElement::ckeditor(string $key, string $label = null)
// $key - Ключ поля
// $label - Заголовок
```

### Checkbox
```php
AdminFormElement::checkbox(string $key, string $label = null)
// $key - Ключ поля
// $label - Заголовок
```

### Radio
Доступны все методы из поля `select`

```php
AdminFormElement::radio(string $key, string $label = null)
// $key - Ключ поля
// $label - Заголовок
```

### Html
Поле для вывода обычного HTML кода

```php
AdminFormElement::html(string $html)
```

### Custom
Поле для вывода д

```php
AdminFormElement::custom(Closure $callback = null)
// $callback - функция, которая будет вызвана при сохранении поля
```

#### Доступные методы

```php
$field->setCallback(Closure $callback) // Функция, которая будет вызвана при сохранении поля
$field->setDisplay(Closure|string $display) // Контент, который будет выводен для поля
// Пример
$field->setDisplay(function(Model $model) {
   return (string);
})
```


### View
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


### TODO - добавить информацию по методам, доступным во всех полях и про мутаторы
