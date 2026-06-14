<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class SopNumberRule implements Rule
{
    public $document_type;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($document_type)
    {
        $this->document_type = $document_type;
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
        $res = true;
        if (
            $this->document_type == 'sop' && $value == '' ||
            $this->document_type == 'sop' && $value == null
        ) {
            $res = false;
        }

        return $res;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute is required if Document type is Standard Operational Procedure';
    }
}
