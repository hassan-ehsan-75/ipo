@extends('layouts.new')
@section('title','تعديل بنك')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">تعديل بنك</h1>
            </div>
        </div>

        <div class="container">
            <form method="POST" action="{{url('/banks/update',$bank->id)}}">
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
                            <input required="" type="text" class="form-control" value="{{$bank->en_name}}"
                                   name="en_name" placeholder="الاسم بالانكليزيه" value="">
                            @error('en_name')
                            <p style="color: red;">{{$message}}</p>
                            @endif

                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">

                            <label class="control-label" for="name">الاسم بالعربيه</label>
                            <input required="" type="text" value="{{$bank->ar_name}}" class="form-control"
                                   name="ar_name" placeholder="الاسم بالعربيه" value="">

                            @error('ar_name')
                            <p style="color: red;">{{$message}}</p>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">

                            <label class="control-label" for="name">رمز البنك</label>
                            <input required="" type="text" class="form-control" value="{{$bank->code}}" name="code"
                                   placeholder="رمز البنك" value="">

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
                            <textarea required="" class="form-control" name="contact" rows="5">
                                        {{$bank->contact}}
                                    </textarea>

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
                                   placeholder="الاسم بالانكليزيه" value="">
                            @error('en_name')
                            <p style="color: red;">{{$message}}</p>
                            @endif

                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">

                            <label class="control-label" for="name">الاسم بالعربيه</label>
                            <input required="" type="text" class="form-control" name="ar_name"
                                   placeholder="الاسم بالعربيه" value="">

                            @error('ar_name')
                            <p style="color: red;">{{$message}}</p>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">

                            <label class="control-label" for="name">رمز البنك</label>
                            <input required="" type="text" class="form-control" name="code" placeholder="رمز البنك"
                                   value="">

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
                            <textarea required="" class="form-control" name="contact" rows="5"></textarea>

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