@extends('layouts.new')
@section('title','إضافة نموذج')
@section('content')
<div class="container-fluid">
    <div class="container">
        <h1 class="text-center">إضافة نموذج</h1>
    </div>
    <div class="container col-md-8 shadow">
        <form method="POST" action="{{url('/forms/store')}}" enctype="multipart/form-data">
            @csrf
            @if(session()->has('success'))
                    <div class="form-group text-center">
                        <label class="alert alert-success">{{ session()->get('success')}}</label>
                    </div>
                @endif
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">العنوان</label>
                        <input type="text" name="name" class="form-control" required>
                        @error('name')
                            <p style="color:red">{{$message}}</p>

                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                    <label class="control-label">الملف</label>
                        <input type="file" name="file" class="form-control" required>
                        @error('file')
                            <p style="color:red">{{$message}}</p>

                        @endif
                    </div>
                </div>
            </div>
            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary-big">حفظ</button>
            </div>
        </form>
    </div>
</div>
@endsection