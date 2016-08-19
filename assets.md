# Управление ресурсами (Assets Management)

В SleepingOwlAdmin реализован достаточно гибкий механизм подключения ассетов с помощью пакета 
[kodicms/laravel-assets](https://github.com/KodiCMS/laravel-assets) - позволяющий разработчику управлять статичными ресурсами в
веб-приложении, такими как каскадные таблицы стилей или javascript’ы (Данный пакет можно использовать независимо от админки)

Для работы с ассетами через элементы форм, отображения и т.д. используется trait [assets](assets_trait.md), который работает через класс `Meta`.

Пакет представлен тремя фасадами 
 - [Meta](#meta)
 - [Assets](#assets)
 - [PackageManager](#package-manager)
 - [Package](#package)


<a id="meta"></a>
## Meta
`KodiCMS\Assets\Meta`

Класс мета используется для генерации блока meta информации в шаблоне. Класс представляет собой сервис контейнер, который инициализируется вместе с инициализацией всех компонентов системы и является `singleton` и позволяет добавлять стили и скрипты в шаблон в любой момент, до вывода шаблона.

**Пример использования**
```php
 Meta::setTitle('Test title')
 ->setMetaDescription(...)
 ->addJs('admin-default', asset('js/app.js'), ['admin-scripts'])
 ->addJs('admin-scripts', route('admin.scripts'))
 ->addCss('admin-default', asset('css/app.css'));
```

```html
<!DOCTYPE html>
<html lang="en">
<head>
	{!!
		Meta::addMeta(['charset' => 'utf-8'], 'meta::charset')
			->addMeta(['content' => csrf_token(), 'name' => 'csrf-token'])
			->addMeta(['content' => 'width=device-width, initial-scale=1', 'name' => 'viewport'])
			->addMeta(['content' => 'IE=edge', 'http-equiv' => 'X-UA-Compatible'])
			->render()
	!!}
</head>
<body>
 ...
 <!-- Render footer scritps -->
	{!! Meta::renderScripts(true) !!}
</body>
</html>
```

### API

#### `loadPackage`

Подключение пакетов.

```php
static::loadPackage(string|array $packages): return $this
```

```php
// app\Providers\AppServiceProvider

PackageManager::add('jquery')
  ->js('jquery.js', 'https://code.jquery.com/jquery-3.1.0.min.js');
  
PackageManager::add('ckeditor')
  ->css('ckeditor.css', asset('css/ckeditor.css'))
  ->js('ckeditor.js', asset('js/ckeditor.js'));
  
// Template
Meta::loadPackage(['jquery', 'ckeditor'])
```

#### `addJs`

Добавление javascript файла.

```php
static::addJs(string $handle, string $src, array|string $dependency = null, bool $footer = false): return $this
```

##### Аргументы
* `$handle` **string** - Ключ ассета (При указании существующего ключа, будет заменен существующий ассет)
* `$src` **string** - Путь до фала (URL)
* `$dependency` **array|string** - Зависимости (Зависимости определяются по ключу в `$handle`. Т.е. если у вас подключен `jquery` и 
вам необходимо подключить свой скрипт только после него, то вы указываете его в качестве зависимости, это же правило распространяется 
на пакеты)
* `$footer` **bool** - будет помечен для вывода в футере

#### `addJsElixir`

Добавление javascript файла c версионностью

```php
static::addJsElixir(string $filename = 'js/app.js', string|array $dependency = null, bool $footer = false): return $this
```

#### `removeJs`

Удаление javascript файла. *Если параметр `$handle` не передан, будут удалены все javascript*

```php
static::removeJs(string $handle = null): return $this
```

#### `addCss`
Добавление css файла.

```php
static::addCss(string $handle, string $src, array|string $dependency = null, array $attributes = []): return $this
```

##### Аргументы
* `$handle` **string** - Ключ ассета (При указании существующего ключа, будет заменен существующий ассет)
* `$src` **string** - Путь до фала (URL)
* `$dependency` **array|string** - Зависимости (Зависимости определяются по ключу в `$handle`. Т.е. если у вас подключен `jquery` и 
вам необходимо подключить свой скрипт только после него, то вы указываете его в качестве зависимости, это же правило распространяется 
на пакеты)
* `$attributes` **array** - Дополнительные атрибуты (`['rel' => 'stylesheet', 'media' => 'all']`)

#### `addCssElixir`

Добавление css файла c версионностью

```php
static::addCssElixir(string $filename = 'css/all.css', string|array $dependency = null, array $attributes = []): return $this
```

#### `removeCss`

Удаление css файла. *Если параметр `$handle` не передан, будут удалены все javascript*

```php
static::removeCss(string $handle = null): return $this
```

#### `putVars`
Вывод в шаблон javascript переменной.

```php
static::putVars(string|array $key, mixed $value = null): return $this
```

```php
Meta::putVars(['key' => 'value', 'key1' => ['data]])
// or

Meta::putVars('key', ['data'])
```

```html
<script>
window.key = 'value';
</script>
```

#### `removeVars`

Удаление всех добавленных в стек данных

```php
static::removeVars(): return $this
```


#### `setTitle`
Указание заголовка `<title>...</title>`

```php
static::setTitle(string $title): return $this
```
   
```php
Meta::setTitle('SleepingOwl Admin')
```

#### `setMetaDescription`

Указание описание `<meta name="description" content="...">`

```php
static::setMetaDescription(string $description): return $this
```

#### `setMetaKeywords`

Указание ключевых слов `<meta name="keywords" content="...">`

```php
static::setMetaKeywords(array|string $keywords): return $this
```

#### `setMetaRobots`

`<meta name=“robots” content=“...”>`

```php
static::setMetaRobots(string $robots): return $this
```

#### `setMetaData`

Указание метаданных через класс реализующий интерфейс `KodiCMS\Assets\Contracts\MetaDataInterface`
  - title
  - description
  - keywords
  - robots
  
```php
static::setMetaData(\KodiCMS\Assets\Contracts\MetaDataInterface $data): return $this
```
  
#### `addSocialTags`

Добавление тегов для соц. сетей через класс, реализующий интерфейс `KodiCMS\Assets\Contracts\SocialMediaTagsInterface`

```php
static::addSocialTags(\KodiCMS\Assets\Contracts\SocialMediaTagsInterface $socialTags): return $this
```

#### `setFavicon`

Указание favicon для страницы `<link rel=".." href=".." type="image/x-icon" />`

```php
static::setFavicon(string $url, string $rel = 'shortcut icon'): return $this
```

#### `addMeta`

Добавление `meta` тега 

```php
static::addMeta(array $attributes, string $group = null): return $this
```
##### Аргументы
* `$group` **string** - Ключ элемента в группе


```php
Meta::addMeta(['name' => 'description', 'content' => 'hello world']) // <meta name="description" content="hello world">
```

#### `addTagToGroup`

Добавление HTML тега в группу. *По умолчанию все meta теги (`favicon`, `description`, `keywords`) создаваемые через класс `Meta` после генерации в html добавляются в группу с ключом `meta`*

```php
static::addTagToGroup(string $handle, string $content, array $params = [], string|array $dependency = null): return $this
```

##### Аргументы
* `$handle` **string** - Ключ элемента в группе
* `$content` **string** - HTML код `<meta name=":name" content=":description" />`
* `$params` **array** - Параметры для замены. (`[':name' => $name, ':description' => 'My super description']`)
* `$dependency` **array|string** - Зависимости (Зависимости определяются по ключу в `$handle`. Т.е. если у вас подключен `jquery` и 
вам необходимо подключить свой скрипт только после него, то вы указываете его в качестве зависимости, это же правило распространяется 
на пакеты)

```php
Meta::addTagToGroup('favicon', '<link rel=":rel" href=":url" type=":type" />', [
 ':url' => $url,
 ':rel' => $rel,
 ':type' => $type
])
```

#### `removeFromGroup`

Удаление HTML тега из группы.

```php
static::removeFromGroup(string $handle): return $this
```

#### `assets`

Получение объекта `KodiCMS\Assets\Assets`

```php
static::removeFromGroup(string $handle): return $this
```

<a id="assets"></a>
## Assets
`KodiCMS\Assets\Assets`

Класс Assets является хранилищем списка `css`, `javascript`, `vars` и `groups`. 

**Класс Meta при добавлении ассетов использует данный класс в качестве хранилища.**

## API

#### `packageManager`

Получение объекта `KodiCMS\Assets\PackageManager`

```php
static::removeFromGroup(string $handle): return $this
```

<a id="package-manager"></a>
## PackageManager
`KodiCMS\Assets\PackageManager extends Collection`

Менеджер пакетов. Пакет представляет из себя набор ассетов (javascript и css), которые объединены в одну группу, доступную по имени. 

**Пример инициализации**
```php
// app\Providers\AppServiceProvider.php

...
public function boot() 
{
  PackageManager::add('custom')
   ->css('extend', asset('css/custom.css'))
   ->js('extend', asset('js/custom.js'));
}
```

Получить список доступных пакетов можно через консольную команду

```bash
$ php artisan assets:packages
```

## API

#### `add`

Добавление нового пакета

```php
static::add(KodiCMS\Assets\Contracts\PackageInterface|string $package): return KodiCMS\Assets\Contracts\PackageInterface
```

#### `load`

Загрузка объекта пакета 

```php
static::load(string $name): return KodiCMS\Assets\Contracts\PackageInterface|null
```

<a id="package"></a>
## Package
`KodiCMS\Assets\Package extends Collection`

Пакет (контейнер) для хранения ассетов

## API

#### `with`

Добавить зависимость от других пакетов (Будут загружены автоматически при подключении пакета в шаблон)

```php
static::with(array|...$packages): return $this
```

#### `js`

Добавление javascript файла.

```php
static::js(string $handle, string $src, array|string $dependency = null, bool $footer = false): return $this
```

##### Аргументы
* `$handle` **string** - Ключ ассета (При указании существующего ключа, будет заменен существующий ассет)
* `$src` **string** - Путь до фала (URL)
* `$dependency` **array|string** - Зависимости (Зависимости определяются по ключу в `$handle`. Т.е. если у вас подключен `jquery` и 
вам необходимо подключить свой скрипт только после него, то вы указываете его в качестве зависимости, это же правило распространяется 
на пакеты)
* `$footer` **bool** - будет помечен для вывода в футере

#### `css`
Добавление css файла.

```php
static::css(string $handle, string $src, array|string $dependency = null, array $attributes = []): return $this
```

##### Аргументы
* `$handle` **string** - Ключ ассета (При указании существующего ключа, будет заменен существующий ассет)
* `$src` **string** - Путь до фала (URL)
* `$dependency` **array|string** - Зависимости (Зависимости определяются по ключу в `$handle`. Т.е. если у вас подключен `jquery` и 
вам необходимо подключить свой скрипт только после него, то вы указываете его в качестве зависимости, это же правило распространяется 
на пакеты)
* `$attributes` **array** - Дополнительные атрибуты (`['rel' => 'stylesheet', 'media' => 'all']`)
