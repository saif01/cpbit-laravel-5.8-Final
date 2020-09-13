@if( !empty(session()->get('user.name')) )
<script type="text/javascript">
    window.location.href = "{{ route('user.dashboard')}}";
</script>
@endif
<!DOCTYPE html>
<html lang="en">

<head>
    <title>CPB-IT</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    @include('user.layout.icon')
    {{-- <link rel="icon" type="image/png" href="images/icons/favicon.ico" /> --}}
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('user/login/assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('user/login/assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('user/login/assets/fonts/iconic/css/material-design-iconic-font.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('user/login/assets/css/util.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('user/login/assets/css/main.min.css') }}">
    <!--===============================================================================================-->

{{-- Preloader --}}
@include('user.layout.preloader-JS-CSS')

</head>

<body>
{{-- Preloader --}}
<div class="loader">
    <img src="{{ asset('common/preloader/userLogin.gif') }}" alt="Loading..." />
</div>

    <div class="background_animation2">

        <div class="limiter">
            <div class="container-login100 background_animation">
                <div class="wrap-login100">




                    <form class="login100-form validate-form" action="{{ route('user.login.action') }}" method="POST">
                        @csrf

                        <span class="login100-form-title">
                            <img src="{{ asset('common/logo/cpbit.png') }}" class="logo_img_size rotate">

                        </span>

                            @if ($message = session()->get('error'))
                            <div class="alert alert-danger alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{{ $message }}</strong>
                            </div>
                            @endif


                        <div class="wrap-input100 validate-input" data-validate="Valid Id is: name.abc">
                            <input class="input100" type="text" name="login">
                            <span class="focus-input100" data-placeholder="Login ID"></span>
                        </div>

                        <div class="wrap-input100 validate-input" data-validate="Enter password">
                            <span class="btn-show-pass">
                                <i class="zmdi zmdi-eye"></i>
                            </span>
                            <input class="input100" type="password" name="password">
                            <span class="focus-input100" data-placeholder="Password"></span>
                        </div>

                        <div class="container-login100-form-btn">
                            <div class="wrap-login100-form-btn">
                                <div class="login100-form-bgbtn"></div>
                                <button class="login100-form-btn" id="btnSubmit">
                                    Login
                                </button>
                            </div>
                        </div>




                    </form>
                    <hr>

                    <div class="row mt-3 ">

                            <div class="col-md-6 d-none d-md-block" >
                                <a href="https://docs.google.com/forms/d/e/1FAIpQLSdD0RAhCW8GOkh3wbsAzCDAIicBDZ4n2KcVyjG5izBs8ygkhA/viewform?usp=sf_link" target="_blank">Register Link</a>
                            </div>
                            <div class="col-md-6 d-none d-md-block" >
                            <a href="{{ asset('android-app/CPB-IT.apk') }}" class="float-right" download>App Link</a>
                            </div>
                    </div>


                </div>



            </div>
        </div>



    </div>

    <!--===============================================================================================-->
    <script src="{{ asset('user/login/assets/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('user/login/assets/vendor/bootstrap/js/popper.js') }}"></script>
    <script src="{{ asset('user/login/assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('user/login/assets/js/main.js') }}"></script>

</body>

</html>
