# Конфигурация меню

Конфигурация меню SleepingOwl Admin по умолчанию располагается в `app/Admin/navigation.php`.

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
