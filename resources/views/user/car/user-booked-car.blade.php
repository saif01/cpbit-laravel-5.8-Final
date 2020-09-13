@extends('user.layout.car-master')


@section('page-js')

{{-- Cancel Sweet alert --}}
@include('user.layout.sw-cancel-alert')

{{-- Deat Piker --}}
@include('admin.layout.datePiker.datePiker')

<!-- Comment Data Put JS Functions -->
@include('user.car.modal-put-comment-functions')

<!--  Date Time Format JS Functions -->
@include('user.layout.date-time-format-jsfunction')

<script>
    (function(){

            $(document).on("click", ".modifyBooking", function() {
                var id = $(this).attr("id");
                $.ajax({
                    url: "{{ route('user.modify.booked.data') }}",
                    method: "GET",
                    data: { id: id },
                    success: function(data) {
                       console.log(data);
                        $("#bookingIdModify").val(data.id);
                        $("#startBookingModify").val(data.start);

                        var start_booking_mod = formatDate(data.start);
                        var end_booking_mod = formatDate(data.end);

                        $("#startDateTableData").text(start_booking_mod);
                        $("#endDateTableData").text(end_booking_mod);
                        $("#carNumberTableData").text(data.number);
                        $("#driverTableData").text(data.name);
                        $("#ModifyModal").modal("show");
                    },
                    error: function(response){
                        console.log('Error', response);
                    }
                });

            });

    })(jQuery);

</script>

@endsection

@section('content')

@php
    //Day Or houre Calculaate
    function DayOrHoure($startTime, $endTime)
    {
        $ts1 = strtotime($startTime);
        $ts2 = strtotime($endTime);
        $seconds = abs($ts2 - $ts1); # difference will always be positive
        $days = round($seconds / (60 * 60 * 24));
    if ($days >= 1) {
        return $days . " Days";
        } else {
        return round($seconds / (60 * 60)) . " Hours";
        }
    }

    $currentTime = date('Y-m-d H:i:s', time());
@endphp

<!--== Page Title Area Start ==-->
<section id="page-title-area" class="section-padding overlay">
    <div class="container">
        <div class="row">
            <!-- Page Title Start -->
            <div class="col-lg-12">
                <div class="section-title text-center">
                    <h2>{{ session()->get('user.name') }}'s Booked car</h2>
                    <span class="title-line"><i class="fa fa-car"></i></span>
                </div>
            </div>
            <!-- Page Title End -->
        </div>
    </div>
</section>
<!--== Page Title Area End ==-->

<!--== FAQ Area Start ==-->
        <section id="faq-page-area" class="section-padding">
            <div class="container">

                @foreach ($allData as $row)
                <div class="row mb-3">
                    <!-- Single Articles Start -->
                    <div class="col-lg-12">
                        <article class="single-article">
                            <div class="row">
                                <!-- Articles Thumbnail Start -->
                                <div class="col-lg-5">
                                    <div class="article-thumb">
                                        <a href="{{ route('user.car.details',[$row->carId]) }}"> <img src="{{ asset($row->image) }}" class="mx-auto d-block" alt="Image" /></a>
                                    </div>
                                </div>
                                <!-- Articles Thumbnail End -->

                                <!-- Articles Content Start -->
                                <div class="col-lg-7">
                                    <div class="display-table">
                                        <div class="display-table-cell">
                                            <div class="article-body">
                                                <h6>
                                                    <a href="{{ route('user.car.details',[$row->carId]) }}">{{ $row->name }} --: {{ $row->number }}</a>
                                                    <span class="bookedInfo">Booked: {{ DayOrHoure( $row->start,$row->end ) }} </span>
                                                </h6>


                                                <ul class="car-info-list">
                                                    <li> Destination :<b> {{ $row->destination }}</b></li>
                                                </ul>
                                                <ul class="car-info-list">
                                                    <li>Purpose :<b> {{ $row->purpose }}</b></li>
                                                </ul>
                                                <ul class="car-info-list">
                                                    <li>{{ date("j-F-Y, g:i A", strtotime($row->start)) }} <b>-- To -- </b> {{ date("j-F-Y, g:i A", strtotime($row->end)) }}
                                                    </li>
                                                </ul>
                                                <div class="text-center">
                                                    <!-- Conditional section -->
                                                    @if ($row->start >= $currentTime )
                                                        <a href="{{ route('user.cancel.car',$row->id) }}" id="cancelBooking" title="Cancel Booking" class="readmore-btn mr-1"> Cancel Booking</a>
                                                    @endif

                                                    <a href="javascript:void(0);" id="{{ $row->id }}" title="Modify Booking" class="modifyBooking readmore-btn mr-1"> Modify Booking</a>

                                                    @if ($row->comit_st != 1)
                                                    <a href="javascript:void(0);" id="{{ $row->id }}"  class="readmore-btn bookingComment">Comment</a>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Articles Content End -->
                            </div>
                        </article>
                    </div>
                    <!-- Single Articles End -->

                </div>
                @endforeach

            </div>
        </section>
        <!--== FAQ Area End ==-->

