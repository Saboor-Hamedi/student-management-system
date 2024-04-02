<?php

namespace Thesis\functions;

class InputUtils
{
    public static function sanitizeInput($input, $type)
    {
        if ($input === null) {
            return ''; // Return empty string for null input
        }

        switch ($type) {
            case 'string':
                return strip_tags($input, ENT_QUOTES | ENT_HTML5);
            case 'email':
                return filter_var($input, FILTER_SANITIZE_EMAIL);
            case 'url':
                return filter_var($input, FILTER_SANITIZE_URL);
            case 'number_int':
                return filter_var($input, FILTER_SANITIZE_NUMBER_INT);
            case 'number_float':
                return filter_var($input, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            default:
                return filter_var($input, FILTER_UNSAFE_RAW);
        }
    }
}
