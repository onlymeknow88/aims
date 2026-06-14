<?php

namespace App\Rules;

use App\Models\DocumentSystem\Category;
use Illuminate\Contracts\Validation\Rule;

class CategoryNameRule implements Rule
{
    public $module_id;
    public $id;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($module_id = null, $id = null)
    {
        $this->module_id = $module_id;
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
        $query = new Category();
        if ($this->id) {
            $query = Category::find($this->id);
        }
        if ($this->module_id) {
            $data = $query->where('name', $value)
                ->where('module_id', $this->module_id)
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
