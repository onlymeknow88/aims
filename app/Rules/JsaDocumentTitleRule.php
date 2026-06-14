<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Modules\DocumentSystem\Entities\JsaDocument;

class JsaDocumentTitleRule implements Rule
{
    public $current_id;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($current_id)
    {
        $this->current_id = $current_id;
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
        if ($this->current_id) {
            $check = JsaDocument::where('status', JsaDocument::ACTIVE)
                ->where('title', $value)
                ->find($this->current_id);
            if ($check) {
                $res = false;
            }
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
        return 'The :attribute is already exist in database';
    }
}
