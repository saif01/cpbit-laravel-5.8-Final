@if( !empty(session()->get('admin.name')) )
<script type="text/javascript">
    window.location.href = "{{ route('admin.dashboard')}}";
</script>
@endif
<!DOCTYPE html>
<html lang="en">

<head>
    <title>CPB-IT-Admin</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
     @include('admin.layout.icon')
    {{-- <link rel="icon" type="image/png" href="images/icons/favicon.ico" /> --}}
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/login/assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/login/assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/login/assets/fonts/iconic/css/material-design-iconic-font.min.css') }}">

    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/login/assets/css/util.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/login/assets/css/main.min.css') }}">
    <!--===============================================================================================-->

    {{-- Preloader --}}
    @include('admin.layout.preloader-JS-CSS')
</head>

<body>
    {{-- Preloader --}}
    <div class="loader">
        <img src="{{ asset('common/preloader/adminLogin.gif') }}" alt="Loading..." />
    </div>

    <div class="limiter">
        <div class="container-login100" style="background-image: url('{{ asset("admin/login/assets/images/bg-01.jpg") }}');">
            <div class="wrap-login100 p-l-55 p-r-55 p-t-15 p-b-5">

                <form class="login100-form validate-form" method="POST" action="{{ route('admin.login.action') }}" >
                    @csrf
                    <span class="login100-form-title p-b-5">
                        <img src="{{ asset('common/logo/cpbit.png') }}" class="logo_img_size rotate">
                    </span>

                    @if ($message = session()->get('error'))
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif

                    <div class="wrap-input100 validate-input m-b-23" data-validate="Id is reauired">
                        <span class="label-input100">Admin Id</span>
                        <input class="input100" type="text" name="login" placeholder="Type your admin Id">
                        <span class="focus-input100" data-symbol="&#xf206;"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Password is required">
                        <span class="label-input100">Password</span>
                        <span class="btn-show-pass">
                            <i class="zmdi zmdi-eye pt-3"></i>
                        </span>
                        <input class="input100" type="password" name="password" placeholder="Type your password" >

                        <span class="focus-input100" data-symbol="&#xf190;"></span>
                    </div>

                    <div class="container-login100-form-btn p-t-25 p-b-25">
                        <div class="wrap-login100-form-btn">
                            <div class="login100-form-bgbtn"></div>
                            <button class="login100-form-btn" id="btnSubmit">
                                Login
                            </button>
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>


    <!--===============================================================================================-->
    <script src="{{ asset('admin/login/assets/vendor/jquery/jquery-3.2.1.min.js') }}"></script>

    <!--===============================================================================================-->
    <script src="{{ asset('admin/login/assets/vendor/bootstrap/js/popper.js') }}"></script>
    <script src="{{ asset('admin/login/assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <!--===============================================================================================-->

    <!--===============================================================================================-->
    <script src="{{ asset('admin/login/assets/js/main.js') }}"></script>


</body>

</html>
