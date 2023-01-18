@extends('layouts.new')
@section('title','معاينة المستخدم')
@section('content')
<div class="contaienr-fluid">
    <div class="container col-md-4">
        <h1 class="text-center">معاينة المستخدم</h1>
    </div>
    <div class="container col-md-5 shadow" style="margin-top: 15px;padding-top:15px;padding-bottom:15px">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <img src="{{url($user->avatar)}}" class="img-thumbnail profile-img" style="width:100%;height:auto"/>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12 text-center">
            <h3 class="text-center">{{$user->name}}</h3>
            </div>
        </div>
        <hr>
        <div class="container">
            <p><i class="fa fa-envelope"></i> {{$user->email}}</p>
            <p><i class="fa fa-bank"></i>
            @if($user->bank_id != null)
                {{$user->bank->ar_name}}
            @else
                لايوجد
            @endif
            </p>
            <p><i class="fa fa-bank"></i>
            @if($user->branch_id != null)
                {{$user->branch->name}}
            @else
                لايوجد
            @endif
            </p>
            <p><i class="fa fa-user"></i>
                {{$user->role->display_name}}
            </p>
        </div>
    </div>
</div>
@endsection