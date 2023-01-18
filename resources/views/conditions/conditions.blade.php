@extends('layouts.new')
@section('title','تخصيص')
@section('content')
<div class="container-fluid" style="padding-top: 25px; text-align:center">
<div class="container col-md-4" style="text-align: center;">
<h2 style="text-align: center;">تخصيص</h2><Br>
    <div style="display: inline-block;">
        <a type="button" href="{{route('conditions.create')}}" class="btn btn-default-big"><i class="fa fa-plus-circle"></i> إضافة جديد</a>
    </div>
    <div style="display: inline-block;">
        <button type="button" class="btn btn-danger-big"><i class="fa fa-trash"></i> حذف متعدد</button>
    </div>
</div>
<div class="container shadow" style="margin-top: 15px;">
<div class="container col-md-5">
    <div style="display: inline-block;width:50%">
    <p>
    <label><strong>عرض</strong></label>
    <select class="form-control" style="width:50%;display:inline-block">
        <option>10</option>
    </select>
    <label><strong>عنصر</strong></label>
    </p>
</div>
<div style="display: inline-block;width:40%">
    <p>
    <label><strong>بحث</strong></label>
    <input type="text" class="form-control" style="width:50%;display:inline-block">
    </p>
</div>
</div>
<div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>الرقم الأساسي</th>
                    <th>الشركة</th>
                    <th>
                                                                                                يساوي او اقل من الرقم الاساسي(بالمئه)
                                                                                        </th>
                    <th>أكبر من الرقم الأساسي (بالمئة)</th>
                    <th>الاجراءات</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Cell 2</td>
                    <td>Cell 1</td>
                    <td>Cell 2</td>
                    <td>Cell 1</td>
                    <td>Cell 2</td>
                </tr>
                <tr>
                    <td><input type="checkbox"></td>
                    <td>Cell 4</td>
                    <td>Cell 1</td>
                    <td>Cell 2</td>
                    <td>Cell 1</td>
                    <td>Cell 2</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="container col-md-4" style="padding-bottom: 25px;">
    <nav>
    <ul class="pagination">
        <li class="page-item"><a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
        <li class="page-item"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item"><a class="page-link" href="#">4</a></li>
        <li class="page-item"><a class="page-link" href="#">5</a></li>
        <li class="page-item"><a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li>
    </ul>
</nav>
    </div>
</div>
</div>
@endsection