@extends('layouts.new')
@section('title','المستخدمين')
@section('content')
    <div class="container-fluid" style="padding-top: 25px; text-align:center">
        <div class="container justify-content-center" style="text-align: center;">
            <h2 style="text-align: center;">المستخدمين</h2><Br>
            <div class="row justify-content-center">
                @if(Auth::User()->hasRole('create_user'))
                    <div class="col-md-2">
                        <a type="button" href="{{url('/register')}}" class="btn btn-default-big"><i
                                    class="fa fa-plus-circle"></i> إضافة جديد</a>
                    </div>
                @endif
            </div>
        </div>
        <div class="container shadow" style="margin-top: 15px;">
            <div class="container col-md-5">
                <div style="display: inline-block;width:100%;text-align:center">

                    <label>بحث</label>
                    <form style="display: inline-block;" method="GET" action="{{url('/users')}}">
                        <input type="text" class="option-control" name="search" value="{{request('search')}}">
                        <button type="submit" class="btn btn-secondary option-control mb-1">ابحث</button>
                    </form>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>الاسم</th>
                        <th>البريد الالكتروني</th>
                        <th>تاريخ الانشاء</th>
                        <th>صوره</th>
                        <th>الدور</th>
                        <th>البنك</th>
                        <th>فرع البنك</th>
                        <th>الاجراءات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->created_at}}</td>
                            <td><img src="{{url($user->avatar)}}" width="75px"/></td>
                            <td>{{$user->role->display_name}}</td>
                            <td>
                                @if($user->bank != null)
                                    {{$user->bank->ar_name}}
                                @else
                                    لايوجد
                                @endif
                            </td>
                            <td>
                                @if($user->branch != null)
                                    {{$user->branch->name}}
                                @else
                                    لايوجد
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <a type="button" class="dropdown-toggle" data-toggle="dropdown">
                                        الإجراءات
                                    </a>
                                    <div class="dropdown-menu" style="text-align: right;">
                                        @if(Auth::User()->hasRole('view_user'))
                                            <a class="dropdown-item" href="{{url('/users/show',$user->id)}}"
                                               class="btn btn-default" style="margin:5px"><i class="fa fa-eye"></i>
                                                معاينة</a>
                                        @endif
                                        @if(Auth::User()->hasRole('update_user'))
                                            <a class="dropdown-item" href="{{url('/users/edit',$user->id)}}"
                                               class="btn btn-primary" style="margin:5px"><i class="fa fa-edit"></i>
                                                تعديل</a>
                                        @endif
                                        @if(Auth::User()->hasRole('delete_user'))
                                            <form action="{{url('/users/destroy',$user->id)}}" method="post">
                                                @csrf
                                                {{method_field('DELETE')}}
                                                <BUTTON type="submit" class="dropdown-item" style="margin:5px"><i
                                                            class="fa fa-trash"></i> حذف
                                                </BUTTON>
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
                    {{$users->links()}}
                </nav>
            </div>
        </div>
    </div>
@endsection