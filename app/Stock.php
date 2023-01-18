<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $guarded = ['created_at','updated_at'];
    public $counts;
    public function company(){
        return $this->belongsTo(Company::class,'company_id','id');
    }
    public function bank(){
        return $this->belongsTo(Bank::class,'bank_id','id');
    }
    public function activeStock(){
        return $this->hasOne(ActiveStock::class,'stock_id','id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id','id')->with('branch');
    }

    public function getRouteKeyName()
    {
        return 'id';
    }
}
