@extends('layouts.new')
@section('title','الاكتتاب')

@section('content')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/excellentexport@3.4.3/dist/excellentexport.min.js"></script>
    <div class="container-fluid">
        @if(Auth::User()->hasRole('create_stock'))
            <h1 class="text-center">الاكتتاب</h1>
            <div class="row">
                <?php
                $setting=\App\Setting::first();
                $time2 = Carbon\Carbon::parse(\App\Company::first()->end_date.' 16:00');

                ?>
                @if(Carbon\Carbon::now() < $time2 && $setting->stock_status==1)
                <div class="col-12 text-center"><a type="button" href="{{url('/stocks/create/1')}}"
                                                   class="btn btn-primary" type="button"
                                                   style="margin-right: 10px;margin-left: 10px;background: #2da134;border-radius: 35px;padding-top: 10px;padding-bottom: 10px;padding-left: 20px;padding-right: 20px;">تسجيل
                        اكتتاب جديد</a>
                </div>
                    @endif
            </div>
        @endif
    </div>
    @if(session()->has('error'))
        <div class="form-group text-center mt-1">
            <label class="alert alert-warning">{{ session()->get('error')}}</label>
        </div>
    @endif
    @if(session()->has('success'))
        <div class="form-group text-center mt-1">
            <label class="alert alert-success">{{ session()->get('success')}}</label>
        </div>
    @endif
    <div class="container shadow" style="padding-top: 25px;margin-top: 30px;max-width: 1250px">
        <div class="row">
            @if($duplicate==0)
            <div style="display: inline-block;width:100%;margin-right: 1px !important;" class="col-2 row ml-1">
                <label class="col-md-12" for="type">الفرز حسب طريقة الدفع</label>
                <select class="option-control col-md-12" name="type" style="height: 50%" id="type">
                    <option value="0">الكل</option>
                    <option value="1">كاش</option>
                    <option value="2">حوالة</option>
                </select>
            </div>
            <div style="display: inline-block;width:100%" class="col-2 row ml-1">
                <label for="type" class="col-md-12">الفرز حسب الحالة</label>
                <select class="option-control col-md-12" name="type" style="height: 50%" id="status" onchange="window.location.href='{{url('/stockss/'.$bank.'/'.$branch)}}'+'/'+this.value" >
                    <option value="3">الكل</option>
                    <option value="0">انتظار</option>
                    <option value="1">مفعل</option>
                </select>
            </div>
            @if(auth()->user()->role_id==1||auth()->user()->role_id==3)
            <div style="display: inline-block;width:100%;" class="col-2 row ml-1">
                <label for="type" class="col-md-12">الفرز حسب البنك</label>
                <select class="option-control col-md-12" name="type" style="height: 50%" id="bank_id" onchange="window.location.href='{{url('/stockss/')}}'+'/'+this.value">
                    <option value="0">الكل</option>
                    @foreach(\App\Bank::all() as $bankk)
                        <option  @if($bank==$bankk->id) selected @endif value="{{$bankk->id}}">{{$bankk->ar_name}}</option>
                        @endforeach
                </select>
            </div>
            <div style="display: inline-block;width:100%;" class="col-2 row ml-1">
                <label for="type" class="col-md-12">الفرز حسب الفرع</label>
                <select class="option-control col-md-12" name="type" style="height: 50%" id="branch_id"  onchange="window.location.href='{{url('/stockss/'.$bank.'/')}}/'+this.value+'/'+{{$status}}">
                    <option value="0">الكل</option>
                    @if($bank!=null)
                        @foreach(\App\BankBranch::where('bank_id',$bank)->get() as $bran)
                            <option @if($branch==$bran->id) selected @endif value="{{$bran->id}}">{{$bran->name}}</option>
                        @endforeach
                        @endif
                </select>
            </div>
                @elseif(auth()->user()->bank!=null&&auth()->user()->branch==null)
                <div style="display: inline-block;width:100%;" class="col-2 row ml-1">
                    <label for="type" class="col-md-12">الفرز حسب البنك</label>
                    <select class="option-control col-md-12" name="type" style="height: 50%" id="bank_id" onchange="window.location.href='{{url('/stockss/')}}'+'/'+this.value">
                        <option value="0">الكل</option>
                        @foreach(\App\Bank::where('id',auth()->user()->bank_id)->get() as $bankk)
                            <option  @if($bank==$bankk->id) selected @endif value="{{$bankk->id}}">{{$bankk->ar_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div style="display: inline-block;width:100%;" class="col-2 row ml-1">
                    <label for="type" class="col-md-12">الفرز حسب الفرع</label>
                    <select class="option-control col-md-12" name="type" style="height: 50%" id="branch_id"  onchange="window.location.href='{{url('/stockss/'.$bank.'/')}}/'+this.value+'/'+{{$status}}">
                        <option value="0">الكل</option>

                            @foreach(\App\BankBranch::where('bank_id',auth()->user()->bank_id)->get() as $bran)
                                <option @if(isset($branch))@if($branch==$bran->id) selected @endif @endif value="{{$bran->id}}">{{$bran->name}}</option>
                            @endforeach

                    </select>
                </div>
            @endif
            <div style="display: inline-block;width:100%;text-align:center" class="col-3 row">

                <label class="col-md-12">بحث</label>
                <form style="display: inline-block;" method="GET" action="{{url('/stockss')}}" class="col-md-12">
                    <input type="text" class="option-control" name="search" value="{{request('search')}}"
                           style="min-height: 38px">
                    <button type="submit" class="btn btn-secondary option-control mb-1">ابحث</button>
                </form>
            </div>
            @endif
                @if($duplicate==0)
            <div style="display: inline-block;width:100%;" class="col-4 row mr-1 mb-1">
                <a class="btn btn-success" href="{{url('/stockss/').'/'.$bank.'/'.$branch.'/'.$status.'/1'}}">عرض المكتتبين اكثر من مره</a>
            </div>
                    @else
                    <div style="display: inline-block;width:100%;" class="col-4 row mr-1 mb-1">
                        <a class="btn btn-success" href="{{url('/stockss/').'/'.$bank.'/'.$branch.'/'.$status.'/0'}}">العودة</a>
                    </div>
                    <div class="form-group text-center col-md-3 pull-right">
                        <table id="datatable" hidden style="display: none">
                            <thead>
                            <tr>
                                <th>رقم الطلب</th>
                                <th>الاسم الكامل</th>
                                <th>الرقم الوطني</th>
                                <th>موبايل</th>
                                <th>الجنسية</th>
                                <th>البنك</th>
                                <th>عدد الاسهم الكلي المكتتب بها</th>
                                <th>عدد المرات المكتتب فيها</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($stocks as $stockk)
                                <tr>

                                    @php
                                        $stocck=\App\Stock::where('p_number',$stockk->p_number)->get();
                                    @endphp
                                    @if(count($stocck)>0)
                                        <td>
                                            @foreach($stocck as $stock)
                                                {{$stock->id}},
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($stocck as $stock)
                                                {{$stock->full_name.' '.$stock->last_name}},
                                            @endforeach
                                        </td>
                                        <td>
                                            {{$stockk->p_number}}

                                        </td>
                                        <td dir="ltr" style="direction: ltr">

                                            {{$stocck[0]->mobile}}

                                        </td>
                                        <td >

                                            {{$stocck[0]->nation}}

                                        </td>
                                        {{--<td>{{$stock->total}}</td>--}}
                                        <td>

                                            {{$stocck[0]->stock_number}}

                                        </td><td>
                                            @foreach($stocck as $stock)
                                            {{\App\Bank::find($stock->bank_id)->ar_name}}
                                                @endforeach

                                        </td>
                                        <td>

                                            {{$stockk->count}}

                                        </td>


                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="form-group text-center col-md-3 pull-left" style="padding-top: 2%">
                            <a download="report.xls" href="#" class="btn btn-default-big" onclick="return ExcellentExport.excel(this, 'datatable', 'تقرير');">تصدير</a>
                        </div>
                    </div>
            @endif
        </div>
        <div class="table-responsive">
            @if($duplicate==0)
            <table class="table">
                <thead>
                <tr>
                    <th>رقم الطلب</th>
                    <th>الاسم الكامل</th>
                    <th>موبايل</th>
                    <th>الجنسية</th>
                    <th>القيمة المالية</th>
                    <th>عدد الاسهم المكتتب بها</th>
                    <th>الشركة المقدم عليها</th>
                    <th>البنك المسجل</th>
                    <th>الفرع</th>
                    <th>الحالة</th>
                    <th>تاريخ الإدخال</th>
                    <th>الاجراءات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($stocks as $stock)
                    <tr>
                        <td>{{$stock->id}}</td>
                        <td>{{$stock->full_name.' '.$stock->last_name}}</td>
                        <td dir="ltr" style="direction: ltr">{{$stock->mobile}}</td>
                        <td >{{$stock->nation}}</td>
                        <td>{{$stock->total}}</td>
                        <td>{{$stock->stock_number}}</td>
                        <td>@if($stock->company!=null){{$stock->company['ar_name']}}@endif</td>
                        <td>@if($stock->bank!=null){{$stock->bank['ar_name']}}@endif</td>
                        <td>@if($stock->user!=null)@if($stock->user->branch!=null){{$stock->user->branch['name']}} @endif @endif</td>
                        <td>@if ($stock->status==0)<label class="btn btn-warning">انتظار</label>@else<label
                                    class="btn btn-success">مفعل</label>@endif</td>
                        <td>{{$stock->created_at}}

                        </td>
                        <td>

                                <div class="" style="text-align: right;">
                                    @if(Auth::User()->hasRole('view_stock'))
                                        <a class="dropdown-item" href="{{url('/stocks/show',$stock->id)}}"
                                           class="btn btn-default" style="margin:5px"><i class="fa fa-eye"></i>
                                            معاينة</a>
                                    @endif
                                    <?php

                                    $time2 = Carbon\Carbon::now()->diffInHours(Carbon\Carbon::parse($stock->created_at));

                                    ?>
                                    @if(Auth::User()->hasRole('update_stock')&&$time2<$setting->expired_date&&$setting->status==1)

                                        <a class="dropdown-item" href="{{url('/stocks/edit',$stock->id)}}"
                                           class="btn btn-primary" style="margin:5px"><i class="fa fa-edit"></i>
                                            تعديل</a>
                                        @elseif(auth()->user()->role_id==1)

                                            <a class="dropdown-item" href="{{url('/stocks/edit',$stock->id)}}"
                                               class="btn btn-primary" style="margin:5px"><i class="fa fa-edit"></i>
                                                تعديل</a>
                                    @endif
                                    @if(Auth::User()->hasRole('delete_stock'))
                                        <form action="{{url('/stocks/destroy',$stock->id)}}" method="post">
                                            @csrf
                                            {{method_field('DELETE')}}
                                            <BUTTON type="submit" class="dropdown-item" style="margin:5px"><i
                                                        class="fa fa-trash"></i> حذف
                                            </BUTTON>
                                        </form>
                                    @endif
                                    @if(Auth::User()->hasRole('update_stock'))
                                        @if($stock->status==0)
                                                <a class="dropdown-item" href="{{url('/stocks/active',$stock->id)}}"
                                                   class="btn btn-primary" style="margin:5px"><i class="fa fa-check"></i>
                                                    تفعيل</a>
                                        @endif
                                    @endif
                                    @if(Auth::User()->role_id==1)
                                        @if($stock->status==1)
                                                <a class="dropdown-item" href="{{url('/stocks/deactive',$stock->id)}}"
                                                   class="btn btn-primary" style="margin:5px"><i class="fa fa-remove"></i>
                                                   الغاء تفعيل</a>
                                        @endif
                                    @endif
                                </div>

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
                @else
                <table class="table">
                    <thead>
                    <tr>
                        <th>رقم الطلب</th>
                        <th>الاسم الكامل</th>
                        <th>الرقم الوطني</th>
                        <th>موبايل</th>
                        <th>الجنسية</th>
                        <th>البنك</th>

                        <th>عدد الاسهم الكلي المكتتب بها</th>
                        <th>عدد المرات المكتتب فيها</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($stocks as $stockk)
                        <tr>

                            @php
                            $stocck=\App\Stock::where('p_number',$stockk->p_number)->get();
                            @endphp
                            @if(count($stocck)>0)
                                <td>
                                @foreach($stocck as $stock)
                                    {{$stock->id}},
                                @endforeach
                                </td>
                                <td>
                                @foreach($stocck as $stock)
                                    {{$stock->full_name.' '.$stock->last_name}},
                                @endforeach
                                </td>
                                <td>
                                    {{$stockk->p_number}}

                                    </td>
                                    <td dir="ltr" style="direction: ltr">

                                        {{$stocck[0]->mobile}}

                                    </td>
                                    <td >

                                        {{$stocck[0]->nation}}

                                    </td>
                                    <td>
                                        @foreach($stocck as $stock)
                                            {{\App\Bank::find($stock->bank_id)->ar_name}},
                                        @endforeach
                                    </td>
                                    <td>

                                        {{$stocck[0]->stock_number}}

                                    </td>

                                    <td>

                                        {{$stockk->count}}

                                    </td>


                                @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        <div class="container col-md-4" style="padding-bottom: 25px;">
            <nav>
                @if($duplicate==0)
                {{$stocks->links()}}
                    @endif

            </nav>

        </div>


    </div>
    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">تفعيل الاكتتاب</h4>
                </div>
                <div class="modal-body">
                    <form id="active-form" action="" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">

                                    <label class="control-label" for="rec_img">صوره الاشعار</label>
                                    <input required type="file" class="form-control" name="rec_img" accept="image/*">

                                    @error('rec_img')
                                    <p style="color: red;">{{$message}}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">

                                    <label class="control-label" for="rec_img">صوره الاكتتاب بعد التوقيع</label>
                                    <input required type="file" class="form-control" name="stock_img" accept="image/*">

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
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="active-submit" type="submit" class="btn btn-success">تفعيل</button>
                </div>
            </div>

        </div>

    </div>
@endsection
@section('js')
    <script>

        $(document).ready(function () {
            @if(request()->type)
$('#type').val("{{request()->type}}")
            @endif
            $('#status').val("{{$status}}")
        });
        $('#myModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var stock_id = button.data('stock'); // Extract info from data-* attributes
            var modal = $(this)
            modal.find('#active-form').attr('action', '{{route('stock.activate')}}' + '/' + stock_id)

        });
        $('#active-submit').on('click', function () {
            $('#active-form').submit();
        })
        $('#type').on('change', function () {
            var url = window.location.href;
            if (url.includes('&type=')) {
                url = url.substr(0, url.indexOf('&type='));
                url = url + '&type=' + $('#type').val();

            } else if (url.includes('?type=')) {


                url = url.substr(0, url.indexOf('?type='));
                url = url + '?type=' + $('#type').val();
            } else {
                if (url.includes('?')) {
                    url = url + '&type=' + $('#type').val();
                } else {
                    url = url + '?type=' + $('#type').val();
                }


            }
//           console.log(url);
            window.location.href = url;

        });
        {{--$('#bank_id').on('change',function () {--}}

            {{--$.ajax({--}}
                {{--type: 'get',--}}
                {{--url: "{{route('getBranchesJson3')}}",--}}
                {{--data: {'_token ':'{{csrf_token()}}',--}}
                    {{--'id':$('#bank_id').val()},--}}
                {{--success: function (data) {--}}
                    {{--console.log(data);--}}
                    {{--$('#branch_id')--}}
                        {{--.find('option')--}}
                        {{--.remove()--}}
                        {{--.end();--}}
                    {{--console.log(data);--}}
                    {{--var option2 = new Option("please select",0);--}}
                    {{--for (var i = 0; i < data.data.length; i++) {--}}
                        {{--var option = new Option(data.data[i].name, data.data[i].id);--}}
                        {{--console.log(option);--}}
                        {{--$(option).html(data.data[i].name);--}}
                        {{--$('#branch_id').append(option);--}}

                    {{--}--}}



                {{--}--}}
            {{--});--}}
        {{--});--}}

    </script>
@endsection