# Управление виджетами

Виджеты предназначены для вставки в блоки `@yield` или `@stack` в шаблоны собственных кусков HTML кода. 
Они могут быть полезны, например, если вам необходимо добавить в шаблон навигации по админ панели собственные пункты меню.

## Как использовать

Каждый виджет представляет собой класс реализующий интерфейс `SleepingOwl\Admin\Contracts\Widgets\WidgetInterface`. Для удобства существует
абстрактный класс `SleepingOwl\Admin\Widgets\Widget`, которы реализует часть методов интерфейса и вы можете наследовать свой класс от него.

**Пример класса виджета**

```php
<?php

namespace App\Widgets;

use SleepingOwl\Admin\Widgets\Widget;

class DashboardMap extends Widget
{

    /**
     * Если метод вернет false, блок не будет помещен в шаблон
     * Данный метод не обязателен
     *
     * @return boolean
     */
    public function active()
    {
        return true;
    }

    /**
     * При помещении в один блок нескольких виджетов они будут выведены в порядке их позиции
     * Данный метод не обязателен
     *
     * @return integer
     */
    public function position()
    {
        return 0;
    }

    /**
     * HTML который необходимо поместить
     *
     * @return string
     */
    public function toHtml()
    {
        return view('dashboard.map')->render();
    }

    /**
     * Путь до шаблона, в который добавляем
     *
     * @return string|array
     */
    public function template()
    {
        // AdminTemplate::getViewPath('dashboard') == 'sleepingowl:default.dashboard'
        return \AdminTemplate::getViewPath('dashboard');
    }

    /**
     * Блок в шаблоне, куда помещаем
     *
     * @return string
     */
    public function block()
    {
        return 'block.top';
    }
}

```


После создания класса, его необходимо зарегистрировать с реестре виджетов, например так:

```php
class AppServiceProvider extends ServiceProvider
{
    /**
     * Список виджетов, которые необходимо подключить в шаблоны
     *
     * @var array
     */
    protected $widgets = [
        \App\Widgets\DashboardMap::class,
        \App\Widgets\NavigationUserBlock::class
    ];

    public function boot()
    {
        // Регистрация виджетов в реестре
        /** @var WidgetsRegistryInterface $widgetsRegistry */
        $widgetsRegistry = $this->app[\SleepingOwl\Admin\Contracts\Widgets\WidgetsRegistryInterface::class];
 
        foreach ($this->widgets as $widget) {
            $widgetsRegistry->registerWidget($widget);
        }
    }
}

```

**При вставки виджетов в блоки `@yield` необходимо помнить, что ваш HTML должен содержать директиву `@parent` https://laravel.com/docs/blade#extending-a-layout**


## Список блоков:
  - `\AdminTemplate::getViewPath('_layout.inner')` Основной шаблон
    - `content.top`
    - `content.bottom`
  - `\AdminTemplate::getViewPath('_partials.navigation')` Боковое меню
    - `sidebar.top`
    - `sidebar.ul.top`
    - `sidebar.ul.bottom`
    - `sidebar.botto`
  - `\AdminTemplate::getViewPath('_partials.header')` Верхнее меню
    - `navbar`
    - `navbar.left`
    - `navbar.right`
 
  - `\AdminTemplate::getViewPath('dashboard')` Дашборд
    - `block.top`
    - `block.top.column.left`
    - `block.top.column.right`
    - `block.content`
    - `block.content.column.left`
    - `block.content.column.right`
    - `block.footer`