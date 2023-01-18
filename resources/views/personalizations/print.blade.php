<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/fonts/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/rtl.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/Sidebar-Menu-1.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/Sidebar-Menu.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/styles.css')}}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<style>
    body{
        background-color: #fff;
        margin: 5%;
    }
    .table td, .table th{
        padding: 0.25rem !important;
    }
    p{
        font-size: 1.5rem;
    }
</style>
<body onload="print()">
<div class="row">

    <img  src="{{asset('images/comp.png')}}" class="col-12 text-center" width="75" style="width: 74px;max-width: 20%;height: 60px;margin-right: 40%;">
<br/><br/>
    <h5 class="text-center col-12" style="text-decoration: underline;margin-top: 1%"><b>اشعار تخصيص أسهم البنك الوطني الإسلامي</b></h5>
    <br>
    <h5 class="text-center col-12" style="text-decoration: underline;margin-top: 1%"><b>رقم تسلسلي {{$stock->id}}</b></h5>
</div>
<div class="container" style="">
    <div class="row">
        <div class="col-md-12 mr-5 ml-5">

            <p>
                السيد المساهم@if($stock->stock!=null) {{$stock->stock->full_name.' '.$stock->stock->father.' '.$stock->stock->last_name}} @endif المحترم:
                <br/>
                العنوان المختار:@if($stock->stock!=null) {{$stock->stock->city}} / {{$stock->stock->address}} /{{$stock->stock->mobile}} @endif <br/>
                تحية طيبة وبعد .....<br/>
            </p>

        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <p class=" mr-5 ml-5">نرجو إعلامكم أنه بموجب قرار هيئة الأوراق والأسواق المالية بكتابها رقم 1302 /ص-إ.م<br>
                بتاريخ 05/10/2021 , فقد تم تخصيص أسهم البنك الوطني الأسلامي حسب الترتيب التالي:<br>
                1 -تخصيص خمسة آلاف سهم لجميع المكتتبين , وهو الحد الأدنى المعلن عنه في نشرة<br>
                الإصدار.<br>
                2 -توزيع الأسهم المتبقية بين المكتتبين زيادة عن خمسة آلاف سهم بنسبة  27.025%<br>
                <br>

                وقد بلغت عدد الأسهم المخصصة لكم :{{$stock->total_round}} سهم<br/>
                وبلغت قيمة المبالغ الفائضة الواجبة الرد لكم :{{($stock->stocks_number -$stock->total_round)*100}}  ليرة سورية<br/>
                حيث سيتم إعادتها لكم خلال فترة 60 يوماً من تاريخ إشهار البنك , من خلال مصرف الاكتتاب
                الذي تم الاكتتاب من خلاله.
                <br/>
            <p  class="text-center">
                وتفضلوا بقبول فائق الاحترام والتقدير<br/>
                عن المؤسسين
            </p>
            </p>
        </div>
    </div>

</div>
</div>

<script>



</script>
</body>
</html>

