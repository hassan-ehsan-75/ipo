@extends('layouts.new')
@section('title','معاينة البنك')
@section('content')
<div class="container-fluid">
    <div class="container col-md-5">
        <h1 class="text-center">معاينة البنك</h1>
    </div>
    <div class="container shadow" style="margin-top: 15px;padding-top:15px;padding-bottom:15px">
        <div class="row">
            <div class="col-md-4">
                <strong>اسم الفرع</strong>
                <p>{{$branch->name}}</p>
            </div>
            <div class="col-md-4">
                <strong>الشخص المسؤول</strong>
                <p>{{$branch->respon_person}}</p>
            </div>
            <div class="col-md-4">
                <strong>البنك</strong>
                <p>{{$branch->bank->ar_name}}</p>
            </div>
        </div>
    </div>
</div>
@endsection