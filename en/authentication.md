# Authentication

 - [Custom Middleware](#middleware)

SleepingOwl Admin uses Laravel authentication by `middleware`.

In your app you should run artisan command: (See https://laravel.com/docs/5.2/authentication#authentication-quickstart)
```bash
$ php artisan make:auth
```

And after add middleware `auth` to `config/sleeping_owl.php`

**Example**
```php
/*
 | ...
 | see https://laravel.com/docs/5.2/authentication#authentication-quickstart
 |
 */
'middleware' => ['web', 'auth'],
...
```

---

<a name="middleware"></a>
## Custom Middleware

You cat create custom middleware class< for example `App\Http\Middleware\AdminAuthenticate`

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

And register this middleware in `App\Http\Kernel`

```php
 ...
 protected $routeMiddleware = [
     ...
     'admin' => \App\Http\Middleware\AdminAuthenticate::class,
     ...
 ];
 ...
```

And add this middleware `admin` to `config\sleeoping_owl.php`

```php
...
'middleware' => ['web', 'admin'],
...
```

For this middlware, in migration `users`, need to add field `is_admin` for authentication. It should be `boolean false` but only for admin in the database put `true`

```php
Schema::create('users', function (Blueprint $table) {
    ...
    $table->boolean('is_admin')->default(false);
    ...
});

```