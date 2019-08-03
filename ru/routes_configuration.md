# Конфигурация роутов

Вы можете регистрировать свои роуты в файле `routes.php` в директории `bootstrapDirectory` (*по умолчанию: `app/Admin/routes.php`*).

```php
Route::get('my-url', function () {
	$content = 'my page content';
	return AdminSection::view($content, 'My Page Title');
});

Route::post('category/my-url', '\App\Http\Controllers\MyController@postMyUrl');

Route::any('my-page', [
	'as' => 'admin.my-page',
	'uses' => '\App\Http\Controllers\MyPageController@myPage',
]);
```

Все роуты будут зарегистрированы с административным префиксом и middleware.

!>**Важно**: Если вы хотите отобразить свой контент внутри административного интерфейса используйте метод `AdminSection::view($content, $title)`.