@extends('layouts.print')
@section('title','تقرير الاكتتاب')
@section('content')

<div class="container">
    <div class="container col-md-6">
        <div class="row">
            <div class="col-md-4">
                <h5 class="text-center">العدد الكلي للأسهم المطروحة</h5>
                <p class="text-center">{{$total}}</p>
            </div>
            <div class="col-md-4">
                <h5 class="text-center">العدد الكلي للأسهم المكتتب عليها </h5>
                <p class="text-center">{{$registered}}</p>
            </div>
            <div class="col-md-4">
                <h5 class="text-center">عدد الأسهم الغير مكتتب عليها  </h5>
                <p class="text-center">{{$company->stocks - $s}}</p>
            </div>
        </div>
    </div>
    <div class="container">
    <div class="table-responsive">
        <table class="table table-bordered">
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
                    
                </tr>
               @endforeach
            </tbody>
        </table>
    </div>
</div>
    <div id="chartContainer" style="height: 300px; width: 100%;margin-right:200px" class="text-center justify-content-center"></div>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <script>
        window.onload = function() {

            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                title: {
                    text: ""
                },
                data: [{
                    type: "pie",
                    startAngle: 240,

                    indexLabel: "{label} {y}",
                    dataPoints: [
                        @if(isset($data['BanksStocks']))
                        {y: "{{$data['BankStocks']}}", label: "{{$data['bank']->ar_name}}" },
                        {y: "{{$data['BanksStocks']}}", label: "الكل" },
                        @else
                            @foreach($data['stocks'] as $stock)
                        {y: "{{$stock->stocks}}", label: "{{$stock->bank==null?'other':$stock->bank->ar_name}}" },
                            @endforeach
                        @endif

                    ]
                }]
            });
            chart.render();

            setTimeout(function(){   window.print(); }, 2000);
        }
    </script>

@endsection
