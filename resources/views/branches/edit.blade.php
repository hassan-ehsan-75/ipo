@extends('layouts.new')

@section('title','تعديل فرع')
@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>
@endsection
@section('content')
<div class="container-fluid">
    <div class="container col-md-5">
        <h1 class="text-center">تعديل فرع</h1>
    </div>
    <div class="container">
        <form method="POST" action="{{url('/branches/update',$branch->id)}}">
            @csrf
            @if(session()->has('success'))
                    <div class="form-group text-center">
                        <label class="alert alert-success">{{ session()->get('success')}}</label>
                    </div>
                @endif
            <div class="form-group">
                <label class="control-label">اسم الفرع</label>
                <input type="text" name="name" class="form-control" value="{{$branch->name}}" required>
                @error('name')
                    <p style="color: red;">{{$message}}</p>
                @endif
            </div>
            <div class="form-group">
                <label class="control-label">الشخص المسؤول</label>
                <input type="text" name="respon_person" class="form-control" value="{{$branch->respon_person}}" required>
                @error('respon_person')
                    <p style="color: red;">{{$message}}</p>
                @endif
            </div>
            <div class="form-group">
                <label class="control-label">اختر البنك</label>
                <select id="bank_id" name="bank_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" required>
                    @foreach($banks as $bank)
                    <option value="{{$bank->id}}" @if($bank->id == $branch->bank_id) selected @endif>{{$bank->ar_name}}</option>
                    @endforeach
                </select>
                @error('bank_id')
                    <p style="color: red;">{{$message}}</p>
                @endif
            </div>
            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary-big">حفظ</button>
            </div>
        </form>
    </div>
</div>
@endsection
@section('js')
<script>
    $('.selectpicker').selectpicker('refresh');
</script>
@endsection