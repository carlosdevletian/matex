<?php

namespace App\Models\Presenters;

abstract class Presenter
{
    protected $model;

    function __construct($model)
    {
        $this->model = $model;
    }

    protected function presentAsDollars($amount)
    {
        return number_format($amount, 2, '.', ',');
    }

    public function __get($property)
    {
        if (method_exists($this, $property)) {
            return $this->$property();
        }
        $failureMessage = "%s does not respond to the '%s' property or method.";
        throw new \Exception(sprintf($failureMessage, static::class, $property));
    }
}