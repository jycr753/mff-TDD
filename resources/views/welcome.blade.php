<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="shortcut icon" href="{{{ asset('img/favicon.ico') }}}">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.1/css/bulma.min.css">
        <script defer src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
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
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    <img src="img/mff.png">
                    <br>
                        @if (Route::has('login'))
                            @auth
                                <a class="button is-link is-rounded" href="{{ url('/dashboard') }}">
                                    <span class="icon">
                                    <i class="fas fa-tachometer-alt"></i>
                                    </span>
                                    <span>Dashboard</span>
                                </a>
                            @else
                                <a class="button is-link is-rounded" href="{{ route('login') }}">
                                    <span class="icon">
                                    <i class="fas fa-sign-in-alt"></i>
                                    </span>
                                    <span>Login</span>
                                </a>

                                <a class="button is-link is-rounded" href="{{ route('register') }}">
                                    <span class="icon">
                                    <i class="fas fa-user-plus"></i>
                                    </span>
                                    <span>Register</span>
                                </a>
                            @endauth
                        @endif
                </div>
                <footer class="footer">
                    <div class="container">
                        <div class="content has-text-centered">
                        <p>
                            <strong>MFF</strong> by <a href="https://tanvir.dk">Tanvir Alam</a>
                        </p>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        
    </body>
</html>
