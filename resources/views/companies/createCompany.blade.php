@extends('layouts.new')
@section('title','إضافة شركة')
    @section('css')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
        @endsection
@section('content')

<div class="container-fluid">
        <div class="container col-md-3">
            <h1>إضافة شركة</h1>
        </div>
        <div class="container" style="padding-top: 15px;">
            <form method="POST" action="{{url('companies/store')}}" enctype="multipart/form-data">
                @csrf
                @if(session()->has('success'))
                    <div class="form-group">
                        <label class="alert alert-success">{{ session()->get('success')}}</label>
                    </div>
                @endif

                @if(count($errors)>0)
                    <div class="form-group">
                        <label class="alert alert-danger">{{ $errors->first()}}</label>
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">اسم الشركة بالعربي</label>
                            <input required type="text" class="form-control" name="ar_name" value="{{old('ar_name')}}">
                            @error('ar_name')
                            <p style="color: red;">{{$message}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">اسم الشركة بالانكليزية</label>
                            <input required type="text" class="form-control" name="en_name" value="{{old('en_name')}}">
                            @error('en_name')
                            <p style="color: red;">{{$message}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">رمز الشركة</label>
                            <input required type="text" class="form-control" name="code" value="{{old('code')}}">
                            @error('code')
                            <p style="color: red;">{{$message}}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">رقم الهاتف1</label>
                            <input required type="number" class="form-control" name="phone1" value="{{old('phone1')}}">
                            @error('phone1')
                            <p style="color: red;">{{$message}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">رقم الهاتف2</label>
                            <input required type="number" class="form-control" name="phone2" value="{{old('phone2')}}">
                            @error('phone2')
                            <p style="color: red;">{{$message}}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">رأس المال</label>
                            <input required type="number" class="form-control" name="capital" value="{{old('capital')}}">
                            @error('capital')
                            <p style="color: red;">{{$message}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">رقم الترخيص</label>
                            <input required type="text" class="form-control" name="license" value="{{old('license')}}">
                            @error('license')
                            <p style="color: red;">{{$message}}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">العنوان</label>
                            <input required type="text" class='form-control' name="address" value="{{old('address')}}">
                            @error('address')
                            <p style="color: red;">{{$message}}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">نشاط الشركة</label>
                            <input required type="text" class='form-control' name="section" value="{{old('section')}}">
                            @error('section')
                            <p style="color: red;">{{$message}}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">عقد تأسيس</label>
                            <input required type="file" class="form-control" name="foundation">
                            @error('foundation')
                            <p style="color: red;">{{$message}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">نظام أساسي</label>
                            <input required type="file" class="form-control" name="system" >
                            @error('system')
                            <p style="color: red;">{{$message}}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">أسماء المؤسسين</label>
                            <textarea id="editor" name="founders_list">{{old('founders_list')}}
                </textarea>
                            @error('founders_list')
                            <p style="color: red;">{{$message}}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">إعلان الطرح</label>
                            <input required type="file" class="form-control" name="ad" >
                            @error('ad')
                            <p style="color: red;">{{$message}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">نشرة الإصدار</label>
                            <input required type="file" class="form-control" name="version" >
                            @error('version')
                            <p style="color: red;">{{$message}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">بيان بمصاريف الدخل</label>
                            <input required type="file" class="form-control" name="version_spend" >
                            @error('version_spend')
                            <p style="color: red;">{{$message}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">نظام داخلي</label>
                            <input required type="file" class="form-control" name="enner_system" >
                            @error('enner_system')
                            <p style="color: red;">{{$message}}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">

                            <label class="control-label" for="name">بيان بالحصص</label>
                            <input required required="" type="text" class="form-control" name="share_report"
                                   value="{{old('share_report')}}">
                            @error('share_report')
                            <p style="color: red;">{{$message}}</p>
                            @endif

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">

                            <label class="control-label" for="name">عدد الاسهم المراد الاكتتاب عليها</label>
                            <input required type="number" class="form-control" name="stocks" value="{{old('stocks')}}">
                            @error('stocks')
                            <p style="color: red;">{{$message}}</p>
                            @endif

                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">

                            <label class="control-label" for="name">الحد الادنى لعدد الاسهم</label>
                            <input required type="number" class="form-control" name="min_stock" value="{{old('min_stock')}}">
                            @error('min_stock')
                            <p style="color: red;">{{$message}}</p>
                            @endif

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">

                            <label class="control-label" for="name">تاربخ بدايه الاكتتاب</label>
                            <input required type="date" class="form-control" name="start_date" placeholder="تاربخ بدايه الاكتتاب"
                                   value="{{old('start_date')}}">

                            @error('start_date')
                            <p style="color: red;">{{$message}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">

                            <label class="control-label" for="name">تاريخ نهايه الاكتتاب</label>
                            <input required type="date" class="form-control" name="end_date" placeholder="تاريخ نهايه الاكتتاب"
                                   value="{{old('end_date')}}">
                            @error('end_date')
                            <p style="color: red;">{{$message}}</p>
                            @endif

                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">

                            <label class="control-label" for="name">البنوك المشاركه</label>
                            <select class="form-control select2" name="banks[]" id="banks" multiple required>
                                @foreach($banks as $bank)
                                    <option value="{{$bank->id}}" >{{$bank->ar_name}}</option>
                                    @endforeach
                            </select>
                            @error('banks')
                            <p style="color: red;">{{$message}}</p>
                            @endif

                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">

                            <label class="control-label" for="name">فروع البنوك المشاركه</label>
                            <select class="form-control select2" name="banks_branches[]" id="branches" multiple required>
                            </select>

                            @error('banks_branches')
                            <p style="color: red;">{{$message}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12">
                    <button type="submit" class="btn btn-success text-center">ادخال</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
@section('js')

    <script src="{{asset('assets/ckeditor/ckeditor.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
            console.error(error)
        })
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "الرجاء الاختيار"
            });


        });
        var banks='';
        $('#banks').on('change',function () {
            if (this.value!=''){
                banks='';
                console.log()
                for(var i=0;i<$('#banks').val().length;i++){
                    banks=banks+','+$('#banks').val()[i];
                    console.log(banks);
                }

            }
            $.ajax({
                type: 'get',
                url: "{{route('getBranchesJson')}}",
                data: {'_token ':'{{csrf_token()}}',
                    'id':banks},
                success: function (data) {
                    console.log(data);
                    $('#branches')
                        .find('option')
                        .remove()
                        .end();
                    console.log(data);
                    var option2 = new Option("please select",0);
                    for (var i = 0; i < data.data.length; i++) {
                        var option = new Option(data.data[i].name+'('+data.data[i].bank.ar_name+')', data.data[i].id);
                        $(option).html(data.data[i].name+'('+data.data[i].bank.ar_name+')');
                        $('#branches').append(option);

                    }



                }
            });
        })
    </script>
    @endsection