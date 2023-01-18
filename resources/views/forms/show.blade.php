@extends('layouts.new')
@section('title','معاينة')
@section('content')
<div class="container-fluid">
    <div class="container">
        <h1 class="text-center">معاينة النموذج</h1>
    </div>
    <div class="container col-md-8 shadow">
        <div class="row">
            <div class="col-md-6">
                <h5 class="text-center">الاسم</h5>
                <p class="text-center">{{$form->name}}</p>
            </div>
            <div class="col-md-6">
                <h5 class="text-center">الملف</h5>
                <p class="text-center"><a href="{{asset($form->file)}}" download>تحميل</a></p>
            </div>
        </div>
    </div>
</div>
@endsection