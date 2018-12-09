# Dynamic Field for Laravel Nova

Useful for something like settings on a content management system.

## Installation

You can install this package into a Laravel app that uses [Nova](https://nova.laravel.com) via composer:

```bash
composer require ajmariduena/dynamic-field
```

## Usage

Imagine we have a table like this:

```php
Schema::create('settings', function (Blueprint $table) {
    $table->increments('id');
    $table->string('key');
    $table->string('display_name')->nullable();
    $table->text('value')->nullable();
    $table->string('type');
});
```

On Setting nova resource:
```php
use Ajmariduena\DynamicField\DynamicField;

public function fields(Request $request)
{
    return [
        Text::make('Name'),
        Select::make('Type')->options([
            'text' => 'Text',
            'date' => 'Date',
            'boolean' => 'Boolean',
            'textarea' => 'Textarea',
            'trix' => 'Trix',
            'code' => 'Code',
        ]),
        DynamicField::make('Value')->baseOn('type')
    ];
}
```

This will render a field base on type value on settings table.

### Currently supported types

* Text ( text )
* Date ( date )
* Boolean ( boolean )
* Textarea ( textarea )
* Trix ( trix )
* Code ( code )
    * `->json()` is supported.
    * `->language('php')` is supported.

### Caveats

For boolean type you need to cast to int value in order to make it work.

Example using Accessor:
```php
class Setting extends Model
{
    public function getValueAttribute($value)
    {
        switch ($this->type) {
            case 'boolean':
                return (int)$value;
            default:
                return $value;
        }
    }
}
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.