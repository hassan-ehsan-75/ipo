<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class StockMaxRole implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public $stocks;
    public function __construct($stocks)
    {
        $this->stocks=$stocks;
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
        return $value<=12250000;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'عدد الاسهم المراد الاكتتاب عليها اكبر من العدد المطروح';
    }
}
