@extends('user.layout.car-master')

@section('page-css')
    <!--*********** Simple Data table CDN ***********************-->
    <link rel="stylesheet" type="text/css" href="{{ asset('user/assets/dataTable/data_table.css') }}">
@endsection

@section('page-js')
    <script type="text/javascript" src="{{ asset('user/assets/dataTable/tbl.js') }}"></script>
    <script type="text/javascript" src="{{ asset('user/assets/dataTable/boots.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
        $('#example').DataTable({
           "stateSave": true,
           "order": []
        });
    } );
    </script>
@endsection

@section('content')

<!--== Page Title Area Start ==-->
<section id="page-title-area" class="section-padding overlay">
    <div class="container">
        <div class="row">
            <!-- Page Title Start -->
            <div class="col-lg-12">
                <div class="section-title text-center">
                    <h2>{{ session()->get('user.name') }}'s Booking History</h2>
                    <span class="title-line"><i class="fa fa-car"></i></span>
                </div>
            </div>
            <!-- Page Title End -->
        </div>
    </div>
</section>
<!--== Page Title Area End ==-->

<div class="container mt-3">


            <table id="example" class="table table-striped table-bordered table-dark text-center" style="width:100%">

                <thead class="bg-warning">
                    <tr>
                        <th>Car</th>
                        <th>Booking Starts</th>
                        <th>Booking Ends</th>
                        <th>Destination</th>
                        <th>Purpose</th>
                        <th>Driver</th>
                        <th>Status</th>
                        <th>Cost</th>
                        <th>Milage</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($allData as $row)
                        <tr>
                            <td>{{ $row->name }} {{ $row->number }}</td>
                            <td>{{ date("F j, Y, g:i a", strtotime($row->start)) }}</td>
                            <td>{{ date("F j, Y, g:i a", strtotime($row->end)) }}</td>
                            <td>{{ $row->destination }}</td>
                            <td>{{ $row->purpose }}</td>
                            <td>{{ $row->driverName }}</td>
                            <td>
                                @if ($row->status == 1)
                                    Booked
                                @else
                                    Canceled
                                @endif

                            </td>
                            <td>{{ $row->cost }}</td>
                            <td>{{ $row->start_mileage }} {{ $row->end_mileage }} </td>


                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

@endsection
