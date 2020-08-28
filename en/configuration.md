# Configuration

[php artisan sleepingowl:install](installation#artisan) during installation automatically publishes a config `sleeping_owl.php`.

If you want to update config file, then just run artisan command:
```bash
$ php artisan vendor:publish --provider="SleepingOwl\Admin\Providers\SleepingOwlServiceProvider" --tag="config"
```

## Config file parapmeters
- [Main](#main)
- [Datatables](#datatables)
- [Other](#other)
- [ENV-settings](#env-settings)
- [Autoupdate Datatables](#autoupdate)


<a name="env-settings"></a>
#### `title`
String to display in page title

#### `logo`
Logo displayed in the upper panel

#### `logo_mini`
Admin mini logo for small display or minimized sidebar

#### `menu_top` (only in @dev-development branch)
Text displayed above the menu

<a name="datatables"></a>
#### `state_datatables` (only in @dev-development ветке) (default: `true`)
DataTables state saving in localStorage

#### `state_tabs` (only in @dev-development ветке) (default: `false`)
Keep tabs active

#### `state_filters` (only in @dev-development ветке) (default: `false`)
Saving datatables filter values

<a name="other"></a>
#### `url_prefix` (default: `'admin'`)
Admin url preffix

#### `domain` (default: `false`)
Enable/disable admin on subdomain

#### `middleware` (default: `['web', 'auth']`)
Middleware that restrict the administrative module from unauthorized users

<a name="env-settings"></a>
#### `enable_editor` (default: `false`)
Enabling and adding editing ENV settings

#### `env_keys_readonly` (default: `false`)
Makes the view-only key field

#### `env_can_delete` (default: `true`)
Allows/denies key/value deletion

#### `env_can_add` (default: `true`)
Allows/denies adding a key/value (if `env_keys_readonly == false`)

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

#### `datatables_highlight` (default: `false`)
Highlight DataTables column on mouseover

<a name="autoupdate"></a>
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

#### `scroll_to_top` (default: `true`)
Enable/disable scroll to top button

#### `aliases`
Package aliases


## Next step
- [System Description](global)
- [Authentication](authentication)
