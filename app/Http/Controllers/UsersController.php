<?php

namespace App\Http\Controllers;

use App\Bank;
use App\BankBranch;
use App\Helpers\UploadFile;
use App\Http\Controllers\Controller;
use App\User;
use App\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use TCG\Voyager\Models\Role;

class UsersController extends Controller{
    public function index(){
        if (isset($_GET['search']) && $_GET['search']!=''){
            $users = User::with(['role','bank','role'])->where('name','like','%'.$_GET['search'].'%')->paginate(10
            );
        }else
        $users = User::with(['role','bank','role'])->paginate(10);

        return view('users.users',['users'=>$users]);
    }
    public function show($id){
        $user = User::with(['bank','branch','role'])->find($id);
        return view('users.show',['user'=>$user]);
    }
    public function profile(){
        $user = User::with(['bank','branch','role'])->find(auth()->user()->id);
        return view('users.prfile',['user'=>$user]);
    }
    public function loginPage(){
        return view('auth.login');
    }
    public function registerPage(){
        $roles = Role::all();
        return view('auth.register',['roles'=>$roles]);
    }
    public function register(){
        $attr = request()->validate(
            [
                'name'=>'required|max:255',
                'email'=>'required|email|unique:users,email',
                'password'=>'required|min:8|max:256',
                'role_id'=>'required'
            ]
        );
        $attr['password'] = bcrypt($attr['password']);
        
        $user = User::create($attr);
        //Auth::login($user);
        return back()->with(['success'=>"تم إنشاء الحساب بنجاح"]);
        

    }
    public function login(){
        $attr = request()->validate(
            [
            'email'=>'required|email|max:255',
            'password'=>'required|max:255'
            ]   
        );
        //$attr['password'] = bcrypt($attr['password']);
        if(Auth::attempt($attr)){
            if (auth()->user()->pass_updated!=0)
            return redirect('/home')->with('success');
            else{
                return redirect('/users/profile')->with(['error'=>'الرجاء تغير كلمة المرور']);
            }
        }
        return back()->withErrors(['error'=>'خطأ في الايميل او كلمة المرور']);
        }
    public function logout(){
        Auth::logout();
        return redirect('/home');
    }
    public function edit($id){
        $user = User::find($id);
        $banks = Bank::all();
        if($user->bank_id==null)
        $branches = BankBranch::where('bank_id',$banks->first()->id)->get();
        else
            $branches = BankBranch::where('bank_id',$user->bank_id)->get();
        $roles= Role::all();
        return view('users.update',['user'=>$user,'banks'=>$banks,'branches'=>$branches,'roles'=>$roles]);
    }
    public function update($id,Request $request){
        $this->validate($request,[
            'name'=>'required|max:255',
            'bank_id'=>'required',
            'role_id'=>'required',
            'avatar'=>'nullable|max:10000|mimes:jpeg,jpg,png,pdf,doc,docx,svg,webp',
        ]);
        $user = User::find($id);
        $user->update($request->except(['avatar','new_password']));
        if($request->hasFile('avatar'))
            {
                if(File::exists(public_path($user->avatar))){
                    File::delete(public_path($user->avatar));
                }
                $filename = time().'.'.$request->avatar->extension();
                $user->avatar = $request->avatar->move('images/users',$filename);
            }
            if ($request->new_password){
                $user->password=bcrypt($request->new_password);
            }

        $user->save();
        return back()->with(['success'=>'تم التعديل بنجاح']);
    }
    public function destroy($id){
        $user = User::find($id);
        if(File::exists(public_path($user->avatar))){
            File::delete(public_path($user->avatar));
        }
        $user->delete();
        return redirect('/users')->with(['success'=>'تم حذف المستخدم بنجاح']);
    }
    public function changePass(Request $request){
        $this->validate($request,[
           'password'=>'required',
            'new_password'=>'required|min:8'
        ]);
        if(Hash::check($request->password,auth()->user()->password)){
            auth()->user()->password=bcrypt($request->new_password);
            auth()->user()->pass_updated=1;
            auth()->user()->save();
            return back()->with(['success'=>'تم التعديل بنجاح']);
        }else{
            return back()->with(['error'=>'كلمة المرور القديمة خاطئة']);
        }
    }
}