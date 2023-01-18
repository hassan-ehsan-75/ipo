@extends('layouts.new')
@section('title','معاينة البنك')
@section('content')
<div class="container-fluid">
<div class="row">
        <div class="col-md-12">
            <h1 class="text-center">معاينة بنك</h1>
        </div>
    </div>
<div class="container shadow" style="margin-top: 20px;padding-top:15px">
    <div class="row">
        <div class="col-md-4">
            <h5 class="text-center">الاسم بالانكليزية</h5>
            <p class="text-center">{{$bank->en_name}}</p>
        </div>
        <div class="col-md-4">
            <h5 class="text-center">الاسم بالعربيه</h5>
            <p class="text-center">{{$bank->ar_name}}</p>
        </div>
        <div class="col-md-4">
            <h5 class="text-center">رمز البنك</h5>
            <p class="text-center">{{$bank->code}}</p>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
        <h5 class="text-center">معلومات الاتصال</h5>
            <p class="text-center">{{$bank->contact}}</p>
        </div>
    </div>
</div>
</div>
@endsection