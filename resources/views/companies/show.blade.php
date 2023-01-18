@extends('layouts.new')
@section('title','معاينة الشركة')
@section('content')
<div class="container-fluid">
    <div class="container col-md-3">
        <h1>معاينة الشركة</h1>
    </div>
    <div class="container col-md-6">
        <div class="row text-center justify-content-md-center">
        @if(Auth::User()->hasRole('update_company'))
            <div class="col-md-4 text-center">
                <a type="button" href="{{url('/companies/edit',$company->id)}}" class="btn btn-primary-big"><i class="fa fa-edit"></i> تعديل</a>
            </div>
            @endif
            @if(Auth::User()->hasRole('delete_company'))
            <div class="col-md-3 text-center">
                <a type="button" class="btn btn-danger-big"><i class="fa fa-trash"></i> حذف</a>
            </div>
            @endif
            <div class="col-md-5 text-center">
                <a href="{{url('/companies')}}" type="button" class="btn btn-default-big"><i class="fa fa-list"></i> عودة إلى القائمة</a>
            </div>
        </div>
    </div>
    <div class="container shadow" style="margin-top: 25px;padding-top:15px">
        <div class="row">
            <div class="col-md-4">
                <h5 class="text-center">اسم الشركة بالعربي</h5>
                <p class="text-center">{{ $company->ar_name }}</p>
            </div>
            <div class="col-md-4">
                <h5 class="text-center">اسم الشركة بالانكليزية</h5>
                <p class="text-center"> {{$company->en_name}} </p>
            </div>
            <div class="col-md-4">
                <h5 class="text-center">رمز الشركة</h5>
                <p class="text-center"> {{$company->code}} </p>
            </div>
        </div>
        <hr>

        <div class="row text-center">
            <div class="col-md-6 text-center">
                <h5 class="text-center">رقم الهاتف1</h5>
                <p class="text-center"> {{$company->phone1}} </p>
            </div>
            <div class="col-md-6">
                <h5 class="text-center">رقم الهاتف2</h5>
                <p class="text-center"> {{$company->phone2}} </p>
            </div>
        </div>
<hr>
        <div class="row">
            <div class="col-md-6">
                <h5 class="text-center">رأس المال</h5>
                <p class="text-center">{{ $company->capital }}</p>
            </div>
            <div class="col-md-6">
                <h5 class="text-center">رقم الترخيص</h5>
                <p class="text-center"> {{$company->license}} </p>
            </div>
        </div>

        <hr>
        <div class="row">
            <div class="col-md-6">
                <h5 class="text-center">العنوان</h5>
                <p class="text-center"> {{$company->address}} </p>
            </div>
            <div class="col-md-6">
                <h5 class="text-center">نشاط الشركة</h5>
                <p class="text-center">{{$company->section}}</p>
            </div>
        </div>

        <hr>
        <div class="row">
            <div class="col-md-6">
                <h5 class="text-center">عقد تأسيس</h5>
                <p class="text-center"><a target="_blank" href="{{asset('storage/'.$company->foundation)}}">تحميل</a></p>
            </div>
            <div class="col-md-6">
                <h5 class="text-center">نظام أساسي</h5>
                <p class="text-center"><a target="_blank" href="{{asset('storage/'.$company->system)}}">تحميل</a></p>
            </div>
        </div>

        <hr>
        <div class="row">
            <div class="col-md-12">
            <h5 class="text-center">أسماء المؤسسين</h5>
            <p class="text-center">{!!$company->founders_list!!}</p>
            </div>
        </div>

        <hr>
        <div class="row">
            <div class="col-md-3">
                <h5 class="text-center">إعلان الطرح</h5>
                <p class="text-center truncate"><a target="_blank" href="{{asset('storage/'.$company->ad)}}">تحميل</a></p>
            </div>
            <div class="col-md-3">
                <h5 class="text-center">نشرة الاصدار</h5>
                <p class="text-center truncate"><a target="_blank" href="{{asset('storage/'.$company->version)}}">تحميل</a></p>
            </div>
            <div class="col-md-3">
                <h5 class="text-center">بيان مصاريف الإصدار</h5>
                <p class="text-center truncate"><a target="_blank" href="{{asset('storage/'.$company->version_spend)}}">تحميل</a></p>
            </div>
            <div class="col-md-3">
                <h5 class="text-center">نظام داخلي</h5>
                <p class="text-center truncate"><a target="_blank" href="{{asset('storage/'.$company->enner_system)}}">تحميل</a></p>
            </div>
        </div>

        <hr>
        <div class="row">
            <div class="col-md-6">
                <h5 class="text-center">بيان بالحصص</h5> 
                <p class="text-center"> {{$company->share_report}} </p>
            </div>
            <div class="col-md-6">
                <h5 class="text-center">الحد الادنى لعدد الاسهم</h5> 
                <p class="text-center">{{$company->min_stock}}</p>
            </div>
        </div>

        <hr>
        <div class="row">
            <div class="col-md-4">
                <h5 class="text-center">تاريخ بداية الاكتتاب</h5>
                <p class="text-center">{{$company->start_date}}</p>
            </div>
            <div class="col-md-4">
                <h5 class="text-center">تاريخ نهاية الاكتتاب</h5>
                <p class="text-center">{{$company->end_date}}</p>
            </div>
            <div class="col-md-4">
                <h5 class="text-center">created at</h5>
                <p class="text-center">{{$company->created_at}}</p>
            </div>
        </div>

        <hr>
        <div class="row">
            <div class="col-md-6">
                <h5 >البنوك المشاركة</h5>
                <ul >
                    @foreach($banks as $bank)
                    <li>{{$bank->ar_name}}</li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-6">
                <h5 >أفرع البنوك</h5>
                <ul>
                    @foreach($branches as $branch)
                    <li>{{$branch->name}}(
                        @foreach($banks as $bank)
                            @if($branch->bank_id==$bank->id)
                                {{$bank->ar_name}}
                                @endif
                            @endforeach
                    )</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection