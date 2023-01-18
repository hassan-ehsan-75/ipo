@extends('layouts.new')
@section('title','الرئيسية')
@section('content') 
<div class="row" style="padding-left:25px;padding-right:25px">

    <div class="col-md-12" style="margin-bottom: 25px;margin-top:20px">
        <h2>{{$companies['ar_name']}}</h2>
    </div>
                <div class="col-md-4">
                    
                <div class="card">
<div class="row">
    <div class="col-md-4">
    <div class="rounded"><img src="images/group.png" width="50px" height="50px"/></div>

    </div>
    <div class="col-md-8">
        <p><strong>عدد المكتتبين</strong></p>
        <p class="info-green">{{$companies['stock_count']}} مكتتب </p>
    </div>
</div>
                </div>
                </div>
                <div class="col-md-4">
                    
                <div class="card">
<div class="row">
    <div class="col-md-4">
    <div class="rounded">

    <img src="images/bar-chart.png" width="50px" height="50px"/>
    </div>

    </div>
    <div class="col-md-8">
        <p><strong>عدد الاسهم المراد الاكتتاب عليها</strong></p>
        <p class="info-green">{{$companies['total_stocks']}} سهم </p>
    </div>
</div>
                </div>
                </div>
                
                <div class="col-md-4">
                    
                <div class="card">
<div class="row">
    <div class="col-md-4">
    <div class="rounded">
    <img src="images/calendar.png" width="50px" height="50px"/>
    </div>

    </div>
    <div class="col-md-8">
        <p><strong>تاريخ انتهاء الاكتتاب</strong></p>
        <p class="info-green">{{$companies['end_date']}} </p>
    </div>
</div>
                </div>
                </div>

            </div>
        </div>
@endsection