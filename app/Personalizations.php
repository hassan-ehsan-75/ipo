<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personalizations extends Model
{

    protected $guarded=[];
    protected $table='personalizationss';
    public $timestamps=false;
    protected $with=['stock'];

    public function stock(){
        return $this->belongsTo(Stock::class,'stock_id','id')->with(['bank','user']);
    }
}
