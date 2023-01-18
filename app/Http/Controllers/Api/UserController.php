<?php

namespace App\Http\Controllers\Api;


use App\Helpers\SendMessage;
use App\Helpers\UploadImage;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{


    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|min:4|max:45',
            'password' => 'required|min:8|max:45',
        ]);
        if ($validator->fails()) {
            return SendMessage::error(301, null, $validator->errors()->first());
        }
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $user->api_token = $user->createToken('api_token')->accessToken;
            $user->save();
            return SendMessage::success(302, auth()->user(), "تم تسجيل ادخول بنجاح");
        } else {
            return SendMessage::error(303, null, "رقم الهاتف او كلمة السر غير صحيحة");
        }
    }


    public function register(Request $request){
        $validator = Validator::make($request->all(),[
            'mobile'=>'required|min:10|max:10|unique:users',
            'password'=>'required|min:8|max:100',
            'first_name'=>'required|min:2|max:100',
            'last_name'=>'required|min:2|max:100',
            'birthday'=>'required|min:2|max:100',
            'gender'=>'required|min:2|max:100',

        ]);
        if ($validator->fails()) {
            return SendMessage::error(304, null, $validator->errors()->first());
        }
        $request['password']=Hash::make($request->password);
        $request['role_id']=2;


        $data=$request->except('first_name','last_name','password_confirmation');
        $data['name']=$request->first_name.' '.$request->last_name;
        $user=User::create($data);


        $user->api_token = $user->createToken('api_token')->accessToken;

        $user->save();
        Auth::guard('api');
        Auth::login($user);
        return SendMessage::success(305, auth()->user(), "تم انشاء الحساب بنجاح");

    }
    public function updateProfile(Request $request){

        $validator = Validator::make($request->all(), [
            'mobile'=>'required|min:10|max:10|unique:users,mobile,'.auth()->user()->id,
            'first_name'=>'required|min:2|max:100',
            'last_name'=>'required|min:2|max:100',
            'birthday'=>'required|min:2|max:100',
            'gender'=>'required|min:2|max:100',

        ]);
        if ($validator->fails()) {
            return SendMessage::error(306, null, $validator->errors()->first());
        }

//        if($request->old_password!=null&&$request->password!=null) {
//            $validator = Validator::make($request->all(), [
//                'old_password' => 'required',
//                'password' => 'required|min:8|max:100|different:old_password'
//            ]);
//            if ($validator->fails()) {
//                return SendMessage::error(307, null, $validator->errors()->first());
//            }
//            if (Hash::check($request->old_password, auth()->user()->password)) {
//                auth()->user()->password=Hash::make($request->password);
//                auth()->user()->save();
//            }else{
//                return SendMessage::error(308, null, 'password not match');
//            }
//        }
        if($request->hasFile('image')){
            Storage::disk(config('voyager.storage.disk'))->delete(auth()->user()->avatar);
            auth()->user()->avatar=UploadImage::upload($request->file('image'),'users');
        }
        auth()->user()->name=$request->first_name.' '.$request->last_name;
        auth()->user()->mobile=$request->mobile;
        auth()->user()->save();
        return SendMessage::success(307,null,'updated successfullly');

    }
}
