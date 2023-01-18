@extends('layouts.app_no_nav')

@section('content')
    <div class="container-fluid" style="height: 100%;">
        <div class="row"  style="height: 100%;padding: 0">
            <div class="col-md-3" style="min-height: 100%;">
                <div class="card" style="max-width: 13rem;background: none;border: none;margin: 0 auto">
                    <img src="{{asset('images/app_images/ella_logo.png')}}" class="card-img-top" style="width: 100%;margin: 0 auto;margin-top: 25px;">
                    <div class="card-body text-center" style="color: white;padding-right: 5px;padding-left: 5px;margin-bottom: 20px">
                        <h5 class="card-title text-uppercase" style="cursor: pointer;margin: 0;font-weight: 900">WELCOME <strong style="text-decoration: underline">{{ Auth::user()->first_name }}</strong></h5>
                    </div>
                    <ul class="list-group text-center">
                        @foreach($governorates as $item)
                            <li onclick="window.location.href = '{{route('types',[$item->id])}}'" class="list-group-item text-uppercase mb-2 h_red d_blow" style="cursor:pointer;color: white;font-weight: bold;padding: 6px">{{$item->name}}</li>
                        @endforeach
                        <hr style="border: 1px solid #fff;width: 100%;">
                        <li onclick="window.location.href = '{{route('visit')}}'" class="list-group-item text-uppercase mb-2 h_red d_blow" style="cursor:pointer;color: white;font-weight: bold;padding: 6px">Visit</li>
                        <li onclick="$('#logout').submit();" class="list-group-item text-uppercase mb-2 h_red d_blow" style="cursor:pointer;color: white;font-weight: bold;padding: 6px">Logout</li>

                    </ul>
                    <form id="logout" action="{{ route('logout') }}" method="post">@csrf</form>
                </div>
            </div>
            <div class="col-md-9" style="background-color:#007f86;height: 100%;padding: 15px" >
                <div class="container-fluid" style="background-color: white;height: 100%;
                                              padding: 10px;
                                              border-radius: 10px;
                                              box-shadow: 0 0 16px 11px #5f5f5f;min-height: 627px;">
                    <div class="row" style="padding: 15px">

                        <div class="col-sm-12">

                            @if(!empty(session('success')))
                                <div role="alert" aria-live="assertive"   aria-atomic="true" style="position: relative;">
                                    <div class="toast" id="element1"  data-delay="5000"   style="position: absolute; top: 0; right: 0;min-width: 250px">
                                        <div class="toast-header" style="background-color: #2fa0a6; color: white;">
                                            <strong class="mr-auto">Ella Billboard Program</strong>
                                            <small>now</small>
                                            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="toast-body" style="background-color: aliceblue;">
                                            {{session('success')}}
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if(!empty(session('error')))
                                <div role="alert" aria-live="assertive"   aria-atomic="true" style="position: relative;">
                                    <div class="toast" id="element1"  data-delay="5000"   style="position: absolute; top: 0; right: 0;min-width: 250px">
                                        <div class="toast-header" style="background-color: #2fa0a6; color: white;">
                                            <strong class="mr-auto">Ella Billboard Program</strong>
                                            <small>now</small>
                                            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="toast-body" style="background-color: #ab002b;color: white;">
                                            {{session('error')}}
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb" style="background: white;font-weight: 700;font-size: large">
                                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">User</li>
                                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                                </ol>
                            </nav>
                            <hr>
                        </div>


                        <div class="col-12" >

                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12 col-sm-6 mb-4">
                                        <div class="btn col-12 col-sm-5 mb-5" style="background: #57585a;color: white;font-weight: bold;">User Info</div>
                                        <form method="post" action="{{route('UserUpdate',[$user->id])}}">
                                            @csrf

                                            <div class="form-group">
                                                <label for="first_name" style="color: rgb(0, 127, 134);font-weight: 700">First Name</label>
                                                <input type="text" value="{{$user->first_name}}" required="required" class="form-control @error('first_name') is-invalid @enderror  col-12 col-sm-6" name="first_name" id="first_name" aria-describedby="first_name">
                                                @error('first_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="last_name" style="color: rgb(0, 127, 134);font-weight: 700">Last Name</label>
                                                <input type="text" value="{{$user->last_name}}" required="required" class="form-control @error('last_name') is-invalid @enderror  col-12 col-sm-6" name="last_name" id="last_name" aria-describedby="last_name">
                                                @error('last_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="username" style="color: rgb(0, 127, 134);font-weight: 700">User Name</label>
                                                <input type="text" value="{{$user->username}}" required="required" class="form-control @error('username') is-invalid @enderror  col-12 col-sm-6" name="username" id="username" aria-describedby="username">
                                                @error('username')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <button type="submit" style="background-color: #2fa0a6;border-color: #2fa0a6;" class="btn btn-primary mt-5">Save</button>

                                        </form>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="btn col-12 col-sm-5 mb-5" style="background: #57585a;color: white;font-weight: bold;">User Info</div>
                                        <form method="post" action="{{route('UserChangePassword',[$user->id])}}">
                                            @csrf

                                            <div class="form-group">
                                                <label for="password" style="color: rgb(0, 127, 134);font-weight: 700">Password</label>
                                                <input type="password" value="{{old('password')}}" required="required" class="form-control @error('password') is-invalid @enderror col-12 col-sm-6" name="password" id="password" aria-describedby="password">
                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="c_password" style="color: rgb(0, 127, 134);font-weight: 700">Confirm Password</label>
                                                <input type="password" value="{{old('c_password')}}" required="required" class="form-control @error('c_password') is-invalid @enderror  col-12 col-sm-6" name="c_password" id="c_password" aria-describedby="c_password">
                                                @error('c_password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <button type="submit" style="background-color: #2fa0a6;border-color: #2fa0a6;" class="btn btn-primary mt-5">Change Password</button>

                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

