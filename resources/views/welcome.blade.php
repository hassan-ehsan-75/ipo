<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{env('APP_NAME')}}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body style="background-color: #2fa0a6">
        <div class="flex-center position-ref full-height pt-5 pb-5" style="background: #2fa0a6;">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}" style="color: white;font-weight: 700">Home</a>
                    @else
                        <a href="{{ route('login') }}" style="color: white;font-weight: 700">Login</a>
                    @endauth
                </div>
            @endif

            <div class="content pt-5 pb-5" onclick="window.location.href = '{{ url('/home') }}'" style="background: #2fa0a6;padding-top: 150px">
                <div class="m-b-md">
                    <img  src="{{asset('images/app_images/ella.png')}}" style="width: 90%;cursor: pointer;" >
                </div>
                <div class="m-b-md" style="color: white;font-weight: 700">
                    <h1 class="">SALES BILLBOARD PROGRAM</h1>
                </div>

            </div>
        </div>
    </body>
</html>
