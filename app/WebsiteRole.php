<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebsiteRole extends Model
{
    protected $table='website_roles';
    public function users(){
        return $this->belongsToMany(Role::class);
    }
    public function hasRole($user_id,$role_name){
        $roles = UserRole::where('user_id','=',$user_id)
        ->join('website_Roles','user_roles.role_id','=','website_roles.id')
        ->get();
        foreach($roles as $role)
            if($role_name == $role->role_name)
                return true;
        return false;
    }
}
