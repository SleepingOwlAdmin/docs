# Валидация

Для каждого элемента формы `AdminFormElement` можно указывать павила валидации. 

**Пример**
```php
AdminFormElement::text('title', 'Title')
    ->required()
    ->unique();
```

Если вы хотите переопределить стандартное сообщение для правила, вы можете воспользоваться одним из сопособов:

```php
AdminFormElement::text('title', 'Title')
    ->required('Поле обязательно для заполнения')
    ->unique('Поле должно содержать уникальное значение')
    
// Или

AdminFormElement::text('title', 'Title')
    ->addValidationRule('required', 'Поле обязательно для заполнения')
    ->addValidationRule('number', 'Поле должно быть числом');
    
// Или

AdminFormElement::text('title', 'Title')
    ->required()
    ->addValidationMessage('required', 'Поле обязательно для заполнения');
```

Список доступных правил можно посмотреть здесь: https://laravel.com/docs/5.0/validation#available-validation-rules

______

### Доступные методы:

```php
/**
 * @param string|null $message
 *
 * @return $this
 */
public function required($message = null);

/**
 * @param string|null $message
 *
 * @return $this
 */
public function unique($message = null);

/**
 * @param string      $rule
 * @param string|null $message
 *
 * @return $this
 */
public function addValidationRule($rule, $message = null);

/**
 * @return array
 */
public function getValidationRules();

/**
 * @return array
 */
public function getValidationMessages()

/**
 * @param array $validationMessages
 *
 * @return $this
 */
public function setValidationMessages(array $validationMessages);

/**
 * @param string $rule
 * @param string $message
 *
 * @return $this
 */
public function addValidationMessage($rule, $message);

/**
 * @return array
 */
public function getValidationLabels();
```
