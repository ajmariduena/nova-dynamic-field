<?php

namespace Ajmariduena\DynamicField;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;

class DynamicField extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'dynamic-field';

    /**
     * Indicates if the field is used to manipulate JSON.
     *
     * @var bool
     */
    public $json = false;

    /**
     * The JSON encoding options.
     *
     * @var int|null
     */
    public $jsonOptions;

    /**
     * Retrieve values of dependency fields
     *
     * @param mixed $resource
     * @param string $attribute
     * @return array|mixed
     */
    protected function resolveAttribute($resource, $attribute)
    {
        $type = $resource->{$this->meta['baseOn']};

        $this->withMeta([
            'type' => $type
        ]);

        if ($this->json) {
            $value = parent::resolveAttribute($resource, $attribute);

            return is_array($value) || is_object($value)
                    ? json_encode($value, $this->jsonOptions ?? JSON_PRETTY_PRINT)
                    : json_encode(json_decode($value), $this->jsonOptions ?? JSON_PRETTY_PRINT);
        }

        return data_get($resource, str_replace('->', '.', $attribute));
    }

    /**
     * Set the base on field.
     *
     * @param  array  $hues
     * @return $this
     */
    public function baseOn(string $baseOn)
    {
        return $this->withMeta(['baseOn' => $baseOn]);
    }

    public function language($language)
    {
        return $this->options(['mode' => $language]);
    }

    /**
     * Indicate that the code field is used to manipulate JSON.
     *
     * @param  int|null  $options
     * @return $this
     */
    public function json($options = null)
    {
        $this->json = true;

        $this->jsonOptions = $options ?? JSON_PRETTY_PRINT;

        return $this->options(['mode' => 'application/json']);
    }

    /**
     * Set configuration options for the code editor instance.
     *
     * @param  array  $options
     * @return $this
     */
    public function options($options)
    {
        $currentOptions = $this->meta['options'] ?? [];

        return $this->withMeta([
            'options' => array_merge($currentOptions, $options),
        ]);
    }
}
