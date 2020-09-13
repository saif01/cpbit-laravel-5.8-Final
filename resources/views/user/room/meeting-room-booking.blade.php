@extends('user.layout.room-master')

@section('page-css')
<!-- jQuery UI CSS -->
<link rel="stylesheet" type="text/css" href="{{ asset('user/assets/coustom/datepiker/jquery-ui.min.css') }}">
<link href="{{ asset('user/calendar/fullcalendar.min.css') }}" rel='stylesheet' />
<link href="{{ asset('user/calendar/fullcalendar.print.min.css') }}" rel='stylesheet' media='print' />
<style>
.roomImg{
border-radius: 10px 20px;
background: #11f7d4;
padding: 2px;
width: 200px;
height: 110px;
margin-right: 0px;
float: left;
}

.fc-unthemed td.fc-today {
background-color: #11f7d4;
}
.fc-basic-view .fc-day-top .fc-week-number {
background-color: #11f7d4;
}
.fc-state-default {
background-color: #11f7d4;
}

</style>
@endsection

@section('page-js')

<script src="{{ asset('user/calendar/lib/moment.min.js') }}"></script>
<script src="{{ asset('user/calendar/fullcalendar.min.js') }}"></script>
<script src="{{ asset('user/calendar/locale-all.js') }}"></script>

<!-- jQuery UI js -->
<script src="{{ asset('user/assets/coustom/datepiker/jquery-ui.min.js') }}"></script>
<!-- Coustom Date functions -->
<script src="{{ asset('user/assets/coustom/datepiker/mycoustom_function.js') }}"></script>

<script>
    (function( $ ) {
        $(document).ready(function() {
            $('form').submit(function() {
                $('#btnSubmit').attr('disabled', 'disabled').css({"background-color": "red"});
            });
        });
    })(jQuery);


(function( $ ) {
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay,listWeek'
        },
        navLinks: true,
        weekNumbers: true,
        weekNumbersWithinDays: true,
        weekNumberCalculation: 'ISO',
        eventLimit: true,
        eventClick: (events)=> {
        var start = moment(events.start).format('DD-MMM-YYYY hh:mm A');
        var end = moment(events.end).format('DD-MMM-YYYY hh:mm A');
        $("#m_name").text(events.userName);
        $("#m_department").text(events.department);
        $("#m_purpose").text(events.purpose);
        $("#m_room").text(events.name);
        $("#m_start").text(start);
        $("#m_end").text(end);
        $("#bookingDataDetails").modal("show");
        },
        events: <?php echo $bookingData ?>
        });
    })(jQuery);


</script>

@endsection

@section('content')
@php
use \App\Http\Controllers\CheckStForCarpool;
$checkStatus = new CheckStForCarpool();
@endphp
<!--== Page Title Area Start ==-->
<section id="page-title-area" class="section-padding overlay">
    <div class="container">
        <div class="row">
            <!-- Page Title Start -->
            <div class="col-lg-12">
                <div class="section-title  text-center">

                    <img src="{{ asset($data->image) }}" class="img-responsive roomImg" alt="Car Image" />
                    <h2>{{ $data->name }}</h2>

                    <!-- <h2>Meeting Room Booking</h2> -->
                    <span class="title-line"><i class="fa fa-home"></i></span>
                    <!--  <p>C.P. Bangladesh Car List.. </p> -->
                </div>
            </div>
            <!-- Page Title End -->
        </div>
    </div>
</section>
<!--== Page Title Area End ==-->

<section id="lgoin-page-wrap" class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-12 m-auto">
                <div class="login-page-content">
                    <div class="login-form">
                        <h3>Meeting Room Booking</h3>

                        <form
                            action="{{ route('user.meeting.room.booking.action',[$data->id ,$data->name]) }}"
                            method="POST" >
                            @csrf
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label>Booking Date : </label>
                                    <input type="text" name="start" id="datepicker" class="form-control"
                                        placeholder="Enter Booking Date" required="required" />
                                </div>
                            </div>

                            <div class="form-group row">


                                <div class="col-md-6">
                                    <div class="pickup-location book-item">
                                        <label>Start time : </label>
                                        <select name="startHour" class="form-control" required="required">
                                            <option value="" disabled selected> Start </option>
                                            <option value="09:00:00">9.00 AM </option>
                                            <option value="09:30:00">9.30 AM </option>
                                            <option value="10:00:00">10.00 AM </option>
                                            <option value="10:30:00">10.30 AM </option>
                                            <option value="11:00:00">11.00 AM </option>
                                            <option value="11:30:00">11.30 AM </option>
                                            <option value="12:00:00">12.00 PM </option>
                                            <option value="12:30:00">12.30 PM </option>
                                            <option value="13:00:00">1.00 PM </option>
                                            <option value="13:30:00">1.30 PM </option>
                                            <option value="14:00:00">2.00 PM </option>
                                            <option value="14:30:00">2.30 PM </option>
                                            <option value="15:00:00">3.00 PM </option>
                                            <option value="15:30:00">3.30 PM </option>
                                            <option value="16:00:00">4.00 PM </option>
                                            <option value="16:30:00">4.30 PM </option>
                                        </select>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="pickup-location book-item">

                                        <label>End Time : </label>
                                        <select name="endHour" class="form-control" required="required">
                                            <option value="" disabled selected> End </option>
                                            <option value="09:30:00">9.30 AM </option>
                                            <option value="10:00:00">10.00 AM </option>
                                            <option value="10:30:00">10.30 AM </option>
                                            <option value="11:00:00">11.00 AM </option>
                                            <option value="11:30:00">11.30 AM </option>
                                            <option value="12:00:00">12.00 PM </option>
                                            <option value="12:30:00">12.30 PM </option>
                                            <option value="13:00:00">1.00 PM </option>
                                            <option value="13:30:00">1.30 PM </option>
                                            <option value="14:00:00">2.00 PM </option>
                                            <option value="14:30:00">2.30 PM </option>
                                            <option value="15:00:00">3.00 PM </option>
                                            <option value="15:30:00">3.30 PM </option>
                                            <option value="16:00:00">4.00 PM </option>
                                            <option value="16:30:00">4.30 PM </option>
                                            <option value="17:00:00">5.00 PM </option>
                                            <option value="17:30:00">5.30 PM </option>
                                            <option value="18:00:00">6.00 PM </option>
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label>Purpose:</label>
                                    <input type="text" name="purpose" class="form-control"
                                        placeholder="Type Your Booking Purpose" required="required" />
                                </div>
                            </div>

                            <div class="log-btn">
                                <button id="btnSubmit" type="submit" name="submit" class="fa fa-check-square">
                                    Book Room</button>
                            </div>
                        </form>
                    </div>


                </div>
            </div>


            <div class="col-md-6 col-lg-6 col-md-12 m-auto">
                <div class="login-page-content">
                    <div id="calendar"></div>
                </div>
            </div>

        </div>
    </div>


</section>


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
                        <th>Purpose:</th>
                        <th id="m_purpose">ttttt</th>
                    </tr>
                    <tr>
                        <th>Room:</th>
                        <th id="m_room">ttttt</th>
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
