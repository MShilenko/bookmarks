<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidURL implements Rule
{
    private static $available_statuses = [
        'HTTP/1.0 200 OK', 
        'HTTP/1.1 200 OK', 
    ];

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return parse_url($value, PHP_URL_SCHEME) && parse_url($value, PHP_URL_HOST);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Incorrect URL entered.';
    }
}
