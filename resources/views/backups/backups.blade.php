@extends('layouts.new')
@section('title','النسخ الاحطياتي')
@section('content')
<div class="container-fluid" style="padding-top: 25px; text-align:center">
<div class="container col-md-4" style="text-align: center;">
<h2 style="text-align: center;">النسخ الاحطياتي</h2><Br>
<a href="{{url('backups/backup')}}" class="btn btn-primary">انشاء نسخه احتياطية</a>
    {{--<a  class="btn btn-secondary" style="margin:5px"   data-toggle="modal" data-target="#myModal">استيراد نسخة احتياطية</a>--}}
</div>
    @if(session()->has('success'))
        <div class="form-group text-center mt-1">
            <label class="alert alert-success">{{ session()->get('success')}}</label>
        </div>
    @endif
    @if(count($errors)>0)
        <div class="form-group text-center mt-1">
            <label class="alert alert-success">{{ $errors->first()}}</label>
        </div>
    @endif
<div class="container shadow" style="margin-top: 15px;">
<div class="container col-md-5">
    {{--<div style="display: inline-block;width:50%;">--}}
    {{--<label>الفرز</label>--}}
    {{--<select class="option-control">--}}
    {{--<option>1</option>--}}
    {{--</select>--}}
    {{--</div>--}}

</div>
<div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>الملف</th>
                    <th>تاريخ الانشاء</th>
                    <th>الاجراءات</th>
                </tr>
            </thead>
            <tbody>
            @foreach($backups as $backup)
                <tr>
                    <td>{{str_replace('public/backup/','',$backup->file)}}</td>
                    <td>{{$backup->created_at}}</td>
                    <td><a href="{{asset('storage/'.$backup->file)}}" download>تحميل</a></td>
we                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="container col-md-4" style="padding-bottom: 25px;">
    <nav>
    {{$backups->links()}}
</nav>
    </div>
</div>
</div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">استيراد نسخه احتياطيه</h4>
            </div>
            <div class="modal-body">
                <form id="active-form" action="{{url('backups/import')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-9">
                            <div class="form-group">

                                <label class="control-label" for="file">الملف</label>
                                <input required type="file" class="form-control" name="file" >

                                @error('identity_img')
                                <p style="color: red;">{{$message}}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="active-submit" type="submit" class="btn btn-success" >استيراد</button>
            </div>
        </div>

    </div>
</div>
@endsection
@section('js')
    <script>

        $('#active-submit').on('click',function () {
            $('#active-form').submit();
        })
    </script>
@endsection