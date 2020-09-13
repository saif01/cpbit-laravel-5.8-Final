@extends('user.layout.car-master')

@section('page-css')
<!-- jQuery UI CSS -->
<link rel="stylesheet" type="text/css" href="{{ asset('user/assets/coustom/datepiker/jquery-ui.min.css') }}">
<link href="{{ asset('user/calendar/fullcalendar.min.css') }}" rel='stylesheet' />
<link href="{{ asset('user/calendar/fullcalendar.print.min.css') }}" rel='stylesheet' media='print' />
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
        $("#m_destination").text(events.destination);
        $("#m_purpose").text(events.purpose);
        $("#m_car").text(events.number);
        $("#m_driver").text(events.driverName);
        $("#m_start").text(start);
        $("#m_end").text(end);
        $("#bookingDataDetails").modal("show");
        },
        events: @php echo $bookingData; @endphp
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

                    <img src="{{ asset($data->image) }}" class="img-responsive carImg" alt="Car Image" />

                    <img src="{{ asset($data->driverImage) }}" class="img-responsive driverImg" alt="Driver Image" />

                    <h2>{{ $data->name }} || {{ $data->number }}</h2>
                    <p><span class="title-line"><i class="fa fa-car"></i></span></p>

                    @php
                    // Driver Personal Leave
                    $drverLeave = $checkStatus->CheckDriverLeave($data->carId, $data->driverId);
                    // Car Maintance data
                    $carMaintance = $checkStatus->CheckCarMaintance($data->carId, $data->driverId);
                    // Police Reqisition data
                    $carRequisition = $checkStatus->CheckCarRequisition($data->carId, $data->driverId);
                    @endphp

                    {{-- Driver leave Status Check--}}
                    @if ($drverLeave)
                    <span class="bg-warning pl-1 pr-1 h6">Driver Leave :
                        {{ date("M j, Y", strtotime($drverLeave->start))  }} To
                        {{ date("M j, Y", strtotime($drverLeave->end))  }}</span>

                    {{-- Car Maintence Status Check--}}
                    @elseif($carMaintance)
                    <span class="bg-info pl-1 pr-1 h6">Maintenance :
                        {{ date("M j, Y", strtotime($carMaintance->start))  }}
                        To{{ date("M j, Y", strtotime($carMaintance->end)) }}</span>

                    {{-- Car Requisition Status Check--}}
                    @elseif($carRequisition)
                    <span class="bg-primary pl-1 pr-1 h6">Requisition :
                        {{ date("M j, Y", strtotime($carRequisition->start)) }} To
                        {{ date("M j, Y", strtotime($carRequisition->end)) }}</span>
                    @endif
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
                        <h3>Car Booking Entry</h3>

                        <form
                            action="{{ route('temporary.car.booking.action',[$data->carId, $data->number, $data->driverId, $data->driverName, $data->contact]) }}"
                            method="POST" >
                            @csrf
                            <div class="form-group row">
                                <div class="col-md-12">
                                        <label>Pick-Up DATE:</label>
                                        <input type="text" name="start" id="datepicker" class="form-control" placeholder="Pick Up Date" required="required" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="pickup-location book-item">
                                        <label>Destination : </label>
                                        <select name="destination" class="form-control" required="required">
                                            <option value="">Select Destination</option>
                                            @foreach ($dastination as $item)
                                            <option value="{{ $item->destination }}">{{ $item->destination }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
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
                                <div class="col-md-3">
                                    <div class="pickup-location book-item">

                                        <label>Return Time : </label>
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
                                    BookCar</button>
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
                        <th>Destination:</th>
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
