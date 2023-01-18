@extends('layouts.new')
@section('title','إضافة بنك جديد')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">إضافة بنك</h1>
            </div>
        </div>

        <div class="container">
            <form method="POST" action="{{url('/banks/store')}}">
                @csrf
                @if(session()->has('success'))
                    <div class="form-group text-center">
                        <label class="alert alert-success">{{ session()->get('success')}}</label>
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">

                            <label class="control-label" for="name">الاسم بالانكليزيه</label>
                            <input required="" type="text" class="form-control" name="en_name"
                                   placeholder="الاسم بالانكليزيه" value="{{old('en_name')}}">
                            @error('en_name')
                            <p style="color: red;">{{$message}}</p>
                            @endif

                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">

                            <label class="control-label" for="name">الاسم بالعربيه</label>
                            <input required="" type="text" class="form-control" name="ar_name"
                                   placeholder="الاسم بالعربيه" value="{{old('ear_name')}}">

                            @error('ar_name')
                            <p style="color: red;">{{$message}}</p>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">

                            <label class="control-label" for="name">رمز البنك</label>
                            <input required="" type="text" class="form-control" name="code" placeholder="رمز البنك" maxlength="10"
                                   value="{{old('cod')}}">

                            @error('code')
                            <p style="color: red;">{{$message}}</p>
                            @endif
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">

                            <label class="control-label" for="name">معلومات الاتصال</label>
                            <textarea required="" class="form-control" name="contact" rows="5">{{old('contact')}}</textarea>

                            @error('contact')
                            <p style="color: red;">{{$message}}</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary-big">حفظ</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection