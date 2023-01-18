@extends('layouts.new')
@section('title','تعديل الصلاحيات')
@section('content')
    <div class="container-fluid">
        <div class="container col-md-5">
            <h1 class="text-center">تعديل الصلاحيات</h1>
        </div>
        @if(session()->has('success'))
            <div class="form-group text-center">
                <label class="alert alert-success">{{ session()->get('success')}}</label>
            </div>
        @endif

        @if(count($errors)>0)
            <div class="form-group text-center">
                <label class="alert alert-danger">{{ $errors->first()}}</label>
            </div>
        @endif
        <div class="container shadow" style="margin-top: 15px;padding-top:15px;padding-bottom:15px">
            <form method="POST" action="{{url('/roles/update').'/'.$id}}">
                @csrf
                <div class="row">
                    @foreach($roles as $role)
                        <div class="col-md-4">
                            <strong>{{$role[0]['group']}}</strong>
                            @foreach($role as $item)
                                <p>
                                    <input  type="checkbox" name="roles[]"
                                           @if(Auth::User()->hasRoleName($id,$item->role_name)) checked="checked"
                                           @endif value="{{$item->id}}"> {{$item->display_name}}
                                </p>
                            @endforeach
                        </div>
                    @endforeach
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary-big">حفظ</button>
                </div>
            </form>
        </div>
    </div>
@endsection