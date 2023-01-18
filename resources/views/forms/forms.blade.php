@extends('layouts.new')
@section('title','نماذج')
@section('content')
<div class="container-fluid" style="padding-top: 25px; text-align:center">
<div class="container col-md-4" style="text-align: center;">
<h2 style="text-align: center;">النماذج</h2><Br>
@if(Auth::User()->hasRole('create_form'))
    <div style="display: inline-block;">
        <a type="button" href="{{url('/forms/create')}}" class="btn btn-default-big"><i class="fa fa-plus-circle"></i> إضافة جديد</a>
    </div>
    @endif
</div>
<div class="container shadow" style="margin-top: 15px;">
<div class="container col-md-5">
    {{--<div style="display: inline-block;width:50%;">--}}
    {{--<label>الفرز</label>--}}
    {{--<select class="option-control">--}}
    {{--<option>1</option>--}}
    {{--</select>--}}
    {{--</div>--}}
    <div  style="display: inline-block;width:100%;text-align:center">

        <label>بحث</label>
        <form style="display: inline-block;" method="GET" action="{{url('/forms')}}">
            <input type="text" class="option-control" name="search" value="{{request('search')}}">
            <button type="submit" class="btn btn-secondary option-control mb-1">ابحث</button>
        </form>
    </div>
</div>
<div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>العنوان</th>
                    <th>الملف</th>
                    <th>الاجراءات</th>
                </tr>
            </thead>
            <tbody>
            @foreach($forms as $form)
                <tr>
                    <td>{{$form->name}}</td>
                    <td><a href="{{asset('storage/'.$form->file)}}" download>تحميل</a></td>
                    <td><div class="dropdown">
  <a type="button" class="dropdown-toggle" data-toggle="dropdown">
  الإجراءات
</a>
  <div class="dropdown-menu" style="text-align: right;">
  @if(Auth::User()->hasRole('view_form'))
                        <a  class="dropdown-item" href="{{url('/forms/show',$form->id)}}" class="btn btn-default" style="margin:5px"><i class="fa fa-eye"></i> معاينة</a>
                        @endif
                        @if(Auth::User()->hasRole('update_form'))
                        <a class="dropdown-item" href="{{url('/forms/edit',$form->id)}}" class="btn btn-primary" style="margin:5px"><i class="fa fa-edit"></i> تعديل</a>
                        @endif
                        @if(Auth::User()->hasRole('delete_form'))
                        <form action="{{url('/forms/destroy',$form->id)}}" method="post">
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
    {{$forms->links()}}
</nav>
    </div>
</div>
</div>
@endsection