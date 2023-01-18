@extends('layouts.new')
@section('title','تعديل المستخدم')
@section('content')
<div class="container-fluid">
    <div class="container">
        <h1 class="text-center">تعديل المستخدم</h1>
    </div>
    <div class="container shadow" style="margin-top: 15px;padding-top:15px">
        <form method="POST" action="{{url('/users/update',$user->id)}}" enctype="multipart/form-data">
            @csrf
            @if(session()->has('success'))
                    <div class="form-group text-center">
                        <label class="alert alert-success">{{ session()->get('success')}}</label>
                    </div>
                @endif
            @if(session()->has('error'))
                <div class="form-group text-center mt-1">
                    <label class="alert alert-warning">{{ session()->get('error')}}</label>
                </div>
            @endif
            @if(count($errors)>0)
                <div class="form-group text-center mt-1">
                    <label class="alert alert-warning">{{ $errors->first()}}</label>
                </div>
            @endif

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label">صورة البروفايل</label>
                        <input  type="file" class="form-control" name="avatar">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                    <label class="control-label">الاسم الكامل</label>
                    <input required type="text" class="form-control" name="name" value="{{$user->name}}">
                    @error('name')
                        <p style="color: red;">{{$message}}</p>
                    @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label">الصلاحيات</label>
                        <select class="form-control" name="role_id" required>
                            @foreach($roles as $role)
                                <option value="{{$role->id}}" @if($user->role_id == $role->id) selected @endif>{{$role->display_name}}</option>
                            @endforeach
                        </select>
                        @error('role_id')
                            <p style="color: red;">{{$message}}</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
            <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">البنك</label>
                        <select class="form-control" name="bank_id" id="banks" >

                            @foreach($banks as $bank)
                                <option value="{{$bank->id}}" @if($user->bank_id == $bank->id) selected @endif>{{$bank->ar_name}}</option>
                            @endforeach
                        </select>
                        @error('bank_id')
                            <p style="color: red;">{{$message}}</p>
                        @endif
                    </div>
                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        @if($user->role_id!=5)
                        <label class="control-label">فرع البنك</label>
                        <select class="form-control" name="branch_id" id="branches">
                            <option value="0">Please select</option>
                            @foreach($branches as $branch)
                                <option value="{{$branch->id}}" @if($user->branch_id == $branch->id) selected @endif>{{$branch->name}}</option>
                            @endforeach
                        </select>
                        @error('branch_id')
                            <p style="color: red;">{{$message}}</p>
                        @endif
                        @endif
                    </div>

                </div>
                <div class="col-md-6">

                    <div class="form-group">
                        @if(auth()->user()->role_id==1)
                        <label class="control-label">كلمة مرور جديدة</label>
                            <input  type="text" class="form-control" name="new_password" >
                        @error('password')
                            <p style="color: red;">{{$message}}</p>
                        @endif
                        @endif
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary-big">حفظ التعديلات</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('js')
<script>
 $('#banks').on('change',function () {
            console.log('cl');
            $.ajax({
                type: 'get',
                url: "{{route('getBranchesJson')}}?id=" + this.value,
                success: function (data) {
                    $('#branches')
                        .find('option')
                        .remove()
                        .end();
                    console.log(data);
//                    $('#branches').selectpicker('refresh');
                    var option2 = new Option("please select",0);
                    $(option2).html("please select");
                    $('#branches').append(option2);
                    for (var i = 0; i < data.data.length; i++) {
                        var option = new Option(data.data[i].name, data.data[i].id);
                        $(option).html(data.data[i].name);
                        $('#branches').append(option);

                    }


                }
            });
        });
</script>
@endsection