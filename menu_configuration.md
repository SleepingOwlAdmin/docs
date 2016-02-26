# Конфигурация меню

Конфигурация меню SleepingOwl Admin по умолчанию располагается в `app/Admin/navigation.php`. Если файл
возвращает массив, то этот массив будет также использоваться для построения меню.

Класс навигации `SleepingOwl\Admin\Navigation` инициализируется через Service Container 
и доступ к нему можно получить несколькими способами:

```php
$navigation = app('sleeping_owl.navigation');

// Или используя фасад

$navigation = AdminNavigation::getRootFacade();
```
____

Новый раздел в меню можно добавить несколькими способами:

**Через сервис контейнер или фасад**
```php
app('sleeping_owl.navigation')
    ->addPage()
    ->setTitle('Blog')
    ->setUrl('/blog');
    
// Или

// Создание элемента меню для модели
AdminNavigation::addPage(\App\Blog::class)
    ->setPriority(100)
    ->setIcon('fa fa-newspaper-o');
```

**Через `AdminSection` класс**

```php
AdminSection::addMenuPage(\App\User::class);
```

Метод `addPage` может принимать в качестве аргумента
 - `[string] Model class name`
 - `[SleepingOwl\Admin\Navigation\Page] Page class`
 - `[array] ['title' => 'News', 'priority' => 100, 'icon' => 'fa fa-newspaper-o']`
 
**Пример**
```php
// Зарегестрированный класс модели использованной для создания раздела
AdminNavigation::addPage(\App\Blog::class);

AdminNavigation::addPage(new Page()->setTitle('News'));

AdminNavigation::addPage(['title' => 'News', 'priority' => 100, 'icon' => 'fa fa-newspaper-o']);
```

Меню может иметь неограниченную вложеность страниц:

```php
use SleepingOwl\Admin\Navigation\Page;

AdminNavigation::addPage(\App\Blog::class)->setPages(fuction(Page $section) {
   
    $section
        ->addPage()
        ->setTitle('Tags')
        ->setUrl('blog/tags')
        ->setIcon('fa fa-tags');
    
    $section->addPage()->setTitle('settings')->setPages(function(Page $section) {
    
        $section
            ->addPage()
            ->setTitle('blog settings')
            ->setUrl(route('blog.settings'));
        
    });
});
```

Также разделы в меню можно добавить в виде массива:

```php

use SleepingOwl\Admin\Navigation\Page;

$array = [
     [
         'title' => 'News', 
         'priority' => 100, 
         'icon' => 'fa fa-newspaper-o'
     ],
     [
         'title' => 'About', 
         'priority' => 200, 
         'pages' => [
             // Если в качестве страницы передана строка, то будет произведен поиск по
             // зарагистрированой модели
             \App\Blog::class,
             
             (new Page())->setTitle('Us')->setUrl('about/us'),
             
             [
                 'title' => 'Contacts', 
                 'priority' => 300, 
                 'icon' => 'fa fa-credit-card'
             ]
         ]
     ]
];

AdminNavigation::setFromArray($array);

// Или к внутренней странице

AdminNavigation::addPage(\App\Blog::class)->setPages(fuction(Page $section) {
       $section->addPage()->setTitle('Sub menu')->setFromArray($array);
});
```

## Доступ

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

______
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
