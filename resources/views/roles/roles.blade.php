@extends('layouts.new')
@section('title','الصلاحيات') 
@section('content')
<div class="container-fluid" style="padding-top: 25px; text-align:center">
<div class="container col-md-4" style="text-align: center;">
<h2 style="text-align: center;">الصلاحيات</h2><Br>
<div class="row justify-content-center">
    @if(Auth::User()->hasRole('create_role'))
    <div class="col-md-12 text-center">
        <a type="button" href="{{url('/roles/create')}}" class="btn btn-default-big"><i class="fa fa-plus-circle"></i> إضافة جديد</a>
    </div>
    @endif
</div>
</div>
<div class="container shadow" style="margin-top: 15px;padding-top:15px;padding-bottom:15px">
<div class="container col-md-5">
    {{--<div style="display: inline-block;width:50%">--}}
    {{--<p>--}}
    {{--<label><strong>عرض</strong></label>--}}
    {{--<select class="form-control" style="width:50%;display:inline-block">--}}
        {{--<option>10</option>--}}
    {{--</select>--}}
    {{--<label><strong>عنصر</strong></label>--}}
    {{--</p>--}}
{{--</div>--}}
    <div  style="display: inline-block;width:100%;text-align:center">

        <label>بحث</label>
        <form style="display: inline-block;" method="GET" action="{{url('/roles')}}">
            <input type="text" class="option-control" name="search" value="{{request('search')}}">
            <button type="submit" class="btn btn-secondary option-control mb-1">ابحث</button>
        </form>
    </div>
</div>

<div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Display Name</th>
                    <th>الاجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $role)
                <tr>
                    <td>{{ $role->name }}</td>
                    <td>{{$role->display_name}}</td>
                    <td>
                    @if(Auth::User()->hasRole('update_role'))
                        <a type="button" class="btn btn-primary" href="{{url('/roles/edit',$role->id)}}"><i class="fa fa-edit"></i> تعديل</a>
                         @endif
                        @if(Auth::User()->hasRole('delete_role'))
                        <form action="{{url('/roles/destroy',$role->id)}}" method="post" style="display: inline-block;">
                            @csrf
                            {{method_field('DELETE')}}
                            <BUTTON type="submit"  class="btn btn-danger" style="margin:5px"><i class="fa fa-trash"></i> حذف</BUTTON>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="container col-md-4" style="padding-bottom: 25px;">
    <nav>
    
</nav>
    </div>
</div>
</div>
@endsection