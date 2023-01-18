<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\UserRole;
use App\WebsiteRole;
use Illuminate\Http\Request;
use TCG\Voyager\Models\Role;
use TCG\Voyager\Models\User;

class RolesController extends Controller{
    public function index(){

        if (isset($_GET['search']) && $_GET['search']!=''){
            $roles = Role::where('name','like','%'.$_GET['search'].'%')->orWhere('display_name','like','%'.$_GET['search'].'%')->get();
        }else
        $roles = Role::all();
        return view('roles.roles',['roles'=>$roles]);
    }
    public function edit($id){
        $roles = WebsiteRole::all()->groupBy('group');
        
        return view('roles.edit',['roles'=>$roles,'id'=>$id]);
    }
    public function update(Request $request,$id){
        //echo $request->roles;
        UserRole::where('user_id','=',$id)->delete();
        foreach($request->roles as $role)
            UserRole::create(['user_id'=>$id,'role_id'=>$role]);
        return back()->with(['success'=>'تم تعديل الصلاحيات بنجاح']);
    }
    public function create(){
        $roles = WebsiteRole::all()->groupBy('group');
        
        return view('roles.create',['roles'=>$roles]);
    }
    public function store(Request $request){
        $this->validate($request,[
            'name'=>'required|max:255',
            'display_name'=>'required|max:255',
            'roles'=>'array|min:1'
        ]);
        $role = Role::create($request->except('roles'));
        foreach($request->roles as $rl)
            UserRole::create(['user_id'=>$role->id,'role_id'=>$rl]);
        return back()->with(['success'=>'تمت الإضافة بنجاح']);
    }
    public function destroy($id){
        $role = Role::find($id);
        $userRoles = UserRole::where('user_id','=',$id)->get();
        foreach($userRoles as $ur)
            $ur->delete();
        $role->delete();
        return back()->with(['success'=>'تمت الإزالة بنجاح']);
    }
}