<?php

namespace App;

use Illuminate\Support\Facades\Validator;

class ValidationFailure
{
    public static function fail($message, $field = 'default_field')
    {
        Validator::make([], [
            $field => 'required'
        ], [
            "{$field}.required" => $message
        ])->validate();
    }
}
