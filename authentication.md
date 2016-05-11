# Авторизация

SleepingOwl Admin по умолчанию не использует авторизацию, т.е. доступ в админ панель никак не защищен. Настроить доступ можно используя `middleware`.

Самый простой вариант - использовать стандартный механизм, который предоставляет сам Laravel.

Для этого необходимо выполнить консольную команду `php artisan make:auth` (Подробнее https://laravel.com/docs/5.2/authentication#authentication-quickstart) и в конфиге `sleeping_owl.php` добавить middleware `auth`

```php
/*
 | ...
 | see https://laravel.com/docs/5.2/authentication#authentication-quickstart
 |
 */
    
'middleware' => ['web', 'auth'],
...
```

Таким образом у вас есть возможность с помощью middleware гибко настраивать правила для доступа в админ панель.

---

## Ограничение доступа в админ панель

Глобально ограничить доступ к админ панели можно с помощью middleware.

Допустим у вас есть пользователи и роли и вы хотите ограничить доступ к панели только администраторам. Для этого необходимо создать новый класс, например `App\Http\Middleware\AdminAuthenticate`

```php
<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;
class AdminAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $auth = Auth::guard($guard);
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('login');
            }
        }
        if (! $auth->user()->isAdmin()) {
            return response('Access denied.', 401);
        }
        
        return $next($request);
    }
}
```

Зарегестрировать данный класс в `App\Http\Kernel`

```php
 ...
 protected $routeMiddleware = [
     ...
     'admin' => \App\Http\Middleware\AdminAuthenticate::class,
     ...
 ];
 ...
```

И теперь можно использовать данный middleware, добавить его в конфиг `config\sleeoping_owl.php`

```php
...
'middleware' => ['web', 'admin'],
...
```

Подробнее о работе авторизации можно посмотреть в [документации](https://laravel.com/docs/5.2/authentication)
