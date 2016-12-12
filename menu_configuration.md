# Конфигурация меню
 - [Объект Navigation](#navigation)
 - [Добавление разделов](#add-page
 - [Добавление разделов в виде массива](#set-pages)
 - [Получение списка разделов](#get-pages)
 - [Получение кол-ва разделов с учетом вложенности](#count-pages)
 - [Права на видимость разделов](#access)
 - [Пример меню](#menu-example)
 - [Объект раздела](#page)
 	- [API](#page-api)
 - [Badges](#page-badge)
 - [Page Collection](#page-collection)


Конфигурация меню SleepingOwl Admin по умолчанию располагается в `app/Admin/navigation.php`. Если файл
возвращает массив, то этот массив будет также использоваться для построения меню.

<a name="navigation"></a>
## Объект Navigation

Navigation представлен классом `SleepingOwl\Admin\Navigation` (Реализует интерфейс `KodiComponents\Navigation\Contracts\NavigationInterface`), который инициализируется через Service Container - `sleeping_owl.navigation` и доступен с помощью:

#### Service Container
```php
$navigation = app('sleeping_owl.navigation');
```

#### Фасад
`AdminNavigation`

Данный объект содержит в себе массив всех элементов меню для административного интерфейса.

<a name="add-page"></a>
## Добавление разделов

В меню можно добавлять любые объекты реализующие интерфейс `KodiComponents\Navigation\Contracts\PageInterface`

```php
addPage(string|array|PageInterface $page): PageInterface
```

**Если в качестве аргумента передана строка или массив, то в качестве раздела будет создан объект `SleepingOwl\Admin\Navigation\Page`**

#### Аргумент `array $page`
При передаче параметров раздела в виде массива, будет произведен обход каждого ключа массива и вызван метод `set + $key` и передано в качестве аргумента значение, т.е.

```php
AdminNavigation::addPage(['title' => 'test', 'priority' => 100, 'bage' => function() {
   return 100
}]);

// выполнит следующее
$page = app()->make(KodiComponents\Navigation\Contracts\PageInterface::class);
$page->setTitle('test');
$page->setPriority(100);
$page->addBadge(function() { // Для бейджев несколько другое условие
   return 100
});

$navigation->getPages()->push($page);
```

#### Аргумент `string $page`
При передаче параметра раздела в виде строки, будет создан новый объект раздела и указан заголвок.

```php
AdminNavigation::addPage('test');

// выполнит следующее
$page = app()->make(KodiComponents\Navigation\Contracts\PageInterface::class);
$page->setTitle('test');
$navigation->getPages()->push($page);
```

#### Аргумент `PageInterface $page`
В навигацию будет добавлен новый раздел - переданный объект

```php
AdminNavigation::addPage(Page $page);
$navigation->getPages()->push($page);
```

Новый раздел в меню можно добавить несколькими способами:

#### Через сервис контейнер

```php
app('sleeping_owl.navigation')
    ->addPage()
    ->setTitle('Blog')
    ->setUrl('/blog');
```

#### Фасад
```php
// Создание элемента меню для модели
AdminNavigation::addPage('Blog')
    ->setPriority(100)
    ->setIcon('fa fa-newspaper-o');
```

#### `AdminSection` класс
```php
AdminSection::addMenuPage(\App\User::class);
```

<a name="set-pages"></a>
## Добавление разделов в виде массива

Для более удобной генерации меню можно передавать спсиок разделов в виде массива, тогда при обходе массива меню, для каждого раздела будет вызван метод `addPage`

**Пример**
```php
AdminNavigation::setFromArray([
  [
     'title' => 'Permissions',
     'icon' => 'fa fa-group',
     'pages' => [
       [
          'title' => 'Users',
          'url' => ...
       ],
       [
          'title' => 'Roles',
          'url' => ...
       ],
     ]
   ],
   (new \SleepingOwl\Admin\Navigation\Page(\App\Model\News::class))
      ->setIcon('fa fa-newspaper-o')
      ->setPriority(0)
]);
```

Данные правила действуют и для внутренних разделов

```php
$page = new \SleepingOwl\Admin\Navigation\Page(\App\Model\News::class);
$page->setIcon('fa fa-newspaper-o');
$page->setFromArray([
   ...
]);
```

<a name="get-pages"></a>
## Получение списка разделов

```php
AdminNavigation::getPages(): KodiComponents\Navigation\PageCollection

$page = AdminNavigation::getPages()->first(): KodiComponents\Navigation\Contracts\PageInterface
$page->getPages(): KodiComponents\Navigation\PageCollection
```

<a name="count-pages"></a>
## Получение кол-ва разделов с учетом вложенности

```php
AdminNavigation::countPages(): int;

AdminNavigation::getPages()->first()->countPages(); // Подсчет кол-во детей для конкретного раздела
```

<a name="access"></a>
## Права на видимость разделов

Также для разделов меню можно настраивать првила видимости.
Процесс проверки прав доступа выглядит следующим образом: каждый объект меню может иметь свое локальное правило
проверки прав

```php
AdminNavigation::addPage(\App\Blog::class)->setAccessLogic(function() {
    return auth()->user()->isSuperAdmin();
})
```

**Если правило для страницы не указано:**
 - Если пункт меню является ссылкой на раздел и рздел не дотсупен для просмотра, пункт исчезнет из меню
 - Если у страницы есть предок, то происходит проверка наличия правила, если оно указано, то будет произведена проверка
 - если предок не имеет павила, то подъем дальше по иерархии до глобального правила.

**Есть несколько сценариев настройки прав доступа:**
 - Указать глобальное правило
 
```php
AdminNavigation::setAccessLogic(function(Page $page) {
   return auth()->user()->isSuperAdmin();
});
```
 - Указать правило для конкретной страницы
 - Указать правило для раздела содержащего страницы, это правило 
 распространится на все внутренние страницы не имеющие своего правила


<a name="menu-example"></a>
## Пример меню 
Вот простой пример как может выглядеть конфигурация меню:

```
return [
    [
        'title' => 'Permissions',
        'icon' => 'fa fa-group',
        'pages' => [
            (new Page(\App\User::class))
                ->setIcon('fa fa-user')
                ->setPriority(0),
            (new Page(\App\Role::class))
                ->setIcon('fa fa-group')
                ->setPriority(100)
        ]
    ]
];
```

<a name="page"></a>
# Объект страницы

Каждый раздел меню (страница) - объект `SleepingOwl\Admin\Navigation\Page`, реализующий 
интерфейс `KodiComponents\Navigation\Contracts\PageInterface` и наследует
интерфейс `KodiComponents\Navigation\Contracts\NavigationInterface`, т.е. каждый раздел ведет себя также как и объект `Navigation`
Данный объект содержит все параметры текущей страницы, а также массив вложенных разделов.

На данный момент доступны два класса страниц

 - `KodiComponents\Navigation\Page` - для создания обычных разделов
 - `SleepingOwl\Admin\Navigation\Page` - для создания разделов привязанных к классу конфигурации модели
 
### `KodiComponents\Navigation\Page`

```php
new KodiComponents\Navigation\Page(
	string $title = null, 
	string|Illuminate\Contracts\Routing\UrlGenerator $url = null, 
	string $id = null, 
	int $priority = 100, 
	string $icon = null
)
```

### `SleepingOwl\Admin\Navigation\Page`

```php
new SleepingOwl\Admin\Navigation\Page(
	string $modelClass = null
)
```

<a name="page-api"></a>
## API

### `addAlias(array|string $aliases)`
Добавление дополнительного списка `url` адресов, по которым данный раздел должен быть активен

### `addPage(string|array|PageInterface|null $page)`
[Добавление дочерней страницы](#add-page)

### `setPages(Closure $pages)`
Добавление дочерних страниц через анонимную функцию

```php
$page->setPages(function($page) {
	$page->addPage(...);
});
```

### `setId(string $id)`
Добавление уникального идентификатора для страницы, необходим для [поиска страницы](#find-by-id)

```php
AdminNavigation::addPage(['title' => '...', 'id' => 'unique_string']);
```

### `setTitle(string $title)`
Указание заголовка для страницы


### `setIcon(string $icon)`
Указание иконки для страницы

### `setUrl(string $url)`
Указание ссылки

### `setPriority(int $priority)`
Указание приоритета вывода

<a name="page-path"></a>
### `getPath(int $priority)`
Получение массива заголовков для текущего раздела с учетом родителских разделов

```php
$page1 = 'Title 1';
$page2 = 'Title 2';
$page3 = 'Title 3';

$page3->getPath() // ['Title 1', 'Title 2', 'Title 3']
```

### `getPath(int $priority)`
Получение массива (цепочки) от текущей страницы для корневой для построения хлебных крошек


<a name="page-badge"></a>
# Badges
Каждая страница может содержать неограниченное кол-во бейджев. При вызове метода `setBadge` или `addBadge` 
происходит передача текущего бейджа в стек. При выводе страницы будут выведены все бейджы из стека.

### `setBadge(KodiComponents\Navigation\Contracts\BadgeInterface $badge)`
Добавление объекта бейджа 

### `addBadge(string|Closure $value, array $htmlAttributes)`
Добавление бейджа 

```php
$page->addBadge(function() {
   return News::count();
}, ['class' => 'label-danger'])
```

<a name="page-collection"></a>
# Page Collection

Объект `KodiComponents\Navigation\PageCollection` наследуется от `Illuminate\Support\Collection` и содержит массив
дочерних страниц для разделов и объекта навигации.

<a name="find-by-id"></a>
### `findById(string $id): PageInterface|null`
Поиск станицы по ID

```php
AdminNavigation::getPages()->findById('unique_string'): PageInterface|null
```

<a name="find-by-path"></a>
### `findByPath(string $path, string $separator = '/'): PageInterface|null`
Поиск станицы по [пути вложенности](#page-path)

```php
// с разделителем `Title 1/Title 2/Title 3`
AdminNavigation::getPages()->findByPath('Title 1/Title 2/Title 3'): PageInterface|null
```
