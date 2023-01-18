<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $fillable = ['user_id','role_id'];

    public static function getUserRoles($user){
        return UserRole::all()->where('user_id','=',$user->id);
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
    public static function getRoles($id){
        return UserRole::all()->join('roles','roles.id','=',$id);
    }
    public static function addUserRoles($user_id,$role_id){
        UserRole::create(['user_id'=>$user_id,'role_id'=>$role_id]);
    }
    public function user(){
        return $this->belongsTo(Role::class,'user_id','id');
    } 
    public function role(){
        return $this->belongsTo(WebsiteRole::class,'role_id','id');
    }
}
