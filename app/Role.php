<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function websiteRoles(){
        return $this->belongsToMany(WebsiteRole::class);
    }
    public static function getRolesGroups(){
        return Role::groupBy('group')->get();
    }
    public static function hasRole($user_id,$role_name){
        $roles = UserRole::where('user_id','=',$user_id)
        ->join('website_roles','user_roles.role_id','=','website_roles.id')
        ->get();
        foreach($roles as $role)
            if($role_name == $role->role_name)
                return true;
        return false;
    }
}
