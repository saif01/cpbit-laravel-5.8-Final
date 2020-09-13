<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!--=== Favicon ===-->
    @include('user.layout.icon')
    <title>@yield('title')</title>

    {{-- <link href='http://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css'> --}}
    <link href="https://fonts.googleapis.com/css2?family=El+Messiri&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('common/bootstrap-4.5/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/fonts/font-awesome/css/font-awesome.min.css') }}">

     {{-- Preloader --}}
     @include('user.layout.preloader-JS-CSS')


     <style>

        body {
            font-family: 'El Messiri', sans-serif !important;
            min-height: 100%;
            width: 100%;
        }
        .footer_grad{
            background-image: linear-gradient(to right, rgba(255,0,0,0), #1E90FF);
        }
        .rotate {
                -webkit-transition: -webkit-transform .5s ease-in-out;
                transition: transform .5s ease-in-out;
            }
        .rotate:hover {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        .active{
            border-top: 3px solid rgb(245, 241, 15);
        }

        .card-header-top-line{
            border-top: 3px solid rgb(102, 203, 250);
        }
        .navbar-light .navbar-nav .active::after {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            content: " ";
            border-bottom: 5px solid rgb(102, 203, 250);
        }

     </style>

    @yield('page-css')
</head>
<body>
    <div class="loader">
        <img src="{{ asset('common/preloader/userDashboard.gif') }}" alt="Loading..." />
    </div>

    <div class="container content">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">

            <a class="navbar-brand mt-0 mb-0 p-0" href="{{ route('user.dashboard') }}">
                <img src="{{ asset('common/logo/cpbit.png') }}" class="navbar-brand rotate " height="59" alt="CPB-IT">
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
              <div class="navbar-nav h5">
                    <a class="nav-item nav-link mx-1" href="{{ route('user.corona.dashboard') }}">Home <i class="fa fa-home" aria-hidden="true"></i>
                    </a>
                    <a class="nav-item nav-link mx-2" href="{{ route('user.corona.all') }}">All Users <i class="fa fa-users" aria-hidden="true"></i>
                    </a>
                    <a class="nav-item nav-link mx-2" href="{{ route('user.corona.others') }}">Others <i class="fa fa-user-times" aria-hidden="true"></i>
                    </a>
                    <a class="nav-item nav-link mx-2" href="{{ route('user.corona.all.records') }}">All Records <i class="fa fa-file" aria-hidden="true"></i>
                    </a>

                    <a class="nav-item nav-link bg-danger rounded text-light ml-1" href="{{ route('user.logout') }}">Logout <i class="fa fa-sign-out" aria-hidden="true"></i>
                    </a>
              </div>
            </div>
          </nav>


          @yield('content')





    <!-- Footer -->
    <footer class="page-footer font-small footer_grad py-2 mt-3">
        <div class="container">
            <p class="m-0 text-center text-dark">Copyright &copy; Powered By CPB-IT</p>
        </div>
    </footer>
    <!-- Footer -->

    </div>


    <script src="{{ asset('common/jquery/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('common/bootstrap-4.5/js/popper.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('common/bootstrap-4.5/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('common/sweet-alert-2/sw-alert.js') }}" type="text/javascript"></script>

     {{-- Toastar Alert --}}
     <script type="text/javascript">

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            onOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })


        @if(Session::has('messege'))

            Toast.fire({
                icon: "{{ Session::get('alert-type') }}",
                title: "{{ Session::get('messege') }}"
            })

         {{ Session::forget('messege') }}
         @endif
    </script>

    <script>
        //For active menu highlite
            $(function () {
            // this will get the full URL at the address bar
            var url = window.location.href;

            // passes on every "a" tag
            $(".navbar-nav a").each(function () {
                // checks if its the same on the address bar
                if (url == (this.href)) {
                    $(this).closest("a").addClass("active");
                }
            });
            });
    </script>

    @yield('page-js')

</body>
</html>
