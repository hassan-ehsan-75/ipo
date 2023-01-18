@extends('layouts.new')
@section('title','البنوك')

@section('content')
<div class="container-fluid">
<div class="container col-md-4" style="text-align: center;">
<h2 style="text-align: center;">البنوك</h2><Br>
@if(Auth::User()->hasRole('create_bank'))
    <div style="display: inline-block;">
        <a type="button" href="{{url('banks/create')}}" class="btn btn-default-big"><i class="fa fa-plus-circle"></i> إضافة جديد</a>
    </div>
    @endif
    {{--@if(Auth::User()->hasRole('delete_bank'))--}}
    {{--<div style="display: inline-block;">--}}
    {{----}}
        {{--<button type="button" onclick="submitDelete()" class="btn btn-danger-big"><i class="fa fa-trash"></i> حذف متعدد</button>--}}
    {{----}}
    {{--</div>--}}
    {{--@endif--}}
</div>
    
</div>
<div class="container shadow" style="padding-top: 25px;margin-top: 30px;">
    {{--<div style="display: inline-block;width:50%;">--}}
    {{--<label>الفرز</label>--}}
    {{--<select class="option-control">--}}
    {{--<option>1</option>--}}
    {{--</select>--}}
    {{--</div>--}}
    <div  style="display: inline-block;width:100%;text-align:center">

        <label>بحث</label>
        <form style="display: inline-block;" method="GET" action="{{url('/banks')}}">
            <input type="text" class="option-control" name="search" value="{{request('search')}}">
            <button type="submit" class="btn btn-secondary option-control mb-1">ابحث</button>
        </form>
    
</div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>الاسم بالانكليزية</th>
                    <th>الاسم بالعربية</th>
                    <th>رمز البنك</th>
                    <th>الاجراءات</th>
                </tr>
            </thead>
            <tbody>
            @foreach($banks as $bank)
                <tr>
                    <td>{{$bank->en_name}}</td>
                    <td>{{$bank->ar_name}}</td>
                    <td>{{$bank->code}}</td>
                    <td>
                    <div class="dropdown">
  <a type="button" class="dropdown-toggle" data-toggle="dropdown">
  الإجراءات
</a>
  <div class="dropdown-menu" style="text-align: right;">
  @if(Auth::User()->hasRole('view_bank'))
                        <a  class="dropdown-item" href="{{url('/banks/show',$bank->id)}}" class="btn btn-default" style="margin:5px"><i class="fa fa-eye"></i> معاينة</a>
                        @endif
                        @if(Auth::User()->hasRole('update_bank'))
                        <a class="dropdown-item" href="{{url('/banks/edit',$bank->id)}}" class="btn btn-primary" style="margin:5px"><i class="fa fa-edit"></i> تعديل</a>
                        @endif
                        @if(Auth::User()->hasRole('delete_bank'))
                        <form action="{{url('/banks/destroy',$bank->id)}}" method="POST">
                            @csrf
                            {{method_field('DELETE')}}
                            <BUTTON type="submit"  class="dropdown-item" style="margin:5px"><i class="fa fa-trash"></i> حذف</BUTTON>
                        
                        @endif
  </div>
</div></td>
                </tr>
                @endforeach
            </form>
            </tbody>
        </table>
    </div>
    <div class="container col-md-4" style="padding-bottom: 25px;">
    <nav>
    {{ $banks->links() }}
</nav>
    </div>
</div>
@endsection
@section('js')
@if(Auth::User()->hasRole('delete_bank'))
<script>
function submitDelete(){
    $("#deleteBulk").submit();
}
    </script>
@endif
@endsection