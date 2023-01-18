<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends \TCG\Voyager\Models\User
{
    use Notifiable,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
       protected $guarded=[];
        protected $fillable=['name','email','role_id','bank_id','branch_id','password'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','email_verified_at','settings'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function hasRole($name)
    {
        $roles = UserRole::where('user_id','=',$this->role_id)
        ->join('website_roles','user_roles.role_id','=','website_roles.id')
        ->where('website_roles.role_name',$name)
        ->first();
//         dd($roles);
            if($roles!=null)
                return true;
        return false;
    }
    public static function hasRoleName($user_id,$role_name){
        $roles = UserRole::where('user_id','=',$user_id)
        ->join('website_roles','user_roles.role_id','=','website_roles.id')
        ->get();
        
        foreach($roles as $role)
            if($role_name == $role->role_name)
                return true;
        return false;
    }
    public function getUserRoles(){
        $roles = UserRole::where('user_id','=',$this->role_id)
        ->join('website_roles','user_roles.role_id','=','website_roles.id')
        ->get();
        return $roles;
    }
    function role(){
        return $this->belongsTo(Role::class);
    }
    public function bank(){
        return $this->belongsTo(Bank::class);
    }
    public function branch(){
        return $this->belongsTo(BankBranch::class);
    }
 }
