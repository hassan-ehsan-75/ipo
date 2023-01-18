<?php

namespace App\Rules;

use App\CompanyBankBranch;
use App\User;
use Illuminate\Contracts\Validation\Rule;

class StockBranchRole implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public $company_id;
    public function __construct($company_id)
    {
        $this->company_id=$company_id;
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

        if (auth()->user()->role_id!=1) {
            $companyB = CompanyBankBranch::where('bank_branch_id', auth()->user()->branch->id)
                ->where('company_id', $this->company_id)->first();
             return $companyB != null;


        }elseif(request()->branch_id){

            $u=User::find(request()->branch_id);
            $companyB=null;
            if ($u!=null) {
                $companyB = CompanyBankBranch::where('bank_branch_id', $u->branch_id)
                    ->where('company_id', $this->company_id)->first();
            }
            return $companyB != null;
        }
        return true;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'هذا الفرع غير مشارك بالاكتتاب';
    }
}
