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
                <?php if($stock->type == 1):?>
                تعديل جديد طبيعي
                <?php elseif($stock->type == 2):?>
                تعديل جديد إعتباري
                <?php endif;?>
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
            <form method="POST" action="{{url('/stocks/update',$stock->id)}}" enctype="multipart/form-data">
                @csrf


                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">

                            <label class="control-label" for="name">الاسم الاول<span class="req">*</span></label>
                            <input required="" type="text" class="form-control" name="full_name"
                                   placeholder="الاسم الكامل" value="{{$stock->full_name}}">
                            @error('full_name')
                            <p style="color: red;">{{$message}}</p>
                            @endif

                        </div>
                    </div>
                    @if($stock->type == 1)

                        <div class="col-md-4">
                            <div class="form-group">

                                <label class="control-label" for="name">اسم الاب<span class="req">*</span></label>
                                <input required type="text" class="form-control" name="father" placeholder="اسم الاب"
                                       value="{{$stock->father}}">
                                @error('father')
                                <p style="color: red;">{{$message}}</p>
                                @endif

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">

                                <label class="control-label" for="name">اسم الام<span class="req">*</span></label>
                                <input required type="text" class="form-control" name="mother" placeholder="اسم الام"
                                       value="{{$stock->mother}}">
                                @error('mother')
                                <p style="color: red;">{{$message}}</p>
                                @endif

                            </div>
                        </div>



                        <div class="col-md-4">
                            <div class="form-group">

                                <label class="control-label" for="name">اسم العائلة<span class="req">*</span></label>
                                <input required type="text" class="form-control" name="last_name"
                                       value="{{$stock->last_name}}">

                                @error('last_name')
                                <p style="color: red;">{{$message}}</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">

                                <label class="control-label" for="name">الجنسية<span class="req">*</span></label>
                                <input required type="text" class="form-control" name="nation"
                                       value="{{$stock->nation}}">

                                @error('nation')
                                <p style="color: red;">{{$message}}</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="name">تاريخ  الولادة<span class="req">*</span></label>
                                <input required type="text" class="form-control" name="birthday"
                                       placeholder="تاريخ  الولادة" value="{{$stock->birthday}}">

                                @error('birthday')
                                <p style="color: red;">{{$message}}</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">

                                <label class="control-label" for="name">الجنس<span class="req">*</span></label>
                                <select required class="form-control" name="gender" placeholder="الجنس" value="{{$stock->gender}}">
                                    <option value="ذكر">ذكر</option>
                                    <option value="انثى">انثى</option>
                                </select>

                                @error('gender')
                                <p style="color: red;">{{$message}}</p>
                                @endif
                            </div>
                        </div>


                    @endif
                        <div class="col-md-12">
                            <h5>بطاقة التعريف</h5>
                            @if($stock->type == 1)
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="control-label">نوع الوثيقة<span class="req">*</span></label>
                                        <select name="id_type" class="form-control" id="id_type">
                                            <option value="بطاقة شخصية">بطاقة شخصية</option>
                                            <option value="جواز سفر">جواز سفر</option>
                                            <option  value="اخرى">اخرى</option>
                                        </select>
                                        @error('id_other')
                                        <p style="color: red;">{{$message}}</p>
                                        @endif
                                    </div>
                                    <div class="col-md-4" id="other">
                                        <label class="control-label">نوع الوثيقة(اخرى)</label>
                                        <input  type="text" class="form-control" name="id_other" value="{{$stock->id_other}}"
                                               placeholder="نوع الوثيقة(اخرى)" >
                                        @error('id_type')
                                        <p style="color: red;">{{$message}}</p>
                                        @endif
                                    </div>

                                </div>
                            @endif
                        </div>
                    @if($stock->type == 1)
                        <div class="col-md-4">
                            <div class="form-group">

                                <label class="control-label" for="name">تاريخ منح (الهويه|جواز السفر)<span class="req">*</span></label>
                                <input required type="date" class="form-control" name="id_date"
                                       placeholder="تاريخ منح (الهويه|جواز السفر)" value="{{$stock->id_date}}">
                                @error('id_date')
                                <p style="color: red;">{{$message}}</p>
                                @endif
                            </div>
                        </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">الرقم الوطني<span class="req">*</span></label>
                                    <input required type="text" class="form-control" name="p_number"
                                           placeholder="الرقم "
                                           value="{{$stock->p_number}}">

                                    @error('p_number')
                                    <p style="color: red;">{{$message}}</p>
                                    @endif
                                </div>
                            </div>

                        <div class="col-md-4">
                            <div class="form-group  col-md-12 ">

                                <label class="control-label" for="name">جهه الاصدار (الهويه|جواز السفر)<span class="req">*</span></label>
                                <input required type="text" class="form-control" name="id_from"
                                       placeholder="جهه الاصدار (الهويه|جواز السفر)" value="{{$stock->id_from}}">
                                @error('id_from')
                                <p style="color: red;">{{$message}}</p>
                                @endif

                            </div>
                        </div>

                    @endif
                    <div class="col-md-4">
                        <div class="form-group">

                            <label class="control-label" for="name">ايميل</label>
                            <input  type="email" class="form-control" name="email" placeholder="ايميل"
                                   value="{{$stock->email}}">
                            @error('email')
                            <p style="color: red;">{{$message}}</p>
                            @endif

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">

                            <label class="control-label" for="name">هاتف</label>
                            <input  style="direction: ltr" type="text" class="form-control" name="phone" placeholder="هاتف"
                                   value="{{$stock->phone}}">

                            @error('phone')
                            <p style="color: red;">{{$message}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">

                            <label class="control-label" for="name">موبايل<span class="req">*</span></label>
                            <input style="direction: ltr" required type="text" class="form-control" name="mobile" placeholder="موبايل"
                                   value="{{$stock->mobile}}">

                            @error('mobile')
                            <p style="color: red;">{{$message}}</p>
                            @endif
                        </div>
                    </div>

                </div>


                <div class="row">


                    <div class="col-md-4">
                        <div class="form-group">

                            <label class="control-label" for="name">فاكس</label>
                            <input  type="text" class="form-control" name="fax" placeholder="فاكس"
                                   value="{{$stock->fax}}">
                            @error('fax')
                            <p style="color: red;">{{$message}}</p>
                            @endif

                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">

                            <label class="control-label" for="name">المدينة<span class="req">*</span></label>
                            <input required type="text" class="form-control" name="city" placeholder="المدينة"
                                   value="{{$stock->city}}">
                            @error('city')
                            <p style="color: red;">{{$message}}</p>
                            @endif

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">

                            <label class="control-label" for="name">عنوان<span class="req">*</span></label>
                            <input required type="text" class="form-control" name="address" placeholder="عنوان"
                                   value="{{$stock->address}}">
                            @error('address')
                            <p style="color: red;">{{$message}}</p>
                            @endif

                        </div>
                    </div>
                </div>

                @if($stock->type == 2)
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">

                                <label class="control-label" for="name">رقم السجل (تجاري\صناعي.....)<span class="req">*</span></label>
                                <input required type="number" class="form-control" name="record_number" step="any"
                                       placeholder="رقم السجل (تجاري\صناعي.....)" value="{{$stock->record_number}}">

                                @error('record_number')
                                <p style="color: red;">{{$message}}</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">

                                <label class="control-label" for="name">صوره السجل<span class="req">*</span></label>
                                <input type="file" class="form-control" name="record_img" >
                                @error('record_img')
                                <p style="color: red;">{{$message}}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
                <div class="row">

                    <div class="col-md-4">
                        <div class="form-group">

                            <label class="control-label" for="name">عدد الاسهم المراد الاكتتاب عليها<span class="req">*</span></label>
                            <input required type="number" class="form-control" name="stock_number" step="any" id="stock_number"
                                   placeholder="عدد الاسهم المراد الاكتتاب عليها" value="{{$stock->stock_number}}">

                            {{--@error('stock_number')--}}
                            {{--<p style="color: red;">{{$message}}</p>--}}
                            {{--@endif--}}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">

                            <label class="control-label" for="name">القيمه الماليه<span class="req">*</span></label>
                            <input required  type="number" class="form-control disabled" name="total" id="total"
                                   placeholder="القيمه الماليه" value="{{$stock->total}}">
                            @error('total')
                            <p style="color: red;">{{$message}}</p>
                            @endif

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">نوع الشخص<span class="req">*</span></label>
                            <select class="form-control" name="type" disabled>
                                @if($stock->type == 1)
                                    <option value="1" selected>طبيعي</option>
                                @elseif($stock->type ==2)
                                    <option value="2" selected>اعتباري</option>
                                @endif
                            </select>
                            @error('type')
                            <p style="color: red;">{{$message}}</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">

                            <label class="control-label" for="name">صوره الهويه</label>
                            <input  type="file" class="form-control" name="identity_img" >

                            @error('identity_img')
                            <p style="color: red;">{{$message}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">

                            <label class="control-label" for="family_img">صوره بيان العائلة</label>
                            <input  type="file" class="form-control" name="family_img" >

                            @error('family_img')
                            <p style="color: red;">{{$message}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">

                            <label class="control-label" for="procuration_img">صوره التفويض ان وجد</label>
                            <input  type="file" class="form-control" name="procuration_img" >

                            @error('procuration_img')
                            <p style="color: red;">{{$message}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">

                            <label class="control-label" for="civil_img">صوره اخراج قيد مدني ان وجد</label>
                            <input  type="file" class="form-control" name="civil_img" accept="image/*">

                            @error('civil_img')
                            <p style="color: red;">{{$message}}</p>
                            @endif
                        </div>
                    </div>

                </div>
                <div class="row">
                    {{--<div class="col-md-6">--}}
                        {{--<div class="form-group">--}}
                            {{--<label class="control-label">الشركة المسجل لديها<span class="req">*</span></label>--}}
                            {{--<select required id="company_id" name="company_id" class="selectpicker form-control"--}}
                                    {{--data-live-search="true" data-live-search-style="begins">--}}
                                {{--@foreach($companies as $company)--}}
                                    {{--<option value="{{$company->id}}"--}}
                                            {{--@if($stock->company_id == $company->id) selected @endif>{{$company->ar_name}}</option>--}}
                                {{--@endforeach--}}
                            {{--</select>--}}
                            {{--@error('company_id')--}}
                            {{--<p style="color: red;">{{$message}}</p>--}}
                            {{--@endif--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    @if(auth()->user()->role_id==1)
                        {{--<div class="col-md-6">--}}
                            {{--<div class="form-group">--}}
                                {{--<label class="control-label">البنك المسجل<span class="req">*</span></label>--}}
                                {{--<select required id="bank_id" name="bank_id" class="selectpicker form-control"--}}
                                        {{--data-live-search="true" data-live-search-style="begins">--}}

                                    {{--@foreach($banks as $bank)--}}
                                        {{--<option value="{{$bank->id}}"--}}
                                                {{--@if($stock->bank_id == $bank->id) selected @endif>{{$bank->ar_name}}</option>--}}
                                    {{--@endforeach--}}
                                {{--</select>--}}
                                {{--@error('bank_id')--}}
                                {{--<p style="color: red;">{{$message}}</p>--}}
                                {{--@endif--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="col-md-6">--}}
                            {{--<div class="form-group">--}}
                                {{--<label class="control-label">فرع البنك المسجل<span class="req">*</span></label>--}}
                                {{--<select id="branch_id" name="branch_id" class=" form-control" required--}}
                                        {{--data-live-search="true" data-live-search-style="begins" value="{{old('branch_id')}}">--}}
                                    {{--@foreach(\App\User::where('bank_id',$stock->bank_id)->where('branch_id','!=',0)->where('branch_id','!=',null)->get()->load('branch') as $user)--}}
                                    {{--<option value="{{$user->id}}">{{''.'('.$user->name.')'}}</option>--}}
                                    {{--@endforeach--}}
                                {{--</select>--}}
                                {{--@error('branch_id')--}}
                                {{--<p style="color: red;">{{$message}}</p>--}}
                                {{--@endif--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    @endif
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

@section('js')
    <script>


        @if(!$stock->id_other)
        $('#other').hide();
        @endif
        $('#id_type').val('{{$stock->id_type}}');
        document.getElementById('stock_number').addEventListener('change',function () {
            document.getElementById('total').value=document.getElementById('stock_number').value*100;
        });
//        $('#stock_number').on('change',function () {
//            $('#total').val($('#stock_number').val()*100)
//        })
        $('#bank_id').on('change',function () {

            $.ajax({
                type: 'get',
                url: "{{route('getBranchesJson2')}}",
                data: {'_token ':'{{csrf_token()}}',
                    'id':$('#bank_id').val()},
                success: function (data) {
                    console.log(data);
                    $('#branch_id')
                        .find('option')
                        .remove()
                        .end();
                    console.log(data);
                    var option2 = new Option("please select",0);
                    for (var i = 0; i < data.data.length; i++) {
                        var option = new Option(data.data[i].name+'('+data.data[i].branch.name+')', data.data[i].id);
                        console.log(option);
                        $(option).html(data.data[i].name+'('+data.data[i].branch.name+')');
                        $('#branch_id').append(option);

                    }



                }
            });
        });
        $('#id_type').on('change',function () {
            if (this.value=='اخرى'){
                $('#other').show();
            }else{
                $('#other').hide();
            }
        })
        $(document).ready(function () {
            console.log($('#bank_id').val());
            $.ajax({
                type: 'get',
                url: "{{route('getBranchesJson2')}}",
                data: {'_token ':'{{csrf_token()}}',
                    'id':$('#bank_id').val()},
                success: function (data) {
                    $('#branch_id')
                        .find('option')
                        .remove()
                        .end();
                    console.log(data);
                    var option2 = new Option("please select",0);
                    for (var i = 0; i < data.data.length; i++) {
                        var option = new Option(data.data[i].name+'('+data.data[i].branch.name+')', data.data[i].id);
                        console.log(option);
                        $(option).html(data.data[i].name+'('+data.data[i].branch.name+')');
                        $('#branch_id').append(option);

                    }



                }
            });
        });
        $('.selectpicker').selectpicker('refresh');
    </script>
@endsection