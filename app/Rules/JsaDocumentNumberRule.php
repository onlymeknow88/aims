<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Modules\DocumentSystem\Entities\JsaDocument;

class JsaDocumentNumberRule implements Rule
{
    public $id;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id;
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
        $query = JsaDocument::select('id')
            ->where('document_number', $value)
            ->where('status', JsaDocument::ACTIVE);
        if ($this->id) {
            $query->where('id', '!=', $this->id);
        }
        $check = $query->count();
        if ($check > 0) {
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
        return 'The :attribute already registered in database';
    }
}
