# Формы

# Upload
Поле `AdminFormElement::upload('image', 'Image')` используется для загрузки файлов на сервер посредством `<input type="upload" />`.
При добавлении поля, форма автоматически получает html атрибут `enctype="multipart/form-data"`

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
