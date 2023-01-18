@extends('layouts.print')
@section('title','تقرير الاكتتاب')
@section('content')
    <div class="container">
    <div class="row">
            <div class="col-md-3">
                <h5 class="text-center">العدد الكلي  للمكتتبين</h5>
                <p class="text-center">{{$bank[0]->total_stock}}</p>
            </div>
            <div class="col-md-3">
                <h5 class="text-center">العدد الكلي للأسهم المكتتب عليها</h5>
                <p class="text-center">{{$bank[0]->total_number}}</p>
            </div>
            <div class="col-md-3">
                <h5 class="text-center">القيمة المالية</h5>
                <p class="text-center">{{$bank[0]->total}}</p>
            </div>
            <div class="col-md-3">
                <h5 class="text-center">عدد الأسهم الغير  مكتتب عليها  </h5>
                <p class="text-center">{{$company->stocks-$s}}</p>
            </div>
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
                        @foreach($BanksStocksB as $BanksStockb)
                        {y: "{{$BanksStockb->sum}}", label: "{{$BanksStockb->name}}" },
                        @endforeach

                    ]
                }]
            });
            chart.render();

            setTimeout(function(){   window.print(); }, 2000);
        }
    </script>
@endsection