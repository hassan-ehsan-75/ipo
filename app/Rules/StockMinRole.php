<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class StockMinRole implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public $min_stock;
    public function __construct($min_stock)
    {
        $this->min_stock=$min_stock;
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
        return $this->min_stock<=$value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'عدد الاسهم المراد الاكتتاب عليها اقل من العدد الادني';
    }
}
