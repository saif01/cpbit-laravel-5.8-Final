@extends('user.layout.room-master')

@section('page-js')

{{-- Deat Piker --}}
@include('admin.layout.datePiker.datePiker')


<script>

    $(document).on("click", ".modifyBooking", function() {
    var id = $(this).attr("id");
    var bookingStart = $(this).attr("bookingStart");
    var bookingEnd = $(this).attr("bookingEnd");
    var roomName = $(this).attr("roomName");
    var ModifyBookingStart = formatDateAmPm(bookingStart);
    var ModifyBookingEnd = formatDateAmPm(bookingEnd);;
    $("#startBookingModify").val(bookingStart);
    $("#bookingIdModify").val(id);
    $("#startDateTableData").text(ModifyBookingStart);
    $("#endDateTableData").text(ModifyBookingEnd);
    $("#roomTableData").text(roomName);
    $("#ModifyModal").modal("show");
    });



    function formatDateAmPm(dateVal) {
    var newDate = new Date(dateVal);
    const monthFull = newDate.toLocaleString("default", { month: "short" });
    var sMonth = padValue(newDate.getMonth() + 1);
    var sDay = padValue(newDate.getDate());
    var sYear = newDate.getFullYear();
    var sHour = newDate.getHours();
    var sMinute = padValue(newDate.getMinutes());
    var sAMPM = "AM";
    var iHourCheck = parseInt(sHour);
    if (iHourCheck > 12) {
    sAMPM = "PM";
    sHour = iHourCheck - 12;
    } else if (iHourCheck === 0) { sHour = "12"; }
    sHour = padValue(sHour);
    return monthFull + "-" + sDay + "-" + sYear + " " + sHour + ":" + sMinute + " " + sAMPM;
    }
    function padValue(value) { return (value < 10) ? "0" + value : value; }


$(document).on("click", "#cancelBooking", function(e) {
        e.preventDefault();
        var link = $(this).attr("href");
        Swal.fire({
        title: 'Are you Want to Cancel?',
        text: "Once Cancel, This will be Permanently Canceled!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Cancel it!'
        }).then((result) => {
        if (result.value) {
            window.location.href = link;
        }else{
            console.log("Safe Data!");
        }
    });
});

 (function( $ ) {
        $(document).ready(function() {
            $('form').submit(function() {
                $('#btnSubmit').attr('disabled', 'disabled').css({"background-color": "red"});
            });
        });
    })(jQuery);

</script>



@endsection

@section('content')

@php
$currentTime = date('Y-m-d H:i:s', time());
@endphp

<!--== Page Title Area Start ==-->
<section id="page-title-area" class="section-padding overlay">
    <div class="container">
        <div class="row">
            <!-- Page Title Start -->
            <div class="col-lg-12">
                <div class="section-title text-center">
                    <h2>{{ session()->get('user.name') }}'s Booked Room</h2>
                    <span class="title-line"><i class="fa fa-home"></i></span>
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
                                <a href="{{ route('user.room.details',$row->roomId) }}"> <img src="{{ asset($row->image) }}" class="mx-auto d-block"
                                        alt="Image" /></a>
                            </div>
                        </div>
                        <!-- Articles Thumbnail End -->

                        <!-- Articles Content Start -->
                        <div class="col-lg-7">
                            <div class="display-table">
                                <div class="display-table-cell">
                                    <div class="article-body">
                                        <h6>
                                            <a href="{{ route('user.room.details',$row->roomId) }}">{{ $row->name }}</a>
                                            <span class="bookedInfo">Booked: {{ $row->hours }} Hours
                                            </span>
                                        </h6>



                                        <ul class="car-info-list">
                                            <li>Purpose :<b> {{ $row->purpose }}</b></li>
                                        </ul>
                                        <ul class="car-info-list">
                                            <li>{{ date("j-F-Y, g:i A", strtotime($row->start)) }} <b>-- To -- </b>
                                                {{ date("j-F-Y, g:i A", strtotime($row->end)) }}
                                            </li>
                                        </ul>
                                        <div class="text-center">
                                            <!-- Conditional section -->
                                            @if ($row->start >= $currentTime )
                                            <a href="{{ route('user.cancel.room',$row->id) }}" id="cancelBooking"
                                                title="Cancel Booking" class="readmore-btn mr-1"> Cancel Booking</a>
                                            @endif

                                            <a href="javascript:void(0);" id="{{ $row->id }}"
                                                bookingStart="{{ $row->start }}" bookingEnd="{{ $row->end }}" roomName="{{ $row->name }}" title="Modify Booking" class="modifyBooking readmore-btn mr-1"> Modify
                                                Booking</a>


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

            <table class="table">
                <tr>
                    <th>Start</th>
                    <td id="startDateTableData">No Data</td>
                    <th>End </th>
                    <td id="endDateTableData">No Data</td>
                    <th>Room </th>
                    <td id="roomTableData">No Data</td>
                </tr>
            </table>


            <form action="{{ route('user.room.booking.modify.action') }}" method="post" class="p-3">
                @csrf
                <input type="hidden" id="bookingIdModify" name="id">
                <input type="hidden" id="startBookingModify" name="start">


                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-form-label">End Booking :</label>
                            <input type='text' class="form-control" id="datepicker" name="end" placeholder="Put End Date" required="required">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-form-label">End Time :</label>
                            <select name="endHour" class="custom-select form-control" required="required">
                                <option value="" disabled selected>Select End Time </option>
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

                <button type="submit" id="btnSubmit" name="submit" class="btn btn-primary btn-block mt-3 ">Update</button>

            </form>



        </div>
    </div>
</div>

@endsection
