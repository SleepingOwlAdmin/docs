# {{CONFIGURATION}}

[php artisan sleepingowl:install](installation#artisan) {{CONF01}} `sleeping_owl.php`.

{{CONF02}}:
```bash
$ php artisan vendor:publish --provider="SleepingOwl\Admin\Providers\SleepingOwlServiceProvider" --tag="config"
```

## {{CONF03}}

#### `title`
{{CONF_TITLE}}

#### `logo`
{{CONF_LOGO}}

#### `logo_mini` (@deprecated in ver. 6+)
{{CONF_LOGO_MINI}}

#### `url_prefix` (default: `'admin'`)
{{CONF_URL_PREFIX}}

#### `domain` (default: `false`)
{{CONF_DOMAIN}}

#### `middleware` (default: `['web', 'auth']`)
{{CONF_MIDDLEWARE}}

#### `enable_editor` (default: `false`)
{{CONF_ENABLE_EDITOR}}

#### `env_editor_url` (default: `'env/editor'`)
{{CONF_ENV_EDITOR_URL}}

#### `env_editor_policy` (default: `null`)
{{CONF_ENV_EDITOR_POLICY}}

#### `env_editor_excluded_keys`
{{CONF_ENV_EDITOR_EXCLUDED_KEYS}}
```php
'env_editor_excluded_keys' => [
    'APP_KEY', 'DB_*',
],
```

#### `env_editor_middlewares` (default: `[]`)
{{CONF_ENV_EDITOR_MIDDLEWARES}}

#### `auth_provider` (default: `'users'`)
{{CONF_AUTH_PROVIDER}}. [Custom User Providers](https://laravel.com/docs/authentication#adding-custom-user-providers)

#### `bootstrapDirectory` (default: `app_path('Admin')`)
{{CONF_BOOTSTRAPDIRECTORY}} SleepingOwl Admin

#### `imagesUploadDirectory` (default: `'images/uploads'`)
{{CONF_IMAGESUPLOADDIRECTORY}}

#### `filesUploadDirectory` (default: `'files/uploads'`)
{{CONF_FILESUPLOADDIRECTORY}}

#### `template` (default: `SleepingOwl\Admin\Templates\TemplateDefault::class`)
{{CONF_TEMPLATE}} `SleepingOwl\Admin\Contracts\TemplateInterface`

#### `datetimeFormat` (default: `'d.m.Y H:i'`)
#### `dateFormat` (default: `'d.m.Y'`)
#### `timeFormat` (default: `'H:i'`)
{{CONF_DATETIMEFORMAT}}

#### `wysiwyg`
{{CONF_WYSIWYG}}

#### `datatables` (default: `[]`)
{{CONF_DATATABLES}}

#### `dt_autoupdate` (default: `false`)
{{CONF_DT_AUTOUPDATE}}

#### `dt_autoupdate_interval` (default: `5`)
{{CONF_DT_AUTOUPDATE_INTERVAL}}

#### `dt_autoupdate_class` (default: `''`)
{{CONF_DT_AUTOUPDATE_CLASS}}

#### `dt_autoupdate_color` (default: `'#dc3545'`)
{{CONF_DT_AUTOUPDATE_COLOR}}

#### `breadcrumbs` (default: `true`)
{{CONF_BREADCRUMBS}}

#### `aliases`
{{CONF_ALIASES}}


## {{NEXT}}
- [{{GLOBAL}}](global)
- [{{AUTHENTICATION}}](authentication)
