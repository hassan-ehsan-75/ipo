@extends('layouts.new')
@section('title','تقارير الاكتتاب')
@section('content')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/excellentexport@3.4.3/dist/excellentexport.min.js"></script>
<div class="container-fluid">
    <h1 class="text-center">تقارير الاكتتاب</h1>
    <form action="{{url('/reports/stocks/print')}}" method="GET">
    @csrf
    <div class="row">
        <div class="col-md-3">
            <label class="control-label">بنك</label>
            <select class="form-control" name="bank">
            <option value="all">الكل</option>
                @foreach($banks as $bank)
                    <option value="{{$bank->id}}">{{$bank->ar_name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label class="control-label">عدد الاسهم</label>
            <input type="text" class="form-control" name="num">
        </div>
        <div class="col-md-2">
            <label class="control-label">قيمة مالية</label>
            <input type="text" class="form-control" name="price">
        </div>
        <div class="col-md-2">
            <label class="control-label">تاريخ</label>
            <input type="date" class="form-control" name="date">
        </div>
        <div class="form-group text-center col-md-2 pull-left" style="padding-top: 2%">
            <button type="submit" class="btn btn-default-big">طباعة</button>
        </div>
    </div>
    </form>

        <br>

    <form action="{{url('/reports/stocks')}}" method="GET" id="export">
        @csrf
    <div class="row">
        <div class="col-md-3">
            <label class="control-label">بنك</label>
            <select class="form-control" name="bankx" onchange="document.getElementById('export').submit()">
                <option value="all">الكل</option>
                @foreach($banks as $bank)
                    <option value="{{$bank->id}}">{{$bank->ar_name}}</option>
                @endforeach
            </select>
        </div>

            <div class="form-group text-center col-md-3 pull-right">
                <table id="datatable" hidden style="display: none">
                    <tr>
                        <td>رقم الطلب</td>
                        @if(auth()->user()->role_id!=6)
                            <td>الاسم الكامل</td>
                            <td>موبايل</td>
                            <td>هاتف</td>
                        @endif
                        <td>الجنسية</td>
                        <td>القيمة المالية </td>
                        <td>عدد الاسهم المراد الاكتتاب عليها</td>
                        <td>الشركة المقدم عليها</td>
                        <td>البنك المسجل</td>
                        <td>الفرع</td>
                        <td>تاريخ الإدخال</td>
                    </tr>
                    @foreach($stocks as $stock)
                        <tr>
                            <td>{{$stock->id}}</td>
                            @if(auth()->user()->role_id!=6)
                                <td>{{$stock->full_name.' '.$stock->last_name}}</td>
                                <td>{{$stock->mobile}}</td>
                                <td>{{$stock->phone}}</td>
                            @endif
                            <td>{{$stock->nation}}</td>
                            <td>{{$stock->total}}</td>
                            <td>{{$stock->stock_number}}</td>
                            <td>@if($stock->company!=null){{$stock->company['ar_name']}}@endif</td>
                            <td>@if($stock->bank!=null){{$stock->bank['ar_name']}}@endif</td>
                            <td>@if($stock->bank!=null){{$stock->bank['ar_name']}}@endif</td>
                                <td>@if($stock->user!=null)@if($stock->user->branch!=null){{$stock->user->branch['name']}} @endif @endif</td>
                            <td>{{$stock->created_at}}</td>
                        </tr>
                    @endforeach
                </table>
                <div class="form-group text-center col-md-3 pull-left" style="padding-top: 2%">
                    <a download="report.xls" href="#" class="btn btn-default-big" onclick="return ExcellentExport.excel(this, 'datatable', 'تقرير');">تصدير</a>
                </div>
            </div>


    </div>
    </form>


<div class="container shadow" style="padding-top: 25px;margin-top: 30px;">
    <div style="display: inline-block;width:50%;">
        {{--<label>الفرز</label>--}}
        {{--<select class="option-control">--}}
            {{--<option>1</option>--}}
        {{--</select>--}}
    </div>
    <div  style="display: inline-block;float: left;width:50%;text-align:left">
    
        <label>بحث</label>
        <form style="display: inline-block;" method="GET" action="{{url('/reports/stocks')}}">
        <input type="text" class="option-control" name="search" value="{{request('search')}}">
        </form>
    
</div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>رقم الطلب</th>
                    @if(auth()->user()->role_id!=6)
                    <th>الاسم الكامل</th>
                    <th>موبايل</th>
                    <th>هاتف</th>
                    @endif
                        <th>الجنسية</th>
                    <th>القيمة المالية </th>
                    <th>عدد الاسهم المكتتب بها</th>
                    <th>الشركة المقدم عليها</th>
                    <th>البنك المسجل</th>
                     <th>الفرع</th>
                    <th>تاريخ الإدخال</th>
                    <th>الاجراءات</th>
                </tr>
            </thead>
            <tbody>
            @foreach($stocks as $stock)
                <tr>
                    <td>{{$stock->id}}</td>
                    @if(auth()->user()->role_id!=6)
                    <td>{{$stock->full_name.' '.$stock->last_name}}</td>
                    <td>{{$stock->mobile}}</td>
                    <td>{{$stock->phone}}</td>
                    @endif
                        <td>{{$stock->nation}}</td>
                    <td>{{$stock->total}}</td>
                    <td>{{$stock->stock_number}}</td>
                    <td>@if($stock->company!=null){{$stock->company['ar_name']}}@endif</td>
                    <td>@if($stock->bank!=null){{$stock->bank['ar_name']}}@endif</td>
                        <td>@if($stock->user!=null)@if($stock->user->branch!=null){{$stock->user->branch['name']}} @endif @endif</td>
                    <td>{{$stock->created_at}}</td>
                    <td>
                    <div class="dropdown">
  <a type="button" class="dropdown-toggle" data-toggle="dropdown">
  الإجراءات
</a>
  <div class="dropdown-menu" style="text-align: right;">
  @if(Auth::User()->hasRole('view_stock'))
                        <a  class="dropdown-item" href="{{url('/stocks/show',$stock->id)}}" class="btn btn-default" style="margin:5px"><i class="fa fa-eye"></i> معاينة</a>
                        @endif
                        @if(Auth::User()->hasRole('update_stock'))
                        <a class="dropdown-item" href="{{url('/stocks/edit',$stock->id)}}" class="btn btn-primary" style="margin:5px"><i class="fa fa-edit"></i> تعديل</a>
                        @endif
                        @if(Auth::User()->hasRole('delete_stock'))
                        <form action="{{url('/stocks/destroy',$stock->id)}}" method="post">
                            @csrf
                            {{method_field('DELETE')}}
                            <BUTTON type="submit"  class="dropdown-item" style="margin:5px"><i class="fa fa-trash"></i> حذف</BUTTON>
                        </form>
                        @endif
  </div>
</div> </td>
                </tr>
               @endforeach
            </tbody>
        </table>
    </div>
    <div class="container col-md-4" style="padding-bottom: 25px;">
    <nav>

</nav>
    </div>
</div>
</div>

@endsection