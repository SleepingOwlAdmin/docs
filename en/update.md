# Updating

You should update package via `composer`

```bash
$ composer update
```

After update you should run artisan command for update assets:

```bash
$ php artisan sleepingowl:update
```
or

```bash
$ php artisan vendor:publish --tag=assets --force
```

And clear view-cache

```bash
$ php artisan view:clear
```

You can add this command to `composer.json` for auto updating assets

```json
{
    "scripts": {
        "post-update-cmd": [
            ...
            "php artisan vendor:publish --tag=assets --force"
        ]
    },
}
```