<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>CPB-IT ADMIN</title>
    <!--=== Favicon ===-->
    @include('admin.layout.icon')
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="{{ asset('admin/dashboard/assets/css/bootstrap.min.css') }}">
    <!-- Custom styles for this template -->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/dashboard/assets/css/style.min.css') }}">

    <!--*************** Font Awesome v.5.7.0 ****************-->
    <link rel="stylesheet" href="{{ asset('common/fontawesom5.7/css/all.min.css') }}" >

    {{-- Preloader --}}
    @include('admin.layout.preloader-JS-CSS')
    </head>

    <body>
    {{-- Preloader --}}
    <div class="loader">
        <img src="{{ asset('common/preloader/adminDashboard.gif') }}" alt="Loading..." />
    </div>

    <div class="navbar_grad">
        <!-- Image and text -->

        <nav class="navbar navbar-expand-lg navbar-light resize mx-auto justify-content-center">

            <a class="navbar-brand" href="#">
                <img src="{{ asset('common/logo/cpbit.png') }}" class="nav-logo rotate" alt="CPB-IT">
                <span class="tx-w ml-1">CPB-IT Portal Admin Section</span>
            </a>

        </nav>
    </div>


    <div class="container">
        <div class="row justify-content-center">
            @if (session()->get('admin.car') == 1)
            <!-- Project Car Pool -->
            <div class="col-md-2 shadow-lg p-3 rounded saif text-center zoom" id="grad1">
                <a href="{{ route('carpool.admin.dashboard') }}">
                    <i class="fas fa-car text-primary project-icon"></i>
                    <span class="badge badge-dark project-title">Carpool</span>
                </a>
            </div>
            @endif
            @if (session()->get('admin.room') == 1)
            <!--Room Booking Project  -->
            <div class="col-md-2 shadow-lg p-3 rounded saif text-center zoom" id="grad1">
                <a href="{{ route('room.admin.dashboard') }}">
                    <i class="fas fa-home text-success project-icon"></i>
                    <span class="badge badge-dark project-title">Room Booking </span>
                </a>
            </div>
            @endif
            @if (session()->get('admin.network') == 1)
            <!--Legal Project  -->
            <div class="col-md-2 shadow-lg p-3 rounded saif text-center zoom" id="grad1">
                <a href="{{ route('network.dashboard') }}">
                    <i class="fas fa-ethernet text-warning project-icon"></i>
                    <span class="badge badge-dark project-title">Network</span>
                </a>
            </div>
            @endif
            @if (session()->get('admin.hard') == 1)
            <!--Complaint Management Hardware -->
            <div class="col-md-2 shadow-lg p-3 rounded saif text-center zoom" id="grad1">
                <a href="{{ route('hard.admin.dashboard') }}">

                    <i class="fas fa-tools project-icon" style="color:#A0522D"></i>
                    <span class="badge badge-dark project-title">Hardware</span>
                </a>
            </div>
            @endif
            @if (session()->get('admin.app') == 1)
            <!--Complaint Management Application -->
            <div class="col-md-2 shadow-lg p-3 rounded saif text-center zoom" id="grad1">
                <a href="{{ route('app.admin.dashboard') }}">

                    <i class="fas fa-laptop-medical project-icon" style="color: #410093"></i>
                    <span class="badge badge-dark project-title">Application</span>
                </a>
            </div>
            @endif
            @if (session()->get('admin.inventory') == 1)
            <!--Complaint Management Application -->
            <div class="col-md-2 shadow-lg p-3 rounded saif text-center zoom" id="grad1">
                <a href="{{ route('inv.admin.dashboard') }}">

                    <i class="fas fa-warehouse project-icon" style="color: #00FFFF "></i>
                    <span class="badge badge-dark project-title">Inventory</span>
                </a>
            </div>
            @endif
            @if (session()->get('admin.it_connect') == 1)
            <!--Super Admin -->
            <div class="col-md-2 shadow-lg p-3 rounded saif text-center zoom" id="grad1">
                <a href="{{ route('it.connect.dashboard') }}">
                    <i class="fas fa-plug project-icon" style="color:#9ef02b"></i>
                    <span class="badge badge-dark project-title">iService</span>
                </a>
            </div>
            @endif

            @if (session()->get('admin.corona') == 1)
            <!--Super Admin -->
            <div class="col-md-2 shadow-lg p-3 rounded saif text-center zoom" id="grad1">
                <a href="{{ route('corona.dashboard') }}">
                    <i class="fas fa-temperature-high project-icon px-3 pb-1 text-warning"></i>
                    <span class="badge badge-dark project-title">iTemp</span>
                </a>
            </div>
            @endif

            @if (session()->get('admin.super') == 1)
            <!--Super Admin -->
            <div class="col-md-2 shadow-lg p-3 rounded saif text-center zoom" id="grad1">
                <a href="{{ route('super.dashboard') }}">

                    <i class="fas fa-user-secret project-icon" style="color: #FF69B4"></i>
                    <span class="badge badge-dark project-title">Super Admin</span>
                </a>
            </div>
            @endif


            <!--LogOut  -->
            <div class="col-md-2 shadow-lg p-3 rounded saif text-center zoom" id="grad1">
                <a href="{{ route('admin.logout') }}">
                    <i class="fas fa-power-off text-danger project-icon"></i>
                    <span class="badge badge-dark project-title">LogOut</span>
                </a>
            </div>

        </div>

    </div>


    <!-- Footer -->
    <footer class="page-footer font-small footer_grad fixed-bottom">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Powered By CPB-IT</p>
        </div>
    </footer>
    <!-- Footer -->


</body>

</html>
