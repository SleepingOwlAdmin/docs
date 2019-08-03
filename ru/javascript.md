# Javasript API

 - [Config](#config)
 - [Сообщения](#messages)
 - [События](#events)
 - [Модули](#modules)
 - [Подключение WYSIWYG редакторов](#wysiwyg)
 - [Url](#url)
 - [User](#user)
 - [Asset](#asset)


## Admin:

#### Получение текущего токена (Readonly)

`Admin.token`

#### Получение текущей локали (Readonly)

`Admin.locale`

#### Получение текущего окружения (Readonly)

`Admin.env`

#### Проверка на активность дебага (Readonly)

`Admin.debug`

<a name="config"></a>
#### Объект `Admin.Config`

Настройки приложения хранятся в глобальном объекте `window.GlobalConfig` и при старте приложения передаются в этот объект

```js
Admin.Config.get(key, [default])
Admin.Config.set(key, value)
Admin.Config.has(key)
Admin.Config.merge(config)
Admin.Config.all()
``` 

<a name="messages"></a>
## Сообщения

Для вывода сообщений используется [SweetAlert2](https://limonte.github.io/sweetalert2/)

```js
// Сообщение об ошибке
Admin.Messages.error('title', 'message')

// Success сообщение
Admin.Messages.success('title', 'message')

// Произвольное сообщение
Admin.Messages.message('title', 'message', 'error')

// Сообщение с подтверждением
Admin.Messages.confirm('title', 'message').then(confirm, dismiss)

// Сообщение с полем ввода
Admin.Messages.prompt('title', 'message', 'placeholder').then(confirm, dismiss)
```

<a name="events"></a>
## События

В системе есть простая система обработки событий `Admin.Events`

```js
// Подписка на событие
Admin.Events.on('event:name', function() {
   // your js code here ...
})

// Запуск события и передача аргументов
Admin.Events.fire('event:name', param1, param2, ....)
```

#### Список событий

* `wysiwyg:switchOn [editor]` - Редактор подключен в input [`editor`] - объект инициализированного редактора
* `wysiwyg:switchOff [textareaId]` - Редактор выключен [`textareaId`] - ID инпута
* `wysiwyg:exec [command, textareaId, data]` - Вызов команды редактора
* `bootstrap::tab::shown [tab]` - Отображение вкладки [`tab`] - ключ активного таба
* `bootstrap::tab::hidden [tab]` - Скрытие вкладки
* `datatables::draw [Datatable]` - Рендер datatables [`Datatable`] - объект отрендереной таблицы
* `display.tree::changed`

<a name="modules"></a>
## Модули

Модуль представляет собой блок кода, который будет запускаться при каждом старте системы

#### Регистрация модуля

```js
Admin.Modules.register(key, function() {
    // your js code here ...
}, prioroty, events);

// key - ключ (название) текущего модуля. В системе не может быть нескольких модулей с одним ключом (модуль будет переопределен)
// callback - код который будет выполнен при запуске модуля
// prioroty - приоритет запуска модулей. (После запуска системы, все модули сортируются по приоритету и происходит последовательный запуск)
// events - событие или массив событий при возникновении которых код модуля будет запущен повторно.
```

#### Ручной запуск модулей

```js
Admin.Modules.call(key)
```


<a name="wysiwyg"></a>
## Подключение WYSIWYG редакторов

Предназначен для регистрации и запуска редакторов текста в системе.

#### Регистрация редактора

Регистрация по сути заключается в указании трех функций, которые будут вызваны в момент подключения редактора, отключения и выполнении каких либо команд.

```js
Admin.WYSIWYG.register(name, switchOnHandler, switchOffHandler, execHandler);

function switchOnHandler(textareaId, config) {
   // textareaId - идентификатор поля ввода к которому необходимо подключить редактор
   // config - дополнительные настройки

   editor = new WYSIWYGEditor(textareaId)
   editor.setConfig(config)
   return editor
}

function switchOffHandler(editor, textareaId) {
   // editor - объект подключенного редактора
   // textareaId - идентификатор поля ввода к которому необходимо подключить редактор

   editor.destroy()
}

function execHandler(editor, command, textareaId, data) {
   // editor - объект подключенного редактора
   // command - команда, которую необходимо выполнить
   // textareaId - идентификатор поля ввода к которому необходимо подключить редактор
   // data - дополнительные данные

    switch (command) {
        case 'insert':
            editor.insertText(data);
            break;
    }
}

// name - ключ (Название) редактора
// switchOnHandler - функция, которая будет вызвана в момент подключения. Обязательно должен вернуть объект подключаемого редактора (Происходит запуск события wysiwyg:switchOn)
// switchOffHandler - функция, которая будет вызвана в момент отключения редактора (Происходит запуск события wysiwyg:switchOff)
// execHandler - функция, которая будет вызвана в момент вызова команды редактора (Происходит запуск события wysiwyg:exec)
```

#### Подключение редактора

```js
// Сначала должен быть зарегистрирован в системе редактор
Admin.WYSIWYG.register('ckeditor', switchOnHandler, switchOffHandler, execHandler);

<textearea id="MyTextarea"></textearea>
Admin.WYSIWYG.switchOn('MyTextarea', 'ckeditor', {param1: ..., param2: ...})
```

#### Отключение редактора

```js
Admin.WYSIWYG.switchOff('MyTextarea')
```

#### Выполнение команды

```js
Admin.WYSIWYG.exec('MyTextarea', 'insert', 'Текст который вставляем в редактор')
```


<a name="url"></a>
## Url

Модуль предназначен для работы с url адресами.

#### Получение якоря
```js
Admin.Url.hash
```

#### Генерация ссылки на asset файл для текущей темы
```js
Admin.Url.asset(path, query)
// path - относительный путь до файла
// query - параметры для генерации query string {foo: bar, baz: bar} = ?foo=bar&baz=bar

Admin.Url.asset('script.js') // http://site.com/packages/sleepingow/default/script.js
```

#### Генерация admin ссылки
```js
Admin.Url.admin(path, query)
// path - относительный путь
// query - параметры для генерации query string {foo: bar, baz: bar} = ?foo=bar&baz=bar

Admin.Url.admin('users/1') // http://site.com/backend/users/1
```

#### Генерация front ссылки
```js
Admin.Url.app(path, query)
// path - относительный путь
// query - параметры для генерации query string {foo: bar, baz: bar} = ?foo=bar&baz=bar

Admin.Url.app('users/1') // http://site.com/users/1
```

#### Получение системных данных
```js
Admin.Url.url // ссылка на front
Admin.Url.url_prefix // получение значения url prefix админ панели
Admin.Url.asset_dir// относительный путь до хранения ассетов для текущей темы
```


<a name="user"></a>
## User

#### Получение ID авторизованного пользователя

```js
Admin.User.id: int|null
```

#### Получение статуса авторизации пользователя

```js
Admin.User.isAuthenticated(): bool
```

<a name="asset"></a>
## Asset

#### Подключение CSS файлов
Если файл с переданным путем уже добавлен на страницу, он будет пропущен.
Возвращает объект `Promise`.

```js
Admin.Asset.css(string url): Promise
```

#### Подключение JS файлов
Если файл с переданным путем уже добавлен на страницу, он будет пропущен.
Возвращает объект `Promise`.

```js
Admin.Asset.js(string url): Promise
```

#### Подключение Image файлов
Возвращает объект `Promise`. 
https://habrahabr.ru/company/zerotech/blog/317256/

```js
Admin.Asset.img(string url): Promise

Admin.Asset.img('http://sizte.com/logo.png').then(function(url) {
    $('#images').append('<img src="'+url+'" style="width: 200px;" />');
})
```