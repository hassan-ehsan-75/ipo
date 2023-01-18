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
}
.table td, .table th{
    padding: 0.25rem !important;
}
</style>
<body onload="print()">
<div class="row" style="    margin-left: 30%;">
    <img src="{{asset('images/comp.png')}}" class="col-3 pull-right" style="width:125px;height: 75px;">
<p class="text-center col-9"  >@yield('title')   |تاريخ الطباعة: <?php echo date('Y/m/d');?> @yield('s_id')</p>

</div>
@yield('content')

<script>

         

      </script>
</body>
</html>