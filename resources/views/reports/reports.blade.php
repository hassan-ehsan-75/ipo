@extends('layouts.new')
@section('title','التقارير')
@section('content')

<div class="container-fluid">
    <div class="container col-md-6 text-center">
        <h1 class="text-center">التقارير</h1>
        <div style="display: inline-block;">
            <a type="button" href="{{url('/reports/stocks')}}" class="btn btn-default-big">تقارير الاكتتاب</a>
        </div>
        <div style="display: inline-block;">
            <button type="button"  data-toggle="modal" data-target="#bank" class="btn btn-default-big">تقارير البنوك</button>
        </div>
        <div style="display: inline-block;">
            <button type="button" class="btn btn-default-big" data-toggle="modal" data-target="#branch">تقارير أفرع البنوك</button>
        </div>
        </div>
    
      <!-- The Modal -->
<div class="modal fade" id="bank">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">تقارير البنك</h4>
        <button type="button" class="close" data-dismiss="modal" style="float: left;margin:auto -1rem -1rem -1rem">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body text-center">
        <form method="GET" action="{{url('/reports/banks/print')}}">
            <div class="form-group">
                <select class="form-control" name="bank_id">
                    @foreach($banks as $bank)
                        <option value="{{$bank->id}}">{{$bank->ar_name}}</option>
                    @endforeach
                </select>
            </div>
        
      </div>

      <!-- Modal footer -->
      <div class="modal-footer text-center">
        <button type="submit" class="btn btn-default btn-lg">موافق</button>
    
      </div>
      </form>
    </div>
  </div>
</div>     
      <!-- The Modal -->
      <div class="modal fade" id="branch">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">تقارير فرع البنك</h4>
        <button type="button" class="close" data-dismiss="modal" style="float: left;margin:auto -1rem -1rem -1rem">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body text-center">
        <form method="GET" action="{{url('/reports/branches/print')}}">
            <div class="form-group">
                <select class="form-control" name="branch_id">
                    @foreach($branches as $branch)
                        <option value="{{$branch->id}}">{{$branch->name.'('.$branch->bank->ar_name.')'}}</option>
                    @endforeach
                </select>
            </div>
        
      </div>

      <!-- Modal footer -->
      <div class="modal-footer text-center">
        <button type="submit" class="btn btn-default btn-lg">موافق</button>
    
      </div>
      </form>
    </div>
  </div>
</div>   
</div>
@endsection