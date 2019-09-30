# Configuration

[php artisan sleepingowl:install](installation#artisan) during installation automatically publishes a config `sleeping_owl.php`.

If you want to update config file, then just run artisan command:
```bash
$ php artisan vendor:publish --provider="SleepingOwl\Admin\Providers\SleepingOwlServiceProvider" --tag="config"
```

## Config file parapmeters

#### `title`
String to display in page title

#### `logo`
Logo displayed in the upper panel

#### `logo_mini` (@deprecated in ver. 6+)
Admin mini logo for small display or minimized sidebar

#### `url_prefix` (default: `'admin'`)
Admin url preffix

#### `domain` (default: `false`)
Enable/disable admin on subdomain

#### `middleware` (default: `['web', 'auth']`)
Middleware that restrict the administrative module from unauthorized users

#### `enable_editor` (default: `false`)
Enabling and adding editing ENV settings

#### `env_editor_url` (default: `'env/editor'`)
Slug for editing env settings file

#### `env_editor_policy` (default: `null`)
Adding a Policy

#### `env_editor_excluded_keys`
An array of keys or key masks to hide in the settings ENV-editor
```php
'env_editor_excluded_keys' => [
    'APP_KEY', 'DB_*',
],
```

#### `env_editor_middlewares` (default: `[]`)
Adding an middleware for editing settings

#### `auth_provider` (default: `'users'`)
Auth Provider. [Custom User Providers](https://laravel.com/docs/authentication#adding-custom-user-providers)

#### `bootstrapDirectory` (default: `app_path('Admin')`)
The path to the autoload SleepingOwl Admin

#### `imagesUploadDirectory` (default: `'images/uploads'`)
Image upload directory. Relative path from `public` directory

#### `filesUploadDirectory` (default: `'files/uploads'`)
File upload directory. Relative path from `public` directory

#### `template` (default: `SleepingOwl\Admin\Templates\TemplateDefault::class`)
Template class. Must implement interface `SleepingOwl\Admin\Contracts\TemplateInterface`

#### `datetimeFormat` (default: `'d.m.Y H:i'`)
#### `dateFormat` (default: `'d.m.Y'`)
#### `timeFormat` (default: `'H:i'`)
Date and time formats for form and display elements

#### `wysiwyg`
Default settings for Wysiwyg editors

#### `datatables` (default: `[]`)
Default datatables settings

#### `dt_autoupdate` (default: `false`)
Enable/disable auto-update datatables

#### `dt_autoupdate_interval` (default: `5`)
Datatables auto-update time in minutes

#### `dt_autoupdate_class` (default: `''`)
Auto-update class. If not specified, all datatables will be auto-updated

#### `dt_autoupdate_color` (default: `'#dc3545'`)
Datatables auto-update progress bar color

#### `breadcrumbs` (default: `true`)
Enable/disable breadcrumbs

#### `aliases`
Package aliases


## Next step
- [System Description](global)
- [Authentication](authentication)
