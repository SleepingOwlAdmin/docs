# Локализация

SleepingOwl Admin использует локаль из конфигурации в вашем `config/app.php`.

```php
/*
|--------------------------------------------------------------------------
| Application Locale Configuration
|--------------------------------------------------------------------------
|
| The application locale determines the default locale that will be used
| by the translation service provider. You are free to set this value
| to any of the locales which will be supported by the application.
|
*/

'locale' => 'ru',
```

<a name="supported-locales"></a>
## Поддерживаемые локали

 - en
 - ru
 - uk
 - zn-CN
 - локали es, pl, pt-BR пока не поддерживаются полностью, и совсем не поддерживаются в новой ветке `dev-bs4` но мы работаем над этим


<a name="custom-locales"></a>
## Ваши собственные локали

Вы можете добавить свою локализацию. Для этого создайте файл
`resources/lang/vendor/sleeping_owl/{locale}/lang.php`, вставьте все
из `vendor/laravelrus/sleepingowl/resource/lang/{locale}/lang.php` и
сделайте необходимые изменения.

**Вы можете отправить мне вашу локализацию для включения ее в основной состав пакета.**
