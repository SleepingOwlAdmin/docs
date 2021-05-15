# Быстрый старт

 - [Демо версия](#demo)
 - [Создание простого CRUD в SOA для Чайников](#crud-create)
 - [Чат](#chat)
 
<a id="demo"></a>
## Демо версия
После установки пользователь получает пустую админку и не знает куда же двигаться дальше.
Самым простым вариантом будет клонирование [Demo](http://demo.sleepingowladmin.ru/admin) и изучение на ней основных возможностей. 
    
```
git clone https://github.com/SleepingOwlAdmin/demo demo.soa
```
После клонирования создайте .env файл копированием .env.example и заполните настройки базы данных. 

Поочередно запустите:
```
composer install
...
composer update
...
php artisan key:generate
...
php artisan migrate --seed
```
Демо версия готова. SleepingOwlAdmin находится в папке \Admin

Роуты     \Admin\Http\routes.php

Навигация \Admin\navigation.php

Разделы   \Admin\Http\Sections\

Кастомные Представления и Представления Виджетов в Admin\resources\ и доступны по view('admin::name')

Для вставки своего view (\Admin\resources\views\index.blade.php) в основной layout SOA используйте.
```
use  AdminSection;
...
return AdminSection::view(view('admin::index',['variable'=>$variable]), 'Заголовок');
...
```

    
<a id="crud-create"></a> 
## Создание простого CRUD в SOA для Чайников
Хорошая статья для новичков по созданию новой [секции CRUD](http://laravel.su/articles/laravel-sleeping-owl-crud-for-dummers)
    
    
<a id="chat"></a>  
## Чат SleepingOwlAdmin
 Если у вас возникли вопросы можно попросить совета в [Чате SleepingOwlAdmin](https://gitter.im/LaravelRUS/SleepingOwlAdmin)