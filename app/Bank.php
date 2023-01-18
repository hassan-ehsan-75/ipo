<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
   protected $fillable = [
       'en_name','ar_name','code','contact','created_at','updated_at'
   ];
   public function branches(){
       return $this->hasMany(BankBranch::class);
   }
   
}
