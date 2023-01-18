@extends('layouts.new')
@section('title','تعديل تخصيص')
@section('content')
<div class="container-fluid">
    <div class="container col-md-5">
        <h5 class="text-center">تعديل تخصيص</h5>
    </div>

    <div class="container">
        <form method="POST" action="">
            <div class="row">
                <div class="col-md-6">
                <div class="form-group">
                                    
                                    <label class="control-label" for="name">الرقم الاساسي</label>
                                                                                                                <input required="" type="text" class="form-control" name="number" placeholder="الرقم الاساسي" value="">


                                                                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                    <label class="control-label">الشركة</label>
                    <select class="form-control" disabled>
                        <option>لايوجد</option>
                    </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                <div class="form-group">
                                    
                                    <label class="control-label" for="name">يساوي او اقل من الرقم الاساسي(بالمئه)</label>
                                                                                                                <input type="text" class="form-control" name="first_num" placeholder="يساوي او اقل من الرقم الاساسي(بالمئه)" value="">


                                                                    </div>
                </div>
                <div class="col-md-6">
                <div class="form-group">
                                    
                                    <label class="control-label" for="name">اكبر من الرقم الاساسي(بالمئه)</label>
                                                                                                                <input type="text" class="form-control" name="second_num" placeholder="اكبر من الرقم الاساسي(بالمئه)" value="">


                                                                    </div>
                    </div>
            </div>
            <div class="form-group text-center">
            <button type="submit" class="btn btn-primary-big">حفظ</button>
            </div>
        </form>
    </div>
</div>
@endsection