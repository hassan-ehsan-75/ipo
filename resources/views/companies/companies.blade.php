@extends('layouts.new')
@section('title','الشركات')

@section('content')
<div class="container col-md-4" style="text-align: center;">
<h2 style="text-align: center;">شركات</h2><Br>
@auth
    @if (Auth::User()->hasRole('create_company'))
    <div style="display: inline-block;">
        <a type="button" href="{{url('/companies/create')}}" class="btn btn-default-big"><i class="fa fa-plus-circle"></i> إضافة جديد</a>
    </div>
    @endif
    {{--@if(Auth::User()->hasRole('delete_company'))--}}
    {{--<div style="display: inline-block;">--}}
        {{--<button type="button" class="btn btn-danger-big"><i class="fa fa-trash"></i> حذف متعدد</button>--}}
    {{--</div>--}}
    {{--@endif--}}
    @if(session()->has('success'))
        <div class="form-group text-center mt-1">
            <label class="alert alert-success">{{ session()->get('success')}}</label>
        </div>
    @endif

@endif
</div>
<div class="container shadow" style="padding-top: 25px;margin-top: 30px;">
    {{--<div style="display: inline-block;width:50%;">--}}
        {{--<label>الفرز</label>--}}
        {{--<select class="option-control">--}}
            {{--<option>1</option>--}}
        {{--</select>--}}
    {{--</div>--}}
    <div  style="display: inline-block;width:100%;text-align:center">

        <label>بحث</label>
        <form style="display: inline-block;" method="GET" action="{{url('/companies')}}">
        <input type="text" class="option-control" name="search" value="{{request('search')}}">
            <button type="submit" class="btn btn-secondary option-control mb-1">ابحث</button>
        </form>

</div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>اسم الشركة بالانكليزية</th>
                    <th>رقم الهاتف</th>
                    <th>العنوان</th>
                    <th>نشاط الشركة</th>
                    <th>الحد الادنى لعدد الاسهم</th>
                    <th>تاريخ بداية الاكتتاب</th>
                    <th>تاريخ نهاية الاكتتاب</th>
                    <th>الاجراءات</th>
                </tr>
            </thead> 
            <tbody>
            @foreach($companies as $company)
                <tr>
                    <td>{{$company->en_name}}</td>
                    <td>{{$company->phone1}}</td>
                    <td>{{$company->address}}</td>
                    <td>{{$company->section}}</td>
                    <td>{{$company->min_stock}}</td>
                    <td>{{$company->start_date}}</td>
                    <td>{{$company->end_date}}</td>
                    <td>
                    <div class="dropdown">
  <a type="button" class="dropdown-toggle" data-toggle="dropdown">
  الإجراءات
</a>
  <div class="dropdown-menu" style="text-align: right;">
  @if(Auth::User()->hasRole('view_company'))
                        <a  class="dropdown-item" href="{{url('/companies/show',$company->id)}}" class="btn btn-default" style="margin:5px"><i class="fa fa-eye"></i> معاينة</a>
                        @endif
                        @if(Auth::User()->hasRole('update_company'))
                        <a class="dropdown-item" href="{{url('/companies/edit',$company->id)}}" class="btn btn-primary" style="margin:5px"><i class="fa fa-edit"></i> تعديل</a>
                        @endif
                        @if(Auth::User()->hasRole('delete_company'))
                        <form action="{{url('/companies/destroy',$company->id)}}" method="post">
                            @csrf
                            {{method_field('DELETE')}}
                            <BUTTON type="submit"  class="dropdown-item" style="margin:5px"><i class="fa fa-trash"></i> حذف</BUTTON>
                        </form>
                        @endif
  </div>
</div>
                        

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="container col-md-4" style="padding-bottom: 25px;">
    <nav>
    {{ $companies->links() }}
</nav>
    </div>
</div>

@endsection