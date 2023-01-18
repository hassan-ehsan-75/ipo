@extends('layouts.new')
@section('title','تعديل اكتتاب')
@section('css')

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

    <!-- (Optional) Latest compiled and minified JavaScript translation files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>

    <!-- (Optional) Latest compiled and minified JavaScript translation files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode@2.0.9/dist/html5-qrcode.min.js"></script>
    <style>
        .req{
            color: red;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="container">
            <h1 class="text-center">
             تفعيل
            </h1>
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
        @if(session()->has('error'))
            <div class="form-group text-center">
                <label class="alert alert-danger">{{ session()->get('error')}}</label>
            </div>
        @endif
        <div class="container">

            <form  action="{{route('stock.activate').'/' . $id}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-9">
                        <div class="form-group">

                            <label class="control-label" for="rec_img">صوره الاشعار</label>
                            <input required type="file" class="form-control" name="rec_img" >

                            @error('rec_img')
                            <p style="color: red;">{{$message}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">

                            <label class="control-label" for="rec_img">صوره الاكتتاب بعد التوقيع</label>
                            <input required type="file" class="form-control" name="stock_img"   >

                            @error('stock_img')
                            <p style="color: red;">{{$message}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">

                            <label class="control-label" for="rec_img">طريقة الدفع</label>
                            <select required class="form-control" name="type">
                                <option value="1">كاش</option>
                                <option value="2">حوالة</option>
                            </select>

                            @error('type')
                            <p style="color: red;">{{$message}}</p>
                            @endif
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">تفعيل</button>
            </form>
        </div>
    </div>
@endsection


