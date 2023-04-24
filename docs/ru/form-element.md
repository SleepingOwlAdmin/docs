# Элементы формы (Поля)

- [Text](#text)
- [Number](#number)
- [Password](#password)
- [Hidden](#hidden)
- [Date](#date)
- [Datetime](#datetime)
- [Time](#time)
- [File](#file)
- [Image](#image)
- [Images](#images)
- [Textarea](#textarea)
- [Select](#select)
- [DependentSelect](#dependentselect)
- [Multi Select](#multiselect)
- [Select Ajax](#select-ajax)
- [Multi Select Ajax](#multiselect-ajax)
- [Wysiwyg](#wysiwyg)
- [Ckeditor](#ckeditor)
- [Checkbox](#checkbox)
- [Radio](#radio)
- [Belong To](#belong-to)
- [Has Many](#has-many)
- [Many To Many](#many-to-many)
- [Html](#html)
- [Custom](#custom)
- [View](#view)
- [Upload](#upload)
- [API](#api)

В качестве элемента формы может выступать любой класс, которые реализует интерфейс `Illuminate\Contracts\Support\Renderable`.
Для полноценной работы класс поля должен реализовать интерфейс `SleepingOwl\Admin\Contracts\FormElementInterface`

<a name="text"></a>

## Text

Обычное текстовое поле `<input type="text" />`

```php
AdminFormElement::text(string $key, string $label = null): static
```

- `$key` - Ключ поля
- `$label` - Заголовок

<a name="number"></a>

## Number

Числовое поле `<input type="number" min max step />`

```php
AdminFormElement::number(string $key, string $label = null): static
```

- `$key` - Ключ поля
- `$label` - Заголовок

### Доступные методы

<a name="number-set-min"></a>

#### `setMin(int $min): static`

Указание минимального допустимого значения

```php
$field->setMin(10);
```

<a name="number-set-max"></a>

#### `setMax(int $max): static`

Указание максимального допустимого значения

```php
$field->setMax(100);
```

<a name="number-set-step"></a>

#### `setStep(int $step): static`

Указание шага

```php
$field->setStep(5);
```

<a name="password"></a>

## Password

Поле для ввода пароля `<input type="password" />`

```php
AdminFormElement::password(string $key, string $label = null): static
```

- `$key` - Ключ поля
- `$label` - Заголовок

### Доступные методы

<a name="password-allowEmptyValue"></a>

#### `allowEmptyValue(): static`

Если пароль указан для текущего поля, то при валидации будет игнорироваться правило `required`

<a name="password-hashWithBcrypt"></a>

#### `hashWithBcrypt(): static`

Перед сохранением применить к паролю функцию bcrypt

<a name="password-hashWithMD5"></a>

#### `hashWithMD5(): static`

Перед сохранением применить к паролю функцию md5

<a name="password-hashWithSHA1"></a>

#### `hashWithSHA1(): static`

Перед сохранением применить к паролю функцию sha1

<a name="hidden"></a>

## Hidden

```php
AdminFormElement::hidden(string $key): static
```

- `$key` - Ключ поля

<a name="date"></a>

## Date

Поле для ввода даты (использует javascript календарь http://eonasdan.github.io/bootstrap-datetimepicker/)

```php
AdminFormElement::date(string $key, string $label = null): static
```

- `$key` - Ключ поля
- `$label` - Заголовок

### Доступные методы

<a name="date-setFormat"></a>

#### `setFormat(string $format): static`

Указание формата хранения даты в БД (По умолчанию: `Y-m-d`)

<a name="date-setPickerFormat"></a>

#### `setPickerFormat(string $format): static`

Указание формата отображения даты в поле (По умолчанию значение из конфига `config('sleeping_owl.dateFormat')`)

<a name="date-setCurrentDate"></a>

#### `setCurrentDate(): static`

Установка текущей даты, если значение не указано

<a name="datetime"></a>

## Datetime

Поле для ввода даты и времени (использует javascript календарь http://eonasdan.github.io/bootstrap-datetimepicker/)

```php
AdminFormElement::datetime(string $key, string $label = null): static
```

- `$key` - Ключ поля
- `$label` - Заголовок

### Доступные методы

<a name="datetime-setFormat"></a>

#### `setFormat(string $format): static`

Указание формата хранения даты в БД (По умолчанию: `Y-m-d H:i:s`)

<a name="datetime-setPickerFormat"></a>

#### `setPickerFormat(string $format): static`

Указание формата отображения даты в поле (По умолчанию значение из конфига `config('sleeping_owl.datetimeFormat')`)

<a name="datetime-setCurrentDate"></a>

#### `setCurrentDate(): static`

Установка текущей даты, если значение не указано

<a name="datetime-setSeconds"></a>

#### `setSeconds(): static`

Показывать секунды в поле

<a name="time"></a>

## Time

Поле для ввода времени (использует javascript календарь http://eonasdan.github.io/bootstrap-datetimepicker/)

```php
AdminFormElement::time(string $key, string $label = null): static
```

- `$key` - Ключ поля
- `$label` - Заголовок

### Доступные методы

<a name="datetime-setFormat"></a>

#### `setFormat(string $format): static`

Указание формата хранения даты в БД (По умолчанию: `H:i:s`)

<a name="datetime-setPickerFormat"></a>

#### `setPickerFormat(string $format): static`

Указание формата отображения даты в поле (По умолчанию значение из конфига `config('sleeping_owl.timeFormat')`)

<a name="file"></a>

## File

Поле для загрузки файла. Загрузка файлов происходит через ajax и возвращает строку (относительный путь до файла).

```php
AdminFormElement::file(string $key, string $label = null): static
```

- `$key` - Ключ поля
- `$label` - Заголовок

### Доступные методы

<a name="file-setUploadPath"></a>

#### `setUploadPath(Closure $uploadPath): static`

Указание пути сохранения файла
** Путь должен начинаться относительно папки public и не должен содержать название файла!**

В анонимную функцию будет передан объект загружаемого файла `\Illuminate\Http\UploadedFile $file`

```php
$field->setUploadPath(function(\Illuminate\Http\UploadedFile $file) {
    return 'files'; // public/files
});
```

<a name="file-setSaveCallback"></a>

#### `setSaveCallback(Closure $callable): static`

Имплемент своей логики сохранения и обработки файла
В анонимную функцию будет переданы все параметры обычного сохранения файла
[
`\Illuminate\Http\UploadedFile $file` - объект загружаемого файла,
`$path` -директория куда якобы должен быть сохранен файл,
`$filename` - имя файла якобы сгенерированное самим элементом,
`$settings` - опции заданные методом setUploadOptions
]

Все методы сохранения файлов сейчас должны возвращать json объект для двух данных json_encode(['value' => 'тут полная ссылка или относительный path на картинку', 'url' => 'тут только полная ссылка на файл'])

**Пример использования**

```php
AdminFormElement::images('some_images', "Some Label")->setSaveCallback(function ($file, $path, $filename, $settings) use ($id) {
		//Здесь ваша логика на сохранение картинки
        $result = $youimage;

        return ['path' => $result['url'], 'value' => $result['path|url']];
       }),
```

Способ передачи модели не был найден - потому можно в примере найти use (\$id) и использовать в колбеке нахождение модели через ID. Полезно когда нужно сохранить картинку после обработки в отношение с другой моделью. В этом моменте мы и открываем пользователям грань тонкого мышления и обработки фотографий таким образом, какой нужен именно вам. Колбек используется поверх всех сохранений, а значит вызвав его, вы прервете все сохранения на стороне админки. Позже это доработается до принятия некого интерфейса подачи на вход контроллера, класса и возможно целой экосистемы. Всем удачи

<a name="file-setUploadFileName"></a>

#### `setUploadFileName(Closure $fileName): static`

Указание имени файла
В анонимную функцию будет передан объект загружаемого файла `\Illuminate\Http\UploadedFile $file`

```php
$field->setUploadFileName(function(\Illuminate\Http\UploadedFile $file) {
    return $file->getClientOriginalName().'doctrine-meta'.$file->getClientOriginalExtension();
});
```

<a name="file-maxSize"></a>

#### `maxSize(int $size): static`

Указание максимального размера загружаемого изображения (в байтах)

<a name="file-minSize"></a>

#### `minSize(int $size): static`

Указание минимального размера загружаемого изображения (в байтах)

<a name="image"></a>

## Image

Загрузка файлов происходит через ajax и возвращает строку (относительный путь до файла).
При загрузке изображений, файлы проходят валидацию `image`

```php
AdminFormElement::image(string $key, string $label = null): static
```

- `$key` - Ключ поля
- `$label` - Заголовок

### Доступные методы

Для данного поля доступны все методы поля [File](#file)

<a name="image-setUploadSettings"></a>

#### `setUploadSettings(array settings)`

Указание настроек для обработки загружаемого изображения.

<a name="image-manipulation"></a>

##### Обработка изображений

Для возможности обработки изображений при сохранении вам необходимо подключить пакет [intervention/image](http://image.intervention.io/getting_started/installation) и добавить сервис провайдер.
Установить пакет можно помощью командной строки

```bash
$ composer require intervention/image
```

После установки пакета необходимо добавить сервис провайдер
`Intervention\Image\ImageServiceProviderLaravel5::class`,
в соответствующий раздел `providers` файла `config/app.php`:

После подключения пакета можно использовать фильтры пакета через метод `setUploadSettings`.

**Пример**

```php
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
```

Ключем массива выступает название фильтра, например [`resize`](http://image.intervention.io/api/resize), в качестве значения массива передается массив аргументов, которые будут переданы в эту функцию. Т.е. после передачи настроек итератор пройдется по всем элементам массива и сделает вызов `call_user_func_array($key, $value)`

**Наглядный пример**

```php
$image = \Intervention\Image\Facades\Image::make($file)

call_user_func_array([$image, 'resize'], [1280, null, function ($constraint) {
   $constraint->upsize();
   $constraint->aspectRatio();
}])
```

<a name="images"></a>

## Images

Загрузка файлов происходит через ajax и возвращает строку (относительный путь до файла).
При загрузке изображений, файлы проходят валидацию `image`

**При сохранении поля в модель передается массив изображений.**

```php
AdminFormElement::images(string $key, string $label = null): static
```

- `$key` - Ключ поля
- `$label` - Заголовок

### Доступные методы

Для данного поля доступны все методы поля [Image](#image)

<a name="images-storeAsJson"></a>

#### `storeAsJson(): static`

При сохранении преобразовать массив в json строку

#### `draggable(boolean)` (по умолчанию `true`)

Принудительное отключение сортировки изображений

<a name="images-storeAsComaSeparatedValue"></a>

#### `storeAsComaSeparatedValue(): static`

При сохранении преобразовать массив в строку с разделителем ","

#### `setAfterSaveCallback()`

Этот метод полезен когда нужно сколлектировать логику сохранения изображений и привязываний их в модель
**Пример**

```
    ->setAfterSaveCallback(function ($value, $model) {
        if ($value) {
            //... сюда приходит value с поля и модель после сохранения
            //... Имейте ввиду что этот колбек вызовется только после всех валидаций и сохранения модели
        }
    })
```

<a name="textarea"></a>

## Textarea

Поле для ввода текста `<textarea></textarea>`

```php
AdminFormElement::textarea(string $key, string $label = null): static
```

- `$key` - Ключ поля
- `$label` - Заголовок

### Доступные методы

<a name="textarea-setRows"></a>

#### `setRows(int $rows): static`

Указание кол-ва видимых строк

<a name="select"></a>

## Select

Поле для выбора значения из выпадающего списка (использует javascript пакет https://select2.github.io/)

```php
AdminFormElement::select(string $key, string $label = null, array|Model|string $options = []): static
```

- `$key` - Ключ поля
- `$label` - Заголовок
- `$options` - Данные
  - При передаче массива, он будет использован в качестве значений
  - При передаче объекта модели, будут использованы ее значения

### Доступные методы

<a name="select-setModelForOptions"></a>

#### `setModelForOptions(string|\Illuminate\Database\Eloquent\Model $model, string $titleKey = null): static`

Указание модели в качестве элементов списка

- `$titleKey` - Смотри метод [`setDisplay`](#select-setDisplay)

<a name="select-setDisplay"></a>

#### `setDisplay(string $titleKey): static`

Указание поля модели, используемого в качестве заголовка

<a name="select-setFetchColumns"></a>

#### `setFetchColumns(...$columns): static`

При использовании модели указание списка загружаемых полей в `select`

```php
$field->setFetchColumns('title');
$field->setFetchColumns(['title']);
$field->setFetchColumns(['title', 'position']);
```

<a name="select-setLoadOptionsQueryPreparer"></a>

#### `setLoadOptionsQueryPreparer(Closure $callback): static`

При использовании модели перед загрузкой списка возможность изменения запроса

В анонимную функцию будут переданы

- `$element` - текущий объект Select
- `$query` - текущий запрос на получение спсика

```php
$field->setLoadOptionsQueryPreparer(function($element, $query) {
	return $query
	    ->where('column', 'value')
	    ->where('owner_id', $element->getModel()->author_id)
})
```

<a name="select-setOptions"></a>

#### `setOptions(array $options): static`

Указание элементов списка

<a name="select-setEnum"></a>

#### `setEnum(array $options): static`

Указание элементов списка не содержащего ключей (в качестве ключей будут использованы значения массива)

<a name="select-setSortable"></a>

#### `setSortable(bool $sortable)`

Установка атрибута для сортировки элементов списка по алфавиту (по умолчанию сортировка включена)

<a name="select-nullable"></a>

#### `nullable(): static`

Возможность оставлять поле пустым

<a name="select-exclude"></a>

#### `exclude(array $keys): static`

Исключение из списка элементов

<a name="select-ajax"></a>

#### `setUsageKey($key)`

Изменение ключа сохранения

```php
AdminFormElement::select('role_id', 'Роль', Role::class)
  ->setUsageKey('new_id'),
```

<a name="select-usage-key"></a>

## Select Ajax
**Отдельная благодарность https://github.com/hkd213**

Поле для выбора значения из выпадающего списка с помощью технологии ajax (использует javascript пакет https://select2.github.io/). Рекомендуется использовать в том случае, если кол-во элементов списка слишком велико для обычного select, и сильно увеличивает время загрузки страницы.

```php
AdminFormElement::selectajax(string $key, string $label = null): static
```

- `$key` - Ключ поля
- `$label` - Заголовок

### Доступные методы

<a name="select-ajax-setModelForOptions"></a>

#### `setModelForOptions(string|\Illuminate\Database\Eloquent\Model $model, string $titleKey = null): static`

Указание модели в качестве элементов списка

- `$titleKey` - Смотри метод [`setDisplay`](#select-setDisplay)

<a name="select-ajax-setSearch"></a>

#### `setSearch(string|array $search): static`

Указание поля/полей таблицы базы данных, по которым будет происходить поиск подходящих значений.

В случае, если в качестве аргумента передана строка, поиск будет производиться по одноименному полю в таблице БД:

```php
    ->setSearch('title')
```
Результат:
```php
    SELECT * FROM `table` WHERE (`title` LIKE '%query%')
```

Если передать массив значений, то поиск будет производиться по каждому из этих полей, с условием ИЛИ:

```php
    ->setSearch(['name', 'surname'])
```
Результат:
```php
    SELECT * FROM `table` WHERE (
        `name` LIKE '%query%'
        OR `surname` LIKE '%query%'
    )
```

Также есть возможность указать правила поиска для каждого из передаваемых полей. Всего есть 4 вида правил (обращайте внимание на расположения знака процента в SQL LIKE запросе ):
 - `equal` -  четкое соответствие: `WHERE a LIKE 'query'` (идентично `WHERE a = 'query'`)
 - `begins_with` - значение поля начинается как введенный запрос: `WHERE a LIKE 'query%'`
 - `ends_with` - значение поля заканчивается как введенный запрос: `WHERE a LIKE '%query'`
 - `contains` - значение поля содержит введенный запрос: `WHERE a LIKE '%query%'`. Данное правило используется по-умолчанию

Примеры работы с правилами поиска:

```php
    ->setSearch([
        'id' => 'equal',
        'name' => 'contains',
        'first_name' => 'begins_with',
        'last_name' => 'ends_with',
    ])
```
Результат:
```php
    SELECT * FROM `table` WHERE (
        `id` LIKE 'query'
        OR `name` LIKE '%query%'
        OR `first_name` LIKE 'query%'
        OR `last_name` LIKE '%query'
    )
```

Доступно использование значений из связанных полей через функцию замыкание (dependent-функционал, см. ниже):

```php
    ->setSearch(function($element) {
        if ($element->getDependValue('user.role') == 'admin') {
            // Если в связанном поле выбрано значение 'admin',
            // то выполняем расширенный поиск: по name или жестко по id:
            return [
                'id' => 'equal',
                'name'
            ];
        } else {
            // Иначе - будем искать только по полю name:
            return 'name';
        }
    })
```


<a name="select-ajax-setDisplay"></a>

#### `setDisplay(string|\Closure $display): static | required`

Данный метод позволяет задать содержимое и внешний вид каждого элемента выпадающего списка.

В качестве значения можно передать строку - в этом случае в качестве содержимого каждого элемента списка будет браться значение одноименного столбца каждой записи из БД. В случае передачи строки использовать метод setSearch() не обязательно - поле одновременно будет играть роль поля источника для запроса: `->setDisplay('name')` будет искать в указанной модели по этому полю.

Также в качестве значения можно передать функцию-замыкание. В этом случае обязательно нужно указать поле таблицы БД, по которому будет производиться поиск (через `->setSearch()`:

```php
AdminFormElement::selectajax('user_id', 'Пользователь')
    ->setModelForOptions(\App\User::class)
    ->setSearch('name')
    ->setDisplay(function ($model) {
        return $model->name . ' (id=' . $model->id . ')';
    })
```

Данный код будет осуществлять поиск в таблице БД по полю `name` (`->where('name', 'LIKE', "%{$request->q}%")`). При этом при формировании списка элементов (option) для выпадающего списка (select) будет использоваться переданная функция-замыкание, в которую будет передаваться Eloquent-модель каждой подходящей записи из БД. В данном случае к имени пользователя будет добавляться его id: `Иван Петров (id=77)`

<a name="select-ajax-setLoadOptionsQueryPreparer"></a>

#### `setLoadOptionsQueryPreparer(\Closure $callback): static`

Данный метод позволяет использовать функцию-замыкание, через которую при необходимости можно дополнительно модифицировать запрос к БД, например - указать сортировку:

```php
AdminFormElement::selectajax('user_id', 'Пользователь')
    ->setModelForOptions(\App\User::class)
    ->setSearch('name')
    ->setDisplay(function ($model) {
        return $model->name . ' (id=' . $model->id . ')';
    })
    ->setLoadOptionsQueryPreparer(function ($element, $query) {
        return $query->orderBy('id', 'DESC');
    })
```

Доступно использование значений из связанных полей через функцию замыкание (dependent-функционал, см. ниже):

```php
    ->setLoadOptionsQueryPreparer(function($element, $query) {
        if ($element->getDependValue('user.role') == 'admin') {
            $query = $query->orderBy('id', 'DESC');
        } else {
            $query = $query->orderBy('name', 'ASC');
        }
        return $query;
    })
```

<a name="select-ajax-setSearchUrl"></a>

#### `setSearchUrl(string $url): static`

Указание своего собственного источника поиска данных
При этом использованный setDisplay будет играть роль ключа в источнике

```php
AdminFormElement::selectajax('name')
    ->setSearchUrl(
        route('name.route')
    )
```

- Если указан кастомный источник то поиск по модели производится не будет
- Если указана модель то поиск будет производиться внутри SleepingOwl

<a name="select-ajax-exclude"></a>

#### `exclude(array $keys): static`

Исключение записей из списка элементов по id. В качестве аргумента передается массив идентификаторов, которые будут исключены при поиске подходящих значений:

```php
AdminFormElement::selectajax('user_id', 'Пользователь')
    ->setModelForOptions(\App\User::class)
    ->setDisplay('name')
    ->exclude([1, 2, 3])
```

Однако иногда кол-во записей, которые нужно исключить из выборки, может быть достаточно большим. В этом случае рекомендуется не передавать конкретные значения (если это позволяет сделать логика приложения), а модифицировать запрос к БД, используя `join` совместно с методом `setLoadOptionsQueryPreparer`:

```php
AdminFormElement::selectajax('user_id', 'Пользователь')
    ->setModelForOptions(\App\User::class)
    ->setDisplay('name')
    ->setLoadOptionsQueryPreparer(function ($element, $query) {
        return $query
            ->leftJoin('banned_users', 'banned_users.user_id', '=', 'users.id')
            ->where('banned_users.user_id', null)
            ->selectRaw('users.*, banned_users.user_id')
        ;
    })
```

<a name="select-ajax-setMinSymbols"></a>

#### `setMinSymbols(integer $min): static`

Указания минимального кол-ва введенных символов, после которого будет совершаться ajax-запрос с поиском. Значение по-умолчанию: 3.

<a name="select-ajax-dependent"></a>

### Dependent-функционал

При использовании элемента selectAjax доступны расширенные возможности элемента dependentSelect.

<a name="select-ajax-setDataDepends"></a>

#### `setDataDepends(array $depends): static`

Указание ключей полей, при изменении значения в которых производить обновление текущего поля.

<a name="select-ajax-setModelForOptionsCallback"></a>

#### `setModelForOptionsCallback(Closure $callback): static`

Указание функции-замыкания для определения модели, которая будет использована в качестве элементов списка. Схожа принципом работы с методом `setModelForOptions`.

В функции-замыкания, установленные через методы `setModelForOptionsCallback`, `setSearch`, `setLoadOptionsQueryPreparer`, передается объект `$element` с доступным методом `getDependValue()`, который позволяет получить значение из связанного поля:


```php
    ->setModelForOptionsCallback(function ($element) {
        // В зависимости от выбранного значения в связанном поле будем
        // использовать разные модели данных для поиска и отображения:
        $role = $element->getDependValue('user.role');
        $array = [
            'admin' => \App\Admin::class,
            'user' => \App\User::class
        ];
        if (
            $role
            && isset($array[$role])
            && null !== ($class_name = $array[$role])
            && class_exists($class_name)
        ) {
            return new $class_name;
        }
        return null;
    })
```

Комплексный пример работы с dependent-функционалом поля selectAjax - управление записями [с полиморфной связью](https://laravel.com/docs/5.8/eloquent-relationships#polymorphic-relationships):

```php
    AdminFormElement::select('entity_type', 'Сущность')
        ->setOptions([
            'admin' => 'Администраторы',
            'user' => 'Пользователи'
        ])
        ->setSortable(false)
        ->setDefaultValue('admin')
        ->required()
    ,
    AdminFormElement::selectajax('entity_id', 'ID сущности')
        ->setMinSymbols(2)
        ->setDataDepends(['entity_type'])
        ->setModelForOptionsCallback(function ($element) {
            $entity_type = $element->getDependValue('entity_type');
            $entity_classes = [
                'admin' => \App\Admin::class,
                'user' => \App\User::class,
            ];
            if (
                $entity_type
                && isset($entity_classes[$entity_type])
                && null !== ($class_name = $entity_classes[$entity_type])
                && class_exists($class_name)
            ) {
                return new $class_name;
            }
            return null;
        })
        ->setSearch(function ($element) {
            return [
                'id' => 'equal',
                'name',
            ];
        })
        ->setDisplay(function ($model, $element = null) {
            return $model->name . ' ' . $model->surname . ' (id=' . $model->id . ')';
        })
        ->setLoadOptionsQueryPreparer(function($element, $query) {
            if ($element->getDependValue('entity_type') == 'admin') {
                $query = $query->where('admin_status', 1);
            }
            $query = $query->orderBy('name', 'ASC');
            return $query;
        })
        ->required()
    ,
```


<a name="multiselect-ajax"></a>

## MultiSelect Ajax
**Отдельная благодарность https://github.com/hkd213**

Поле для выбора множества значений из выпадающего списка с помощью технологии ajax (использует javascript пакет https://select2.github.io/)

```php
AdminFormElement::multiselectajax(string $key, string $label = null): static
```

- `$key` - Ключ поля
- `$label` - Заголовок

### Доступные методы

Для данного поля доступны все методы поля [selectajax](#selectajax)

#### Предложения и пожелания будут рассматриваться в чате Gitter обращаться по нику @aios
##### Также можно обратиться к @sngrl в чате Telegram

<a name="dependentselect"></a>

## DependentSelect

Поле для ввода зависимых значений (использует javascript пакет http://plugins.krajee.com/dependent-dropdown)

```php
AdminFormElement::dependentselect(string $key, string $label = null, array $depends = []): static
```

- `$key` - Ключ поля
- `$label` - Заголовок
- `$depends` - (Смотри метод [setDataDepends](#dependentselect-setDataDepends))

### Доступные методы

<a name="dependentselect-setDataDepends"></a>

#### `setDataDepends(string|array $field): static`

Указание ключей полей, при изменении значения в которых производить обновление текущего поля

<a name="dependentselect-setModelForOptions"></a>

#### `setModelForOptions(string|\Illuminate\Database\Eloquent\Model $model): static`

Указание модели, которая будет использована в качестве элементов списка.

<a name="dependentselect-setDisplay"></a>

#### `setDisplay(string $titleKey): static`

Указание поля модели, используемого в качестве заголовка

<a name="dependentselect-setLoadOptionsQueryPreparer"></a>

#### `setLoadOptionsQueryPreparer(Closure $callback): static`

Правила фильтрации списка

```php
$field->setLoadOptionsQueryPreparer(function($element, $query) {
    // метод getDependValue используется для получения значения связанного поля
    // При загрузке формы метод вернет $model->getAttribute($key)
    // При выполнении ajax запроса $request->input('depdrop_all_params.{$key}')

    return $query->where('country_id', $element->getDependValue('country_id'));
})
```

<a name="dependentselect-use-case"></a>

### Пример использования

```php
AdminFormElement::select('country_id', 'Country')
	->setModelForOptions(Country::class, 'title'),

AdminFormElement::dependentselect('city_id', 'City')
	->setModelForOptions(\App\Model\City::class, 'title')
	->setDataDepends(['country_id'])
	->setLoadOptionsQueryPreparer(function($item, $query) {
		return $query->where('country_id', $item->getDependValue('country_id'));
	})
```

<a name="multiselect"></a>

## MultiSelect

```php
AdminFormElement::multiselect(string $key, string $label = null, array|Model|string $options = []): static
```

- `$key` - Ключ поля
- `$label` - Заголовок
- `$options` - Данные
  - При передаче массива, он будет использован в качестве значений
  - При передаче объекта модели, будут использованы ее значения

### Доступные методы

Доступны все методы поля [Select](#select)

<a name="multiselect-taggable"></a>

#### `taggable(): static`

Возможность указывать собственные варианты значений

<a name="multiselect-isDeleteRelatedItem"></a>

#### `isDeleteRelatedItem(): static`

Если значение было ранее выбрано и сейчас убирается из списка, удалить его из БД. (необходимо протестировать)

<a name="wysiwyg"></a>

## Wysiwyg

Добавление поля с визуальным текстовым редактором

```php
AdminFormElement::wysiwyg(string $key, string $label = null, string $editor = null): static
```

- `$key` - Ключ поля
- `$label` - Заголовок
- `$editor` - Смотри метод [setEditor](#wysiwyg-setEditor)

### Доступные методы

<a name="wysiwyg-setFilteredValueToField"></a>

#### `setFilteredValueToField(string $field): static`

Указание поля, где будет храниться преобразованный текст в HTML (Используется для редакторов типа markdown)

<a name="wysiwyg-disableFilter"></a>

#### `disableFilter(): static`

Отключить фильтр (При использовании markdown редактора, перед сохранением значения, он его компилирует в HTML)

<a name="wysiwyg-setEditor"></a>

#### `setEditor(string $editor): static`

указание редактора текста (Доступны редакторы `ckeditor`, `tinymce`, `simplemde`)

<a name="wysiwyg-setHeight"></a>

#### `setHeight(int $height): static`

Указание высоты поля ввода в px

<a name="wysiwyg-setParameters"></a>

#### `setParameters(array $parameters): static`

Передача дополнительных настроек в редактор (Будут преобразованы в json)

<a name="ckeditor"></a>

## Ckeditor

Алиас для поля [`Wysiwyg`](#wysiwyg) с подключением редактора `ckeditor`

```php
AdminFormElement::ckeditor(string $key, string $label = null): static
```

- `$key` - Ключ поля
- `$label` - Заголовок

<a name="checkbox"></a>

## Checkbox

```php
AdminFormElement::checkbox(string $key, string $label = null): static
```

- `$key` - Ключ поля
- `$label` - Заголовок

<a name="radio"></a>

## Radio

Доступны все методы из поля [Select](#select)

```php
AdminFormElement::radio(string $key, string $label = null, array|Model|string $options = []): static
```

- `$key` - Ключ поля
- `$label` - Заголовок

<a name="belong-to"></a>

## Belong To

belongTo создаёт форму в которой можно динамически добавлять/удалять связанные отношения. Удобно использовать, если из одной формы мы можем создавать модель связной модели один к одному.

```php
AdminFormElement::belongsTo(string $relationName, array $elements): static
```

- `$relationName` - Название метода в котором реализуется связь belongsTo
- `$elements` - Элементы формы для связанной модели

<a name="belong-to-use-case"></a>

### Пример использования

```php
AdminFormElement::belongsTo('item', [
    AdminFormElement::text('name', 'Тип')
    AdminFormElement::select('armor_id', 'Броня', Armor::class)->setDisplay('value'),
])
```

<a name="has-many"></a>

## Has Many

hasMany создаёт форму в которой можно динамически добавлять/удалять связанные отношения. Чтобы не создавать отдельную страницу для отношения, можно создать ее в форме редактирования с помощью этого элемента. Например, если у пользователя есть адреса(улица, город, дом), удобно создать таб на странице редактирования пользователя, вызвать там hasMany и добавить адреса как отдельные сущности. После сохранения все адреса создадутся отдельными записями и будут выводиться в форме редактирования пользователя.

```php
AdminFormElement::hasMany(string $relationName, array $elements): static
```

- `$relationName` - Название метода в котором реализуется связь hasMany
- `$elements` - Элементы формы для связанной модели

<a name="has-many-use-case"></a>

### Пример использования

Можно создать много сущностей по типу улица, город, дом. Это всё делается в форме одной строчкой.

```php
AdminFormElement::hasMany('addresses', [
    AdminFormElement::text('field_address', 'Название сущности адреса')
])
```

<a name="many-to-many"></a>

## Many To Many

Элемент создан для удобного редактирования pivot полей без необходимости создавать дополнительную модель. Первым параметром идет название отношения модели, вторым - массив с элементами для наполнения отношения. По умолчанию добавляется `AdminFormElement::select()`, который выводит список данных второй связанной модели и два `action` добавить/удалить. Таким образом, если у тебя есть `Model User` и `Model Role`, связанные `belongsToMany/morphToMany` `select` с ролями(`Model Role`) уже будет добавлен автоматом.

```php
AdminFormElement::manyToMany(string $relationName, array $elements): static
```

- `$relationName` - Название метода в котором реализуется связь belongsToMany или morphToMany
- `$elements` - Элементы формы для связующей таблицы(pivot)

<a name="many-to-many-setRelatedElementDisplayName"></a>

### Доступные методы

#### `setRelatedElementDisplayName(String|Closure $callback): static`

Устанавливает поле для вывода связной модели в select

<a name="many-to-many-use-case"></a>

### Пример использования

Удобно использовать этот элемент с tabs.
У нас есть промежуточная таблица user_color с pivot полями (`user_id`, `role_id` ,`name`, `color_id`, `images`, `is_done`, `date`), и feature_entity c pivot полями (`feature_id` , `entity_id` , `entity_type`, `equip`, `date`).

В нашей модели `Role` реализуем методы `users` связь `belongsToMany` и  `features` связь `morphToMany`.
В секции Roles:

```php
$manyToMany = AdminForm::form()->addElement(
    new FormElements(
        [
            AdminFormElement::manyToMany('users', [
                AdminFormElement::text('name', 'Название'),
                AdminFormElement::select('color_id', 'Цвет', Colot::class)->setDisplay('name_color'),
                AdminFormElement::images('images', 'Фото'),
                AdminFormElement::checkbox('is_done', 'Готово?'),
                AdminFormElement::datetime('date', 'Дата оплаты'),
            ])->setRelatedElementDisplayName(function ($model){
                return $model->full_name;
            })
        ])
);
```
```php
$morphToMany = AdminForm::form()->addElement(
    new FormElements(
        [
            AdminFormElement::manyToMany('features', [
                AdminFormElement::text('equip', 'Экипирован'),
                AdminFormElement::datetime('date', 'Время'),
            ])->setRelatedElementDisplayName('title')
        ])
);
```

```php
$tabs = AdminDisplay::tabbed([]);
$tabs->appendTab($manyToMany, 'Много ко многим');
$tabs->appendTab($morphToMany, 'Один ко многим через модель');
```

<a name="custom"></a>

## Custom

Поле для вывода обычного HTML кода.

```php
AdminFormElement::custom(Closure $callback = null): static
```

- `$callback` - функция, которая будет вызвана при сохранении поля

### Доступные методы

<a name="custom-setCallback"></a>

#### `setCallback(Closure $callback): static`

Функция, которая будет вызвана при сохранении поля

<a name="custom-setDisplay"></a>

#### `setDisplay(string|Closure|\Illuminate\Contracts\Support\Htmlable|\Illuminate\Contracts\View\View $display)`

HTML, который будет выведен в форме

- При передаче объекта `\Illuminate\Contracts\View\View`, в него будет передан объект модели `$model`.
- При передаче анонимной функции, в нее будет передат первым аргументов объект модели.

```php
$field->setDisplay(function(Model $model) {
   return (string);
});

$field->setDisplay(view('app.custom'));
```

<a name="html"></a>

## Html

Поле для вывода обычного HTML кода.
Данное поле алиас поля [Custom](#custom), с передачей через конструктор html в поле `setDisplay`

```php
AdminFormElement::html(
    string|Closure|\Illuminate\Contracts\Support\Htmlable|\Illuminate\Contracts\View\View $html,
    Closure $callback = null
): static
```

- `$html` - HTML, который будет выведен в форме
- `$callback` - Функция, которая будет вызвана в момент сохранения формы

<a name="view"></a>

## View

Поле для вывода view шаблона в качестве элемента формы

**Во view шаблон будет передан объект модели `$model`**

```php
AdminFormElement::view(string $view, array $data = [], Closure $callback = null): static
```

- `$view` - путь до шаблона
- `$data` - массив который будет передан в шаблон (также туда будет передана модель)
- `$callback` - функция, которая будет вызвана при сохранении поля

### Доступные методы

Доступны все методы поля [Custom](#custom)

<a name="view-setView"></a>

#### `setView(string $path): static`

Путь до шаблона

<a name="view-setView"></a>

#### `setData(array $data): static`

Массив который будет передан в шаблон

<a name="upload"></a>

## Upload

Поле используется для загрузки файлов на сервер посредством `<input type="upload" />`.

При добавлении поля, форма должна автоматически получить html атрибут `enctype="multipart/form-data"`.

Если этого не произошло, вы можете добавить атрибут вручную:

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

Также для загруженного файла доступны ссылка на файл и абсолютный путь. Например рассмотрим поле с ключем `image`:

- `$user->image` `public\storage\users\image\23n4b23hj4b.jpg`
- `$user->image_path` `\var\www\site.com\public\storage\users\image\23n4b23hj4b.jpg`
- `$user->image_url` `http:\\site.com\storage\users\image\23n4b23hj4b.jpg`
-

#### Валидация

Данный тип поля поддерживает валидацию загружаемых файлов

- https://laravel.com/docs/5.4/validation#rule-image
- https://laravel.com/docs/5.4/validation#rule-mimetypes
- https://laravel.com/docs/5.4/validation#rule-mimes

```php
AdminFormElement::upload('image', 'Image')->addValidationRule('image')

// or for file

AdminFormElement::upload('pdf', 'PDF')->addValidationRule('mimes:pdf'),
```

#### Ограничение использования трейта

**!!!Трейт переопределяет методы `getAttribute`, `mutateAttribute`, `setAttribute`, в случае, если они переопределены у вас в модели, могут возникнуть проблемы в работе!!!**


---

<a name="api"></a>

## API

<a name="api-addValidationRule"></a>

### `addValidationRule(string $rule, string $message = null): static`

Добавление [правила валидации](https://laravel.com/docs/5.3/validation#available-validation-rules)

<a name="api-setValidationRules"></a>

### `setValidationRules(array $rules): static`

Добавление [правил валидации](https://laravel.com/docs/5.3/validation#available-validation-rules) в виде массива

<a name="api-required"></a>

### `required(string $message = null): static`

Поле обязательно для заполнения

<a name="api-unique"></a>

### `unique(string $message = null): static`

Поле должно быть уникальным

<a name="api-addValidationMessage"></a>

### `addValidationMessage(string $rule, string $message): static`

Изменение сообщения для правила валидации

<a name="api-setView"></a>

### `setView(\Illuminate\View\View|string $view): static`

Указания шаблона для отображения. При передаче пути до шаблона, поиск будет производиться с учетом view namespace `sleepingowl::`
При передаче объекта `\Illuminate\View\View`, в него будут переданы данные поля и произведен вывод

<a name="api-setPath"></a>

### `setPath(string $path): static`

Указание ключа поля.

<a name="api-setLabel"></a>

### `setLabel(string $label): static`

Указание заголовка поля.

<a name="api-setDefaultValue"></a>

### `setDefaultValue(mixed $defaultValue): static`

Указание значения по умолчанию

<a name="api-setHelpText"></a>

### `setHelpText(string|\Illuminate\Contracts\Support\Htmlable $helpText): static`

Указание вспомогательного текста

<a name="api-setReadonly"></a>

### `setReadonly(bool|Closure $status): static`

Установка атрибута "только для чтения".

**Если поле только для чтения, то оно будет игнорироваться при валидации и сохранении.**

**Пример**

```php
$field->setReadOnly(true);

$field->setReadOnly(function($model) {
    return $model->author_id != auth()->id();
});

$field->setReadOnly(function($model) {
    return !auth()->check();
});
```

<a name="api-setValueSkipped"></a>

### `setValueSkipped(bool|Closure $valueSkipped)`

Установка атрибута пропуска записи значения поля в модель. По умолчанию `false`.

**Если значение поля должно быть пропущено, то правила валидации будут применены,
но в модель значение не установится.**

Например, вы хотите чтобы при создании пользователя проверялись соответствия полей `password` (пароль) и `password_confirmation` (подтверждение), но вам не нужно чтобы поле `password_confirmation` записывалось в модель:

```php
AdminFormElement::text('password', 'Password')->required();
AdminFormElement::text('password_confirmation', 'Password confirmation')
    ->setValueSkipped(true)
    ->required()
    ->addValidationRule('same:password', 'Passwords must match!');
```

<a name="api-setVisibilityCondition"></a>

### `setVisibilityCondition(Closure $condition): static`

Указания условия видимости поля (https://github.com/LaravelRUS/SleepingOwlAdmin/issues/377)

**Если поле скрыто, то оно будет игнорироваться при валидации и сохранении.**

**Пример**

```php
$field->setVisibilityCondition(function($model) {
    return auth()->user()->isAdmin();
});

$field->setVisibilityCondition(function($model) {
    return $model->author_id == auth()->id();
});
```

<a name="api-mutateValue"></a>

### `mutateValue(Closure $mutator): static`

Изменение значения поля перед передачей в модель

**Пример**

```php
$field->mutateValue(function($value) {
    return bcrypt($value);
})
```

---

<a name="validation-examples"></a>

### Примеры указания правил валидации

Для каждого элемента формы `AdminFormElement` можно указывать правила валидации.

**Пример**

```php
AdminFormElement::text('title', 'Title')
    ->required()
    ->unique();
```

Если вы хотите переопределить стандартное сообщение для правила, вы можете воспользоваться одним из способов:

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
