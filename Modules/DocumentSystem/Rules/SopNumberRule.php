<?php

namespace Modules\DocumentSystem\Rules;

use Illuminate\Contracts\Validation\Rule;
use Modules\DocumentSystem\Entities\Document;

class SopNumberRule implements Rule
{
    public $document_type;
    public $has_document_number;

    /**
     * Create a new rule instance.
     *
     * @return void
     *
     */
    public function __construct($document_type, $has_document_number)
    {
        $this->document_type = $document_type;
        $this->has_document_number = $has_document_number;
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
            $this->has_document_number &&
            (
                $this->document_type == Document::SOP_DOC_TYPE && $value == '' ||
                $this->document_type == Document::SOP_DOC_TYPE && $value == null
            )
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
