# Установка

Используйте эту команду для начальной конфигурации SleepingOwl Admin. Она создаст все необходимые файлы и директории.

## Использование

```bash
$ php artisan sleepingowl:install
```

## Что делает эта команда

 - Публикует конфигурацию SleepingOwl Admin.
 - Публикет ассеты из SleepingOwl Admin в `public/packages/sleepingowl/default`.
   ```bash
   $ php artisan vendor:publish --tag=assets --force`
   ```
   
 - Создает директорию автозапуска (По умолчанию `app/Admin`).
 - Создает файл конфигурации меню по умолчанию. (По умолчанию `app/Admin/navigation.php`)
 - Создает файл автозапуска по умолчанию. (По умолчанию `app/Admin/bootstrap.php`)
 - Создает файл роутов по умолчанию. (По умолчанию `app/Admin/routes.php`)
 - Создает структуру директории public (*создает директорию `images/uploads`*)
 - Создает [сервис провайдер](model_configuration_section.md) `app\Providers\AdminSectionsServiceProvider` 

---

# Обновление

Обновление пакета происходит средствами composer. 

**Иногда обновления затрагивают также и ассеты, что требует удаления содержимого директории** `public/packages/sleepingowl/default`. **Не желательно в этой директории хранить пользовательский скрипты.** 
