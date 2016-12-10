# Configuration

If you want to update config file, then just run artisan command:
```bash
$ php artisan vendor:publish --provider="SleepingOwl\Admin\Providers\SleepingOwlServiceProvider" --tag="config"
```

## Config file parapmeters

#### `title`
Admin title

#### `logo`
Admin full logo

#### `logo_mini`
Admin mini logo for small display or minimized sidebar

#### `url_prefix`
Admin url preffix

**Default**: `admin`

#### `middleware`
Middleware, который ограничивают административный модуль от доступа неавторизованных пользователей.

**Default**: `['web', 'auth']`

#### `auth_provider`
Auth provider. See [Laravel user providers](https://laravel.com/docs/5.2/authentication#adding-custom-user-providers)

**Default**: `users`

#### `bootstrapDirectory`
Path to auto loading admin sections. Place in this path your section configuration. Each  `.php` file will be included.

**Default**: `app_path('Admin')`

#### `imagesUploadDirectory`
Image upload directory. Relative path from public directory

**Default**: `'images/uploads'`

#### `filesUploadDirectory`
File upload directory. Relative path from public directory

**Default**: `'files/uploads'`

#### `template`
Template class (Must implement interface `SleepingOwl\Admin\Contracts\TemplateInterface`)

**Default**: `SleepingOwl\Admin\Templates\TemplateDefault::class`

#### `datetimeFormat`, `dateFormat`, `timeFormat`
Date and time formats for form and display elements

**Default**: `'d.m.Y H:i', 'd.m.Y', 'H:i'`

#### `wysiwyg`
Default settings for Wysiwyg editors

#### `datatables`
Default settings for Datatables

#### `breadcrumbs`
Enable\Disable breadcrumbs

#### `aliases`
Package aliases
