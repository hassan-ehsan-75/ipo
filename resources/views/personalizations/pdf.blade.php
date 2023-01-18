<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('assets/css/rtl.css')}}">
    {{--    <link rel="stylesheet" href="{{asset('assets/css/styles.css')}}">--}}

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<style>
    body {
        background-color: #fff;
        line-height: 30px;
        font-family: 'tunisia', fantasy;

    }


    p {
        font-size: 1.3rem;
    }

    b {
        font-size: 1.3rem;
    }

</style>
<body dir="rtl">

<div class="container" style="margin-left: 8%;margin-right: 8%">
    <div class="row">

        <div class="col-md-12 mr-5 ml-5">

            <img src="images/Logo-h.png" class="col-12 text-center"
                 style="width: 32%; margin-right: 32%;">

            <h5 class="text-center col-12"
                style="margin-top: 1%;margin-right: 25%;text-decoration: underline;font-weight: bold"><b>اشعار تخصيص
                    أسهم البنك الوطني الإسلامي</b></h5>

<p style="line-height: 32px">
     السيد المساهم :&nbsp;

                        @if($stock->stock!=null) {{$stock->stock->full_name.' '.$stock->stock->father.' '.$stock->stock->last_name}} @endif
                        المحترم/ة
                   <br>
                        العنوان المختار :&nbsp;

                        @if($stock->stock!=null) {{$stock->stock->city}} / {{$stock->stock->address}}
                        /{{$stock->stock->mobile}} @endif
                    <br>
                        الرقم التسلسلي :&nbsp;

                        @if($stock->stock!=null) {{$stock->sort}}@endif
                    </p>
            <br>
            <p style="margin-top: 12px !important;">
            تحية طيبة وبعد .....
            </p>

            <p class=" mr-5 ml-5">نرجو إعلامكم أنه بموجب قرار هيئة الأوراق والأسواق المالية بكتابها رقم 1302 /ص-إ.م
                بتاريخ 05/10/2021 , فقد تم تخصيص أسهم البنك الوطني الأسلامي حسب الترتيب التالي:<br>
                1 -تخصيص خمسة آلاف سهم لجميع المكتتبين , وهو الحد الأدنى المعلن عنه في نشرة
                الإصدار.<br>
                2 -توزيع الأسهم المتبقية بين المكتتبين زيادة عن خمسة آلاف سهم بنسبة 27.025%<br><br>
                وقد بلغت عدد الأسهم المخصصة لكم :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$stock->total_round}} سهم<br/>
                وبلغت قيمة المبالغ الفائضة الواجبة الرد لكم :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{($stock->stocks_number -$stock->total_round)*100}} ليرة
                سورية<br/><br>
                حيث سيتم إعادتها لكم خلال فترة 60 يوماً من تاريخ إشهار البنك , من خلال مصرف الاكتتاب
                الذي تم الاكتتاب من خلاله.
            <p class="text-center" style="margin-right: 25%">
                وتفضلوا بقبول فائق الاحترام والتقدير
            <p class="text-center" style="margin-right: 35%">عن المؤسسين</p>
            </p>
            </p>
        </div>
    </div>
</div>
<footer>
<img src="images/pattern.png" class="col-12 text-center"
     style="padding: 0;width: 1400px;max-width: 2000px;vertical-align: bottom;margin-top: 185px">
</footer>

<script>


</script>
</body>
</html>

