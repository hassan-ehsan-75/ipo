@extends('layouts.new')
@section('title','تعديل شركة')
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
@endsection
@section('content')
<div class="container-fluid">
    <div class="container col-md-3">
        <h1>تعديل شركة</h1>
    </div>
    @if(count($errors)>0)
        <div class="form-group text-center mt-1">
            <label class="alert alert-warning">{{$errors->first()}}</label>
        </div>
    @endif
    <div class="container" style="padding-top: 15px;">
        <form method="post" action="{{url('companies/update',$company->id)}}" enctype="multipart/form-data">
            {{ method_field('PUT') }}
            @csrf

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label">اسم الشركة بالعربي</label>
                        <input type="text" required class="form-control" name="ar_name" value="{{$company->ar_name}}">
                        @error('ar_name')
                        <p style="color: red;">{{$message}}</p>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label">اسم الشركة بالانكليزية</label>
                        <input type="text" required class="form-control" name="en_name" value="{{$company->en_name}}">
                        @error('en_name')
                        <p style="color: red;">{{$message}}</p>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label">رمز الشركة</label>
                        <input type="text" required class="form-control" name="code" value="{{$company->code}}">
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
                        <input type="number" required class="form-control" name="phone1" value="{{$company->phone1}}">
                        @error('phone1')
                        <p style="color: red;">{{$message}}</p>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">رقم الهاتف2</label>
                        <input type="number" required class="form-control" name="phone2" value="{{$company->phone2}}">
                        @error('phone1')
                        <p style="color: red;">{{$message}}</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">رأس المال</label>
                        <input type="number" required class="form-control" name="capital" value="{{$company->capital}}">
                        @error('capital')
                        <p style="color: red;">{{$message}}</p>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">رقم الترخيص</label>
                        <input type="text" required class="form-control" name="license" value="{{$company->license}}">
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
                        <input type="text" required class='form-control' name="address" value="{{$company->address}}">
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
                        <input type="text" required class='form-control' name="section" value="{{$company->section}}">
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
                        <input type="file" class="form-control" name="foundation">
                        @error('foundation')
                        <p style="color: red;">{{$message}}</p>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">نظام أساسي</label>
                        <input type="file" class="form-control" name="system" >
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
                        <textarea id="editor" name="founders_list">{{$company->founders_list}}
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
                        <input type="file" class="form-control" name="ad" >
                        @error('ad')
                        <p style="color: red;">{{$message}}</p>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">نشرة الإصدار</label>
                        <input type="file" class="form-control" name="version" >
                        @error('version')
                        <p style="color: red;">{{$message}}</p>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">بيان بمصاريف الدخل</label>
                        <input type="file" class="form-control" name="version_spend" >
                        @error('version_spend')
                        <p style="color: red;">{{$message}}</p>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">نظام داخلي</label>
                        <input type="file" class="form-control" name="enner_system" >
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
                        <input required="" type="text" class="form-control" name="share_report"
                               value="{{$company->share_report}}">
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
                        <input required type="number" class="form-control" name="stocks" value="{{$company->stocks}}">
                        @error('stocks')
                        <p style="color: red;">{{$message}}</p>
                        @endif

                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">

                        <label class="control-label" for="name">الحد الادنى لعدد الاسهم</label>
                        <input required type="number" required class="form-control" name="min_stock" value="{{$company->min_stock}}">
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
                               value="{{$company->start_date}}">

                        @error('start_date')
                        <p style="color: red;">{{$message}}</p>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">

                        <label class="control-label" for="name">تاريخ نهايه الاكتتاب</label>
                        <input required type="date" class="form-control" name="end_date" placeholder="تاريخ نهايه الاكتتاب"
                               value="{{$company->end_date}}">

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
                                <option value="{{$bank->id}}" @if(in_array($bank->id,$companyBanks)) selected @endif>{{$bank->ar_name}}</option>
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
                            @foreach($branches as $branch)
                                <option value="{{$branch->id}}" @if(in_array($branch->id,$companyBankBranches)) selected @endif>{{$branch->name}}</option>
                            @endforeach
                        </select>

                        @error('banks_branches')
                        <p style="color: red;">{{$message}}</p>
                        @endif
                    </div>
                </div>
                <div class="col-md-12">
                    <button type="submit" class="btn btn-success text-center">حفظ</button>
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
        {{--$('#banks').on('change',function () {--}}
            {{--console.log('cl');--}}
            {{--$.ajax({--}}
                {{--type: 'get',--}}
                {{--url: "{{route('getBranchesJson')}}?id=" + this.value,--}}
                {{--success: function (data) {--}}
                    {{--$('#branches')--}}
                        {{--.find('option')--}}
                        {{--.remove()--}}
                        {{--.end();--}}
                    {{--console.log(data);--}}
{{--//                    $('#branches').selectpicker('refresh');--}}
                    {{--var option2 = new Option("please select",0);--}}
                    {{--for (var i = 0; i < data.data.length; i++) {--}}
                        {{--var option = new Option(data.data[i].name, data.data[i].id);--}}
                        {{--$(option).html(data.data[i].name);--}}
                        {{--$('#branches').append(option);--}}

                    {{--}--}}


                {{--}--}}
            {{--});--}}
        {{--});--}}
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