<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personalization extends Model
{
    protected $guarded=[];
    public $timestamps=false;
    protected $with=['stock'];

    public function stock(){
        return $this->belongsTo(Stock::class,'stock_id','id')->with(['bank','user']);
    }
}
