@extends('user.layout.corona-master')
@section('title', 'iTemp Dashboard')

@section('page-css')

    <style>
        /* Cursor */
        .typed-cursor {
            color: rgb(102, 203, 250);
        }
        .icon-size{
            font-size: 48px;
        }
    </style>

@endsection

@section('page-js')

    <!--Typed.js-->
    <script src="{{ asset('common/typed/typed.js') }}"></script>

    <script>
        var typed = new Typed('#typed',{
                strings:["We keep a temperature record of all employees !!!","iTemp of C.P. Bangladesh !!!"],
                backSpeed: 15,
                smartBackspace: true,
                backDelay: 1200,
                startDelay: 1000,
                typeSpeed: 25,
                loop: true,
                });
    </script>


    <!--Chart.js-->
    <script src="{{ asset('common/Chart/Chart.min.js') }}"></script>
    {{-- Dashboard Chart JS function --}}
    @include('user.corona.dashboard-chart-js')


@endsection


@section('content')


<div class="card my-3">
    <div class="card-body text-center ">
        <h2><span id="typed"></span></h2>
    </div>
</div>



<div class="card">
    <div class="card-body">

        <div class="row">
            <div class="col-sm-4">
                <div class="card">
                    <h5 class="card-header card-header-top-line">Total User</h5>
                    <div class="card-body">
                        <i class="fa fa-users icon-size text-success" aria-hidden="true"></i>
                        <span class="float-right h2 bg-success p-1 text-light rounded">{{ $totalUser }}</span>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <h5 class="card-header card-header-top-line">Total Temperature Records</h5>
                    <div class="card-body">
                        <i class="fa fa-file icon-size text-info" aria-hidden="true"></i>
                        <span class="float-right h2 bg-info p-1 text-light rounded">{{ $totalTepmRec }}</span>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <h5 class="card-header card-header-top-line">Today Temperature Measured</h5>
                    <div class="card-body">
                        <i class="fa fa-thermometer-full icon-size text-warning" aria-hidden="true"></i>
                        <span class="float-right h2 bg-warning p-1 text-light rounded">{{ $todayTepmMeasured->count() }}</span>
                    </div>
                </div>
            </div>
        </div>


        <div class="row mt-3">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header card-header-top-line">
                        <h4 class="card-title text-center">Today Temperature Measured Chart</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body chartjs">
                            <canvas id="todayTepmMeasuredChart" width="400" height="150"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header card-header-top-line">
                        <h4 class="card-title text-center">All User By Department</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body chartjs">
                            <canvas id="myChart" width="400" height="150"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>
</div>


@endsection



