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

Copyright 2018 Alexander Maridueña

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.