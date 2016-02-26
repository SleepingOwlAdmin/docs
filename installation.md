# Установка

Установить пакет можно помощью командной строки
```
 composer require "laravelrus/sleepingowl":"4.*@dev"
```
или добавив строчку
```
"laravelrus/sleepingowl": "4.*@dev
```
в `composer.json` и запустить `composer update`

Далее нужно добавить сервис провайдер (Service Provider), в раздел `providers` файла `config/app.php`:

```
SleepingOwl\Admin\Providers\SleepingOwlServiceProvider::class,
```
