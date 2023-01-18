<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyBankBranch extends Model
{
    protected $fillable=['bank_branch_id','company_id'];

    public function branch(){
        return $this->belongsTo(BankBranch::class,'bank_branch_id','id');
    }
    public function company(){
        return $this->belongsTo(Bank::class,'company_id','id');
    }
}
