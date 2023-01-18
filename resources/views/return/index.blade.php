@extends('layouts.new')
@section('title','الرديات')

@section('content')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/excellentexport@3.4.3/dist/excellentexport.min.js"></script>
    <div class="container-fluid">
        @if(Auth::User()->hasRole('create_role'))
            <h1 class="text-center">الرديات</h1>

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

            <div style="display: inline-block;width:100%;text-align:center" class="col-3 row">

                <label class="col-md-12">بحث</label>
                <form style="display: inline-block;" method="GET" action="{{url('/return')}}" class="col-md-12">
                    <input type="text" class="option-control" name="search" value="{{request('search')}}"
                           style="min-height: 38px">
                    <button type="submit" class="btn btn-secondary option-control mb-1">ابحث</button>
                </form>
            </div>
            <div style="display: inline-block;width:100%;" class="col-2 row ml-1">
                <label for="type" class="col-md-12">الفرز حسب البنك</label>
                <select class="option-control col-md-12" name="type" style="height: 50%" id="bank_id" onchange="window.location.href='{{url('/return/')}}'+'/'+this.value">
                    <option value="0">الكل</option>
                    @foreach(\App\Bank::all() as $bankk)
                        <option  @if($bank==$bankk->id) selected @endif value="{{$bankk->id}}">{{$bankk->ar_name}}</option>
                    @endforeach
                </select>
            </div>
            <div style="display: inline-block;width:100%;" class="col-2 row ml-1">
                <label for="type" class="col-md-12">الفرز حسب الفرع</label>
                <select class="option-control col-md-12" name="type" style="height: 50%" id="branch_id"  onchange="window.location.href='{{url('/return/'.$bank.'/')}}/'+this.value">
                    <option value="0">الكل</option>
                    @if($bank!=null)
                        @foreach(\App\BankBranch::where('bank_id',$bank)->get() as $bran)
                            <option @if($branch==$bran->id) selected @endif value="{{$bran->id}}">{{$bran->name}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            @if($branch!=0||$bank!=0)
                <div style="display: inline-block;width:100%;" class="col-2 row ml-1">
                    <label for="type" class="col-md-12">التصدير</label>
                    <table id="datatable" hidden style="display: none">
                        <thead>
                        <tr>
                            <th>رقم الطلب</th>
                            <th>الاسم الكامل</th>
                            <th>البنك</th>
                            <th>فرع البنك</th>
                            <th>القيمة المالية</th>
                            <th>عدد الاسهم المراد الاكتتاب عليها</th>
                            <th>عدد الاسهم الفائضه</th>
                            <th>اجمالي الاسهم</th>
                            <th>التقريب</th>
                            <th>الرديات </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($stocks as $stock)
                            <tr>
                                <td>{{$stock->stock_id}}</td>
                                <td>@if($stock->stock!=null){{$stock->stock->full_name.' '.$stock->stock->last_name}}@endif</td>
                                <td>@if($stock->stock!=null){{$stock->stock->bank->ar_name}}@endif</td>
                                <td>@if($stock->stock!=null){{$stock->stock->user->branch->name}}@endif</td>
                                <td>{{$stock->total}}</td>
                                <td>{{$stock->stocks_number}}</td>
                                <td>{{$stock->stocks_number -$stock->total_round}}</td>
                                <td>{{$stock->total_stocks}} </td>
                                <td>{{($stock->stocks_number -$stock->total_round)*100}} </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="form-group text-center col-md-3 " style="padding-top: 2%">
                        <a download="report.xls" href="#" class="btn btn-default-big" onclick="return ExcellentExport.excel(this, 'datatable', 'تقرير');">تصدير</a>
                    </div>
                </div>
                @endif
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>رقم الطلب</th>
                    <th>الاسم الكامل</th>
                    <th>البنك</th>
                    <th>فرع البنك</th>
                    <th>القيمة المالية</th>
                    <th>عدد الاسهم المراد الاكتتاب عليها</th>
                    <th>عدد الاسهم الفائضه</th>
                    <th>اجمالي الاسهم</th>
                    <th>الرديات </th>
                </tr>
                </thead>
                <tbody>
                @foreach($stocks as $stock)
                    <tr>
                        <td>{{$stock->stock_id}}</td>
                        <td>@if($stock->stock!=null){{$stock->stock->full_name.' '.$stock->stock->last_name}}@endif</td>
                        <td>@if($stock->stock!=null){{$stock->stock->bank->ar_name}}@endif</td>
                        <td>@if($stock->stock!=null){{$stock->stock->user->branch->name}}@endif</td>
                        <td>{{$stock->total}}</td>
                        <td>{{$stock->stocks_number}}</td>
                        <td>{{$stock->stocks_number -$stock->total_round}}</td>
                        <td>{{$stock->total_stocks}} </td>
                        <td>{{($stock->stocks_number -$stock->total_round)*100}} </td>

                        {{--<td>--}}

                            {{--<div class="" style="text-align: right;">--}}
                                {{--@if(Auth::User()->hasRole('view_stock'))--}}
                                    {{--<a class="dropdown-item" href="{{url('/stocks/show',$stock->id)}}"--}}
                                       {{--class="btn btn-default" style="margin:5px"><i class="fa fa-eye"></i>--}}
                                        {{--معاينة</a>--}}
                                {{--@endif--}}
                            {{--</div>--}}

                        {{--</td>--}}
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
        <div class="container col-md-4" style="padding-bottom: 25px;">
            <nav>
                @if($branch==0&&$bank==0)
                {{$stocks->links()}}
                    @endif

            </nav>

        </div>


    </div>
    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog" >
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">الاستيراد</h4>
                </div>
                <div class="modal-body">
                    <form id="active-form" action="" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">

                                    <label class="control-label" for="rec_img">الملف</label>
                                    <input required type="file" class="form-control" name="file" >

                                    @error('file')
                                    <p style="color: red;">{{$message}}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="active-submit" type="submit" class="btn btn-success">استيراد</button>
                </div>
            </div>

        </div>

    </div>
@endsection
@section('js')
    <script>

        $('#myModal').on('show.bs.modal', function (event) {
            // Extract info from data-* attributes
            var modal = $(this)
            modal.find('#active-form').attr('action', '{{route('personalization.store')}}')

        });
        $('#active-submit').on('click', function () {
            $('#active-form').submit();
        });

    </script>
@endsection