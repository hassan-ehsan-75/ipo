@extends('layouts.app_no_nav')
@section('content')
    <div class="container-fluid" style="height: 100%;">
        <div class="row"  style="height: 100%;padding: 0">
            <div class="col-md-3" style="min-height: 100%;">
                <div class="card" style="max-width: 13rem;background: none;border: none;margin: 0 auto">
                    <img src="{{asset('images/app_images/ella_logo.png')}}" class="card-img-top" style="width: 100%;margin: 0 auto;margin-top: 25px;">
                    <div class="card-body text-center" style="color: white;padding-right: 5px;padding-left: 5px;margin-bottom: 20px">
                        <h5 class="card-title text-uppercase" style="cursor: pointer;margin: 0;font-weight: 900">WELCOME <strong style="text-decoration: underline" onclick="window.location.href = '{{route('user')}}'">{{ Auth::user()->first_name }}</strong></h5>
                    </div>
                    <ul class="list-group text-center">
                        @foreach($governorates as $item)
                            <li onclick="window.location.href = '{{route('types',[$item->id])}}'" class="list-group-item text-uppercase mb-2 h_red d_blow" style="cursor:pointer;color: white;font-weight: bold;padding: 6px">{{$item->name}}</li>
                        @endforeach
                        <hr style="border: 1px solid #fff;width: 100%;">
                            <li onclick="window.location.href = '{{route('add-ticket')}}'"   class="list-group-item text-uppercase mb-2 h_red d_blow" style="cursor:pointer;color: white;font-weight: bold;padding: 6px"><a style="color: white" href="{{route('add-ticket')}}">Ticket</a></li>
                            <li onclick="window.location.href = '{{route('visit')}}'" class="list-group-item text-uppercase mb-2 h_red d_blow" style="cursor:pointer;color: white;font-weight: bold;padding: 6px">Visit</li>
                            <li onclick="$('#logout').submit();" class="list-group-item text-uppercase mb-2 h_red d_blow" style="cursor:pointer;color: white;font-weight: bold;padding: 6px">Logout</li>

                    </ul>
                    {{--<li  class="list-group-item text-uppercase mb-2 h_red d_blow" style="cursor:pointer;color: white;font-weight: bold;padding: 6px"><a style="color: white" href="{{route('add-ticket')}}">New Ticket</a></li>--}}
                    <form id="logout" action="{{ route('logout') }}" method="post">@csrf</form>
                </div>
            </div>
            <div class="col-md-9" style="background-color:#007f86;height: 100%;padding: 15px" >
                <div id="mapid" style="height: 100%;border: 4px solid #2fa0a6;border-radius: 20px;"></div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="application/javascript">
        var ACCESS_TOKEN = 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw';
        var mymap = L.map('mapid').setView([34.7988293, 41.2465911], 7);
        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
            attribution: 'Qtech',
            id: 'mapbox/streets-v11',
            accessToken: ACCESS_TOKEN
        }).addTo(mymap);
    </script>
@endpush
