<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankBranch extends Model
{
    protected $fillable = ['name','respon_person','bank_id'];

    public function bank(){
        return $this->belongsTo(Bank::class,'bank_id','id');
    }

    public function user(){
        return $this->belongsTo(User::class,'id','branch_id');
    }

    public function stockCount($branch){

    }

}
