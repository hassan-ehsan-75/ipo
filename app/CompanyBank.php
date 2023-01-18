<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyBank extends Model
{
    protected $fillable=['bank_id','company_id'];

    public function bank(){
        return $this->belongsTo(Bank::class,'bank_id','id');
    }
    public function company(){
        return $this->belongsTo(Bank::class,'company_id','id');
    }
}
