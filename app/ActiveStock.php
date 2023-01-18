<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActiveStock extends Model
{
    protected $guarded=[];

    public function stock(){
        return $this->belongsTo(Stock::class,'stock_id','id');
    }
}