<!-- Comment Data Put Modal -->
@include('user.car.modal-put-comment')


<!--Booking Modify Modal -->
<div class="modal fade bd-example-modal-lg" id="ModifyModal" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modify Booking Time</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

           <div class="table-responsive">
               <table class="table">
                    <tr>
                        <th>Start Booking</th>
                        <td id="startDateTableData">No Data</td>
                        <th>End Booking</th>
                        <td id="endDateTableData">No Data</td>
                    </tr>
                    <tr>
                        <th>Car Number</th>
                        <td id="carNumberTableData">No Data</td>
                        <th>Driver Name</th>
                        <td id="driverTableData">No Data</td>
                    </tr>
                </table>
           </div>


            <form method="POST" action="{{ route('user.car.booking.modify.action') }}"  class="p-3">
                @csrf
                <input type="hidden" id="bookingIdModify" name="id">
                <input type="hidden" id="startBookingModify" name="start">


                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-form-label">End Booking :</label>
                            <input type='text' class="form-control" id="datepicker" name="end" placeholder="Put End Date" class=" form-control" required="required">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-form-label">Return Time :</label>
                            <select name="endHour" class="custom-select form-control" required="required">
                                <option value="" disabled selected>Select End Time </option>
                                <option value="09:00:00">9.00 AM </option>
                                <option value="09:30:00">9.30 AM </option>
                                <option value="10:00:00">10.00 AM </option>
                                <option value="10:30:00">10.30 AM </option>
                                <option value="11:00:00">11.00 AM </option>
                                <option value="11:30:00">11.30 AM </option>
                                <option value="12:00:00">12.00 PM (Noon)</option>
                                <option value="12:30:00">12.30 PM</option>
                                <option value="13:00:00">01.00 PM </option>
                                <option value="13:30:00">01.30 PM </option>
                                <option value="14:00:00">02.00 PM </option>
                                <option value="14:30:00">02.30 PM </option>
                                <option value="15:00:00">03.00 PM </option>
                                <option value="15:30:00">03.30 PM </option>
                                <option value="16:00:00">04.00 PM </option>
                                <option value="16:30:00">04.30 PM </option>
                                <option value="17:00:00">05.00 PM </option>
                                <option value="17:30:00">05.30 PM </option>
                                <option value="18:00:00">06.00 PM </option>
                                <option value="18:30:00">06.30 PM </option>
                                <option value="19:00:00">07.00 PM </option>
                                <option value="19:30:00">07.30 PM </option>
                                <option value="20:00:00">08.00 PM </option>
                                <option value="20:30:00">08.30 PM </option>
                                <option value="21:00:00">09.00 PM </option>
                                <option value="21:30:00">09.30 PM </option>
                                <option value="22:00:00">10.00 PM </option>
                                <option value="22:30:00">10.30 PM </option>
                                <option value="23:00:00">11.00 PM </option>
                                <option value="23:30:00">11.30 PM </option>

                                <option value="23:59:00">12.00 AM (Night) </option>
                                <option value="01:00:00">01.00 AM </option>
                                <option value="01:30:00">01.30 AM </option>
                                <option value="02:00:00">02.00 AM </option>
                                <option value="02:30:00">02.30 AM </option>
                                <option value="03:00:00">03.00 AM </option>
                                <option value="03:30:00">03.30 AM </option>
                                <option value="04:00:00">04.00 AM </option>
                                <option value="04:30:00">04.30 AM </option>
                                <option value="05:00:00">05.00 AM </option>
                                <option value="05:30:00">05.30 AM </option>
                                <option value="06:00:00">06.00 AM </option>
                                <option value="06:30:00">06.30 AM </option>
                                <option value="07:00:00">07.00 AM </option>
                                <option value="07:30:00">07.30 AM </option>
                                <option value="08:00:00">08.00 AM </option>
                                <option value="08:30:00">08.30 AM </option>

                            </select>
                        </div>
                    </div>
                </div>

                <button type="submit" id="btnSubmit" name="submit" class="btn btn-primary btn-block mt-3 ">Update</button>

            </form>



        </div>
    </div>
</div>

@endsection
