# Assets

Данный trait используется для организации работы с подключением ассетов.

Допустим у нас есть класс `Form\Element\Select`

```php
class Select extends ... implements \SleepingOwl\Admin\Contracts\Initializable 
{

  use \SleepingOwl\Admin\Traits\Assets;
  
  public function __construct()
  {
    // Инициализация пакета для хранения ассетов
    $this->initializePackage();
    
    ...
  }
  
  public function initialize()
  {
    // подключение ассетов в шаблон
    $this->includePackage();
    
    ...
  }
  
  ...
}
```

При подключении трейта класс инициализирует новый пакет через `PackageManager` с названием текущего класса, т.е. для класса
выше это будет `PackageManager::add('Form\Element\Select')` и при вызове методов трейта `withPackage`, `addScript` и `addStyle` мы добавляем новые 
ассеты в данный пакет.

Как мы знаем метод `initialize` в классе `Form\Element\Select` будет вызван только в момент подключение элемента в форму, а 
вместе с ним и ассеты.

## API

#### addStyle
Добавленме css файла в пакет

```php
static::addStyle(string $handle, string $style, array $attributes): return self
```

#### addScript
Добавленме js файла в пакет

```php
static::addScript(string $handle, string $script, array $dependency): return self
```

#### withPackage
Подключение пакета

```php
static::withPackage(string|array $packages): return self
```
