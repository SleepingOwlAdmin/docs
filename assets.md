# Управление ресурсами (Assets Management)

В SleepingOwlAdmin реализован достаточно гибкий механизм подключения ассетов с помощью пакета 
[kodicms/laravel-assets](https://github.com/KodiCMS/laravel-assets) - позволяющий разработчику управлять статичными ресурсами в
веб-приложении, такими как каскадные таблицы стилей или javascript’ы.

Пакет представлен тремя фассадами 
 - [Meta](#meta)
 - [Assets](#assets)
 - [PackageManager](#package-manager)


<a id="meta"></a>
## Meta

Класс мета используется для генерации блока meta информации в шаблоне.

### API

#### `addJs`

Добавление javascript файла.

```php
static::addJs(string $handle, string $src, array|string $dependency = null, bool $footer = false)
```

##### Аргументы
* `$handle` **string** - Ключ ассета (При указании существующего ключа, будет заменен существующий ассет)
* `$src` **string** - Путь до фала (URL)
* `$dependency` **array|string** - Зависимости (Зависимости определяются по ключу в `$handle`. Т.е. если у вас подключен `jquery` и 
вам необходимо подключить свой скрипт только после него, то вы указываете его в качестве зависимости, это же правило распространяется 
на пакеты)
* `$footer` **bool** - будет помечен для вывода в футере

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

Добавление тегов для соц сетей через класс реализующий интерфейс `KodiCMS\Assets\Contracts\SocialMediaTagsInterface`

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

Добавление HTML тега в группу. *По умолчанию все meta теги (`favicon`, `description`, `keywords`) создаваемые через класс `Meta` после генерации в html добавляются в группу с ключем `meta`*

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

<a id="assets"></a>
## Assets

<a id="package-manager"></a>
## PackageManager
