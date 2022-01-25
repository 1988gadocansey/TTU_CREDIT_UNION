<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Login to your portal."/>
    <meta name="keywords" content="Takoradi Technical University Credit Union"/>
    <meta name="author" content="Amos Appiah Nkum"/>
    <title>Takoradi Technical University - Credit Union</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <style>
        *:focus {
            outline: none !important;
        }
        input, .btn, .form-control{
            border-radius: 20px !important;
        }
        input:focus, .form-control:focus {
            outline: none !important;
        }
        .card {
            border-radius: 20px !important;
            border: 0 solid #3e5392;
            border-bottom-width: 2px;
        }
        input, button {
            border-radius: 0 !important;
        }
        .header-text{
            font-size: 20px;
            color: #3e5392;
            text-transform: uppercase;
            font-family: "Montserrat Medium", sans-serif;
        }
        .header-text{
            font-weight: bolder !important;
            color: #000000;
            font-size: 15px;
        }
        .login-body {
            background: #dadbdd url('{{asset('img/login-bg.jpg')}}') center center no-repeat;
            background-size: cover;
        }
    </style>
</head>
<body class="login-body">
<div class="container">
    <div style="height: 100vh" class="row align-items-center align-content-center justify-content-center">
        <div class="col-md-4">

            <div class="card">
                <div class="card-body bg-none">
                    <div class="text-center">
                        <img src="{{asset('/img/logo.png')}}" height="auto" width="150" alt="Logo">
                    </div>
                    <h4 class="header-text text-center">credit union</h4>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group ">
                            <div class="col-md-12 mb-3 mt-4">
                                <label for="email" class="mb-0 sr-only">{{ __('email') }}</label>
                                <input id="email" placeholder="amos.nkum@ttu.edu.gh" type="text" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="password" class="mb-0 sr-only">{{ __('Password') }}</label>
                                <input id="password" type="password" placeholder="Enter your password" class="form-control" name="password" required autocomplete="current-password">
                            </div>
                            <div class="col-md-12 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12 mb-2">
                                <button type="submit" class="btn  btn-block" style="background-color: #3e5392 !important; border: none; color: white">
                                    {{ __('LOGIN') }}
                                </button>
                                {{-- @if (Route::has('password.request'))
                                     <a class="btn btn-link" href="{{ route('password.request') }}">
                                         {{ __('Forgot Your Password?') }}
                                     </a>
                                 @endif--}}
                            </div>
                            <div class="col-md-12 text-center  pt-4">
                                <small>&copy; {{date('Y')}} - Powered By TP Connect</small>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
</body>
</html>
