@extends('layouts.new')
@section('title','معاينة الاكتتاب')
@section('content')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/excellentexport@3.4.3/dist/excellentexport.min.js"></script>
<div class="container-fluid">
    <div class="container col-md-7">
        <h5 class="text-center">
            معاينة الاكتتاب
        </h5><br>
        <div class="row justify-content-center">
        @if(Auth::User()->hasRole('update_stock'))
            <div class="col-md-3 text-center">
                <a type="button" href="{{url('/stocks/edit',$stock->id)}}" class="btn btn-primary"><i class="fa fa-edit"></i> تعديل</a>
            </div>
        @endif
        @if(Auth::User()->hasRole('delete_stock'))
            <div class="col-md-3 text-center">
                <a type="button"  class="btn btn-danger"><i class="fa fa-trash"></i> حذف</a>
            </div>
        @endif
        @if(Auth::User()->hasRole('view_stock'))
        <div class="col-md-3 text-center">
                <a href="{{url('/reports/singleStock',$stock->id)}}" type="button" class="btn btn-secondary"><i class="fa fa-print"></i> طباعة</a>
            </div>
            <div class="col-md-3 text-center">
                <a href="{{url('/stockss')}}" type="button" class="btn btn-default"><i class="fa fa-list"></i> العودة</a>
            </div>
        @endif
        </div>
    </div>
    <div class="container shadow" style="margin-top: 20px;padding-top:15px;padding-bottom:15px">
    <div class="row">
        <div class="col-md-12">
            <p>1- <strong>اسم الشركة المصدرة:</strong> /{{$stock->company->ar_name}}/ </p>
            <p>2- <strong>عدد الأسهم المطروحة وسعر الاصدار:</strong></p>
            <p>عدد الاسهم المعروضة: /{{$stock->company->min_stock}}/ وقيمتها الاسمية /</p>
        </div>
    </div>
    <hr>
        <div class="row">
        
        <div class="col-md-12">
            <h5>3-المكتتب الطبيعي</h5>
            <table class="table table-bordered">
            <thead>
                <th>الاسم</th>
                <th>اسم الأب</th>
                <th>اسم الأم</th>
                
            </thead>
            <tbody>
                <tr>
                    <td>{{$stock->full_name}}</td>
                    <td>{{$stock->father}}</td>
                    <td>{{$stock->mother}}</td>
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
                </thead>
                <tbody>
                    <tr>
                        <td>{{$stock->last_name}}</td>
                        <td>{{$stock->nation}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead>
                        <th>مكان وتاريخ الولادة</th>
                        <tH>الجنس</tH>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$stock->birthday}}</td>
                            <td>{{$stock->gender}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h5>4-بطاقة التعريف</h5>
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
                <h5>5-العنوان/الموطن المختار</h5>
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
                    <th>موبايل</th>
                    <th>هاتف</th>
                    <th>فاكس</th>
                    <th>البريد الالكتروني</th>
                </thead>
                <tbody>
                    <tr>
                    <td dir="ltr" style="direction: ltr">{{$stock->mobile}}</td>
                    <td dir="ltr" style="direction: ltr">{{$stock->phone}}</td>
                    <td dir="ltr" style="direction: ltr">{{$stock->fax}}</td>
                    <td>{{$stock->email}}</td>
                    </tr>
                    
                </tbody>
            </table>
        </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead>
                    @if($stock->identity_img)
                        <th>صورة الهوية</th>
                    @endif
                    @if($stock->family_img)

                        <th>صورة البيان العائلي</th>
                    @endif

                    </thead>
                    <tbody>
                    <tr>
                        @if($stock->identity_img)

                            @if(strpos($stock->identity_img, '.pdf') !== false)
                                <td dir="ltr" style="direction: ltr"><a  href="{{asset('storage/'.$stock->identity_img)}}" download=""> تحميل</a></td>
                                @else
                                <td dir="ltr" style="direction: ltr"><img onclick="window.open('{{asset('storage/'.$stock->identity_img)}}')" width="100%" style="height:300px" src="{{asset('storage/'.$stock->identity_img)}}"></td>
                                @endif
                        @endif
                        @if($stock->family_img)
                                @if(strpos($stock->family_img, '.pdf') !== false)
                                    <td dir="ltr" style="direction: ltr"><a  href="{{asset('storage/'.$stock->family_img)}}" download=""> تحميل</a></td>
                                @else
                            <td dir="ltr" style="direction: ltr"><img onclick="window.open('{{asset('storage/'.$stock->family_img)}}')" width="100%" style="height:300px" src="{{asset('storage/'.$stock->family_img)}}"></td>
                                    @endif

                        @endif

                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead>
                    @if($stock->procuration_img)

                        <th>صورة التفويض</th>
                    @endif
                    @if($stock->civil_img)
                        <th>صورة اخراج القيد المدني</th>
                    @endif
                    </thead>
                    <tbody>
                    <tr>


                        @if($stock->procuration_img)
                                @if(strpos($stock->procuration_img, '.pdf') !== false)
                                <td dir="ltr" style="direction: ltr"><a  href="{{asset('storage/'.$stock->procuration_img)}}" download=""> تحميل</a></td>
                                    @else
                                <td dir="ltr" style="direction: ltr"><img onclick="window.open('{{asset('storage/'.$stock->procuration_img)}}')" width="100%" style="height:300px"  src="{{asset('storage/'.$stock->procuration_img)}}"></td>
                                    @endif
                        @endif
                        @if($stock->civil_img)
                                @if(strpos($stock->civil_img, '.pdf') !== false)
                                    <td dir="ltr" style="direction: ltr"><a  href="{{asset('storage/'.$stock->civil_img)}}" download=""> تحميل</a></td>
                                @else
                            <td dir="ltr" style="direction: ltr"><img onclick="window.open('{{asset('storage/'.$stock->civil_img)}}')" width="100%" style="height:300px" src="{{asset('storage/'.$stock->civil_img)}}"></td>
                                    @endif
                        @endif
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
        @if($stock->activeStock!=null)
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead>
                    @if($stock->activeStock->stock_img)

                        <th>صوره الاكتتاب بعد التوقيع</th>
                    @endif
                    @if($stock->activeStock->rec_img)
                        <th>صوره الاشعار</th>
                    @endif
                    </thead>
                    <tbody>
                    <tr>


                        @if($stock->activeStock->stock_img)
                                @if(strpos($stock->activeStock->stock_img, '.pdf') !== false)
                                <td dir="ltr" style="direction: ltr"><a  href="{{asset('storage/'.$stock->activeStock->stock_img)}}" download=""> تحميل</a></td>
                                    @else
                                <td dir="ltr" style="direction: ltr"><img onclick="window.open('{{asset('storage/'.$stock->activeStock->stock_img)}}')" width="100%" style="height:300px"  src="{{asset('storage/'.$stock->activeStock->stock_img)}}"></td>
                                    @endif
                        @endif
                        @if($stock->activeStock->rec_img)
                                @if(strpos($stock->activeStock->rec_img, '.pdf') !== false)
                                    <td dir="ltr" style="direction: ltr"><a  href="{{asset('storage/'.$stock->activeStock->rec_img)}}" download=""> تحميل</a></td>
                                @else
                            <td dir="ltr" style="direction: ltr"><img onclick="window.open('{{asset('storage/'.$stock->activeStock->rec_img)}}')" width="100%" style="height:300px" src="{{asset('storage/'.$stock->activeStock->rec_img)}}"></td>
                                    @endif
                        @endif
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
        @endif
        <div class="row">
        <div class="col-md-12">
            <h5>6-معلومات عن الاسهم المكتتب بها</h5>
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
    </div>
</div>
@endsection