# Руководство по обновлению

Обновление пакета осуществляется с помощью `composer`

```bash
$ composer update
```

После обновления, желательно выполнять команду

```bash
$ php artisan sleepingowl:update
```
или 

```bash
$ php artisan vendor:publish --tag=assets --force
```


для обновления компонентов.

Также стоит сбросить кеш view

```bash
$ php artisan view:clear
```

При желании можно добавить команду в `composer.json` для автоматического запуска команды

```json
{
    "scripts": {
        "post-update-cmd": [
            ...
            "php artisan sleepingowl:update"
        ]
    },
}
```
