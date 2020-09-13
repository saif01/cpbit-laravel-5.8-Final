@extends('admin.layout.car-master')

@section('page-css')
<link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/fullcalendar.min.css') }}">
@endsection

@section('page-js')

<!-- BEGIN PAGE VENDOR JS-->
<script src="{{ asset('admin/app-assets/vendors/js/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('admin/app-assets/vendors/js/fullcalendar.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('admin/app-assets/vendors/js/jquery-ui.min.js') }}" type="text/javascript"></script>
<!-- Modal Show-->
<script src="{{ asset('admin/app-assets/js/components-modal.min.js') }}" type="text/javascript"></script>

    <script>
        (function ($){
        $('#fc-agenda-views').fullCalendar({
        height: 'auto',
        header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay,listWeek',
        },
        defaultView: 'month',
        editable: false,
        weekNumbers: true,
        eventLimit: true,
        eventClick: function(events) {
        var start = moment(events.start).format('DD-MMM-YYYY hh:mm A');
        var end = moment(events.end).format('DD-MMM-YYYY hh:mm A');
        $("#m_name").text(events.userName);
        $("#m_department").text(events.department);
        $("#m_destination").text(events.destination);
        $("#m_purpose").text(events.purpose);
        $("#m_car").text(events.number);
        $("#m_driver").text(events.driverName);
        $("#m_start").text(start);
        $("#m_end").text(end);
        $("#bookingDataDetails").modal("show");
        },
        events:<?php echo $bookingData; ?>,
        });
        })(jQuery);


        (function() {
        $("#showReport").click(function(){
        $("#singleCarReport").modal("show");
        });
        })(jQuery);

    </script>

@endsection

@section('content')
<!-- BEGIN : Main Content-->

        <!-- Line Chart Starts -->
<section id="calendar">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">

                    <div class="card-header">
                        <h4 class="card-title text-capitalize">
                            @if (isset($searchData))
                            <span class="text-danger">{{ $searchData->name ." || ". $searchData->number  }}</span> Booking Reports
                            @else
                            All Car Booking Report's
                            @endif
                            <a href="{{ route('car.report.calendar') }}" class="btn btn-primary gradient-green-tea float-right" ><i class="fa fa-refresh" aria-hidden="true"></i> Reload</a>
                            <button id="showReport" class="btn btn-success gradient-sublime-vivid  float-right mr-1">Search <i class="fa fa-search-plus"
                                    aria-hidden="true"></i></button>
                        </h4>

                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div id='fc-agenda-views'></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>

<!-- END : End Main Content-->

<!-- Modal -->
<div class="modal fade" id="singleCarReport" tabindex="-1" role="dialog" aria-labelledby="singleCarReportModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="singleCarReportModalLabel">Single Car Report Show</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('car.report.calendar.search') }}" method="POST" >
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Select Car</label>
                        <select name="searchCarId" class="form-control" required="required">
                            <option value=""> Select Car </option>
                            @foreach ($carData as $car)
                            <option value="{{ $car->id }}"> {{ $car->name. " || " .$car->number . " || " .$car->driverName}} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info">Search Result</button>
                </div>

            </form>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="bookingDataDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Booking Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <tr>
                        <th>Name:</th>
                        <th id="m_name">ttttt</th>
                    </tr>
                    <tr>
                        <th>Department:</th>
                        <th id="m_department">ttttt</th>
                    </tr>
                    <tr>
                        <th>Location:</th>
                        <th id="m_destination">ttttt</th>
                    </tr>
                    <tr>
                        <th>Purpose:</th>
                        <th id="m_purpose">ttttt</th>
                    </tr>
                    <tr>
                        <th>Car:</th>
                        <th id="m_car">ttttt</th>
                    </tr>
                    <tr>
                        <th>Driver:</th>
                        <th id="m_driver">ttttt</th>
                    </tr>
                    <tr>
                        <th>Start:</th>
                        <th id="m_start">ttttt</th>
                    </tr>
                    <tr>
                        <th>End:</th>
                        <th id="m_end">ttttt</th>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>

@endsection
