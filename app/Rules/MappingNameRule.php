<?php

namespace App\Rules;

use App\Models\DocumentSystem\Mapping;
use Illuminate\Contracts\Validation\Rule;

class MappingNameRule implements Rule
{
    public $category_id;
    public $id;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($category_id = null, $id = null)
    {
        $this->category_id = $category_id;
        $this->id = $id;
    }

    /**
     * Determine if the validation rule passes.
     * if failed, then return false
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $res = true;
        $query = new Mapping();
        if ($this->id) {
            $query = Mapping::find($this->id);
        }
        if ($this->category_id) {
            $data = $query->where('name', $value)
                ->where('category_id', $this->category_id)
                ->first();
            if ($data) {
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
        return 'The :attribute field is already exist in database';
    }
}
