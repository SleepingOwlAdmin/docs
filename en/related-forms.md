# Nested forms with relations

- [HasMany](#hasmany)
- [ManyToMany](#manytomany)
- [BelongsTo](#belongsTo)

This section is part of [form elements](form-element) section, and describes work process with model relations via 
creating inline forms with CRUD features.

When do you need to use nested inline forms? Almost always! It's about 90% probability, that you'll have related models
in your project. For instance, user may have a few profile (`has-many`), shop (as physical object) will have a few
addresses (`has-many`), product can have quite many properties and values that are stored in `pivot` table.

<a name="hasmany"></a>
## HasMany

```php
AdminFormElement::hasMany(string $relation, array $elements): static
```

- `$relation` - The name of the relation
- `$elements` - Fields of form

Describes nested form view for `HasMany` relation.

Example: imagine we have two models - `User` and `Profile`, linked by `one-to-many` relation. We need to edit profiles
of user on Users section page.

```php
// onEdit
$form = AdminForm::panel();

$profiles = AdminFormElement::hasMany('profiles', [
    AdminFormElement::text('name', 'Name')->required(),
    AdminFormElement::text('last_name', 'Last Name'),
    AdminFormElement::text('phone', 'Phone')->required(),
]);

$tabs = AdminDisplay::tabbed([
    AdminDisplay::tab($profiles, 'Profiles'),
]);

$form->addBody($tabs);

return $form;
```

<a name="manytomany"></a>
## ManyToMany

```php
AdminFormElement::manyToMany(string $relation, array $elements): static
```

- `$relation` - The name of the relation
- `$elements` - Fields of form

Describes nested form view for `ManyToMany` relation.

Sometimes you need to change `pivot` attributes in linked tables. To resolve such case you'll probably to steps like these:

1. Create `pivot` table and add `autoincrement` field for identification;
2. Create model for this `pivot` table;
3. Create section, for managing these `pivot` attributes;
4. Add at least 2 fields of type `select`, referring to linked entities;
5. Add fields for managing `pivot` fields of table.

**You can now forget about these kind of sections by using `ManyToMany` element type**

`manyToMany` element will automatically add element of type `select` with values of related model, you'll need to add
additional elements.

For instance: we have model `Product` and `ProductProperties` with relation `many-to-many` and `pivot` field `value`
inside `pivot` table. We need to create `inline` CRUD for properties of products.

```php
AdminFormElement::manyToMany('properties', [
    // Pivot field `value` for `pivot` table
    AdminFormElement::text('value')->required(),
]);
```

### Methods

<a name="mtm-unique"></a>
#### `unique(array $fields): static`

Marks which fields of `pivot` table must be validates as `unique`. By default it's foreign keys of target and related 
models. If method is called, you'll have to explicitly pass `foreign_key` of related model and additional field names.

**`foreign_key` of target model will always be prepended to array of unique fields!**

<a name="mtm-related-element"></a>
#### `getRelatedElement(): SleepingOwl\Admin\Form\Element\Select`

Returns form element, responsible for value of related model. Can be used to manage view representation of form element.
Setting placeholder, label, etc.

<a name="belongsto"></a>
## BelongsTo

```php
AdminFormElement::belongsTo(string $relation, array $elements): static
```

- `$relation` - The name of the relation
- `$elements` - Fields of form

Describes nested form view for `BelongsTo` relation. Works exactly like `HasMany`, allowing you to manage only 1
related model entity.

---

<a name="api"></a>
## API

<a name="api-modify-query"></a>
#### `modifyQuery(callable $callback): static`

- `$callable` - callback, which is called to modify relation query. Instance of relation will be passed as the only argument.

Allows you to modify related models querying logic. It's useful when you need to change the order of related models list
inside form view.

**ATTENTION! Adding filtration in query modifier will lead to result, when form is containing not full list of relations.
Use with caution.**

<a name="api-set-label"></a>
#### `setLabel(string $label): static`

Sets label of the form with relations.

<a name="api-set-group-label"></a>
#### `setGroupLabel(string $label): static`

Sets label for each "group" of form. Group - is the block of single related entity being created/edited.

<a name="api-set-limit"></a>
#### `setLimit(int $limit): static`

Sets limit for possible added related entities.

<a name="api-disable-creation"></a>
#### `disableCreation(): static`

Disables ability to add new related entities inside a form.

<a name="api-copy-after-save"></a>
#### `copyAfterSave(): static`

Enables copying of created related entities when `Save and create` action was fired. All values from related forms will
be copied for next request. By default this feature is disabled because of server request URL max length setting.