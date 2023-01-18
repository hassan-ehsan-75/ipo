@extends('layouts.print')
@section('title',' طلب اكتتاب')

    @section('s_id')

         | رقم الاكتتاب:{{$stock->id}}

        @endsection

@section('content')
<div class="container" style="">
    <div class="row">
        <div class="col-md-12">
            <p>1- اسم الشركة المصدرة: /{{$stock->company->ar_name}}/<br>
                2- عدد الأسهم المطروحة وسعر الاصدار:<br>
                عدد الاسهم المعروضة: /{{$stock->company->stocks}}/ وقيمتها الاسمية /100/ليرة سورية</p>

        </div>
    </div>
        <div class="row">
        
        <div class="col-md-12">
            <h6>3-المكتتب الطبيعي(افراد):</h6>
            <table class="table table-bordered">
            <thead>
                <th>الاسم الاول</th>
                <th>اسم الأب</th>
                <th>اسم الأم</th>
                <th>تاريخ و مكان الولادة</th>
            </thead>
            <tbody>
                <tr>
                    <td>{{$stock->full_name}}</td>
                    <td>{{$stock->father}}</td>
                    <td>{{$stock->mother}}</td>
                    <td>{{$stock->birthday}}</td>
                </tr>
            </tbody>
        </table>
        </div>
        </div>
        <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>

                    <th>اسم العائلة</th>
                    <th>الجنسية</th>
                    <tH>الجنس</tH>
                </thead>
                <tbody>
                    <tr>

                        <td>{{$stock->last_name}}</td>
                        <td>{{$stock->nation}}</td>
                        <td>{{$stock->gender}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h6>4-بطاقة التعريف:</h6>
                <table class="table table-bordered">
                    <thead>
                        <th>نوع الوثيقة</th>
                        <th>الرقم الوطني</th>
                        <th>جهة الاصدار</th>
                        <th>تاريخ الاصدار</th>
                    </thead>
                    <tbody>
                    <tr>
                        @if($stock->id_type=='اخرى')
                            <td>{{$stock->id_other}}</td>
                        @else
                            <td>{{$stock->id_type}}</td>
                        @endif
                    <td>{{$stock->p_number}}</td>
                    <td>{{$stock->id_from}}</td>
                    <td>{{$stock->id_date}}</td>
                    </tr>
                    
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h6>5-العنوان/الموطن المختار:</h6>
                <table class="table table-bordered">
                    <thead>
                        <th>العنوان</th>
                        <th>المدينة</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$stock->address}}</td>
                            <td>{{$stock->city}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                    <th>هاتف متحرك</th>
                    <th>هاتف ثابت</th>
                    <th>فاكس</th>
                    <th>البريد الالكتروني</th>
                </thead>
                <tbody>
                    <tr>
                    <td style="direction: ltr">{{$stock['mobile']}}</td>
                    <td style="direction: ltr">{{$stock['phone']}}</td>
                    <td style="direction: ltr">{{$stock['fax']}}</td>
                    <td>{{$stock->email}}</td>
                    </tr>
                    
                </tbody>
            </table>
        </div>
        </div>
        <div class="row">
        <div class="col-md-12">
            <h6>6-معلومات عن الاسهم المكتتب بها:</h6>
            <table class="table table-bordered">
                <thead>
                    <th>عدد الأسهم المكتتب بها</th>
                    <th>قيمة الأسهم المكتتبة</th>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$stock->stock_number}}</td>
                        <td>{{$stock->total}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        </div>
        

        <div class="row">
            <div class="col-md-12">
                <p>
                    أقر بأن جميع المعلومات الواردة أعلاه صحيحة كاملة وأوافق على اكتتابي في أسهم (أو إسناد) الشركة أعلاه,
                    هذا وأقر بأنني تسلمت نسخة من نشرة الإصدار والنظام الأساسي, وقد اطلعت على كافة محتوياتها ودرستها بعناية وفهمت مضمونها, 
                    وبناء على ذلك تم اكتتابي بالأسهم أو  (الأسناد) المذكورة, علماً بأنني لا أتنازل
                    عن حقي بمطالبة الشركة والرجوع إليها بكل عطل وضرر ينجم من جراء إضافة معلومات غير صحيحة أو غير كافية
                    في نشرة الإصدار أو نتيجة حذف معلومات قد تؤثر على قبولي بالاكتتاب في حال إضافتها النشرة.
                    <br>
                    هذا وأقر بأنه يحق لكم رفض هذا الطلب في حال عدم تمكنكم من تحصيل قيمة الاكتتاب لأي سبب كان.<br>
                    إن الطلب مستوفي للشروط أعلاه والموقع أصولاً يشكل إيجاباً ملزماً للمكتتب لايحق الرجوع عنه.
                </p>
            </div>
        </div>
        <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td>اسم المكتتب</td>
                        <td>------------</td>
                        <td>توقيع المكتتب</td>
                        <td>--------------</td>
                    </tr>
                    <tr>
                        <td>اسم المفوض عن المكتتب</td>
                        <td>----------------------</td>
                        <td>توقيع المفوض عن المكتتب</td>
                        <td>-----------------------</td>
                    </tr>
                    <tr>
                        <td>بموجب وكالة</td>
                        <td>-------------</td>
                        <td>التاريخ</td>
                        <td>-------------</td>
                    </tr>
                </tbody>
            </table>
        </div>
        </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <p class="text-center">استعمال مستلم الطلب</p>
            <p>
                أقر بأن جميع المعلومات الواردة أعلاه صحيحة كاملة وأوافق على اكتتابي في أسهم (أو نصادق على توقيع المكتتب على هذا الطلب كما ونصادق على مطابقة المعلومات والبيانات والتي وردت في هذا الطلب كما هي مدونة في الوثائق التالية المرفق طيه نسخ مصورة منها:<br>
                1ـ الوثائق الثبوتية المعتمدة إلثبات شخصية المكتتب والمؤشر عليها بإشارة (×) في هذا الطلب<br>
                2ـ نسخة من السند الذي تم التسديد بموجبه والمتعلق بدفع قيمة الاكتتاب بالأسهم المذكورة بموجب هذا الطلب.
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <td>ختم وتوقيع البنك مستلم الطلب</td>
                    <td>------------</td>
                    <td>التاريخ</td>
                    <td>--------------</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    </div>
</div>

@endsection