@extends('layouts.new')
@section('title','الاعدادات')
@section('content')
    @php $setting=\App\Setting::first(); @endphp
    <div class="container-fluid">
        <div class="container">
            <h1 class="text-center">الاعدادات</h1>
        </div>
        <div class="container shadow" style="margin-top: 15px;padding-top:15px">
            <form method="POST" action="{{url('/settings/update')}}" enctype="multipart/form-data">
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

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">الوقت المسموح للتعديل بعد الاضافه (بالساعات)</label>
                            <input required type="number" class="form-control" name="expired_date" value="{{$setting->expired_date}}">
                            @error('expired_date')
                            <p style="color: red;">{{$message}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">حالة الاكتتاب</label>
                            <select name="stock_status" class="form-control">
                                <option value="0" @if($setting->stock_status==0) selected @endif>متوقفة</option>
                                <option value="1" @if($setting->stock_status==1) selected @endif>جارية</option>
                            </select>
                            @error('stock_status')
                            <p style="color: red;">{{$message}}</p>
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