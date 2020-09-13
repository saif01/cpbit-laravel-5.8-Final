@extends('admin.layout.car-master')

{{-- Page CSS --}}
@section('page-css')
{{-- Data table css --}}
<link rel="stylesheet" type="text/css"
    href="{{ asset('admin/app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
<style>
    .carViewSize {
        height: 150px;
        width: 150px;
    }
</style>
@endsection
{{-- Page Js --}}
@section('page-js')

{{-- Deat Piker --}}
@include('admin.layout.datePiker.datePiker')

{{-- Data table js --}}
<script src="{{ asset('admin/app-assets/vendors/js/datatable/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('admin/app-assets/js/data-tables/datatable-basic.js') }}" type="text/javascript"></script>
<!-- Custom Sweet alert -->
<script src="{{ asset('admin/app-assets/custom/sweetAlert2Function.js') }}" type="text/javascript"></script>

<!-- Modal Show-->
<script src="{{ asset('admin/app-assets/js/components-modal.min.js') }}" type="text/javascript"></script>

<script>

$(".deadlineFixBtn").click(function() {
var _token = $('input[name="_token"]').val();
var id = $(this).attr("id");
var table = "cars";

    $.ajax({
    url:"{{ route('edit.value') }}",
    method:"POST",
    data:{ _token:_token, id:id, table:table },
    dataType: "json",
        success: function(data) {
            $("#IdDateLineFix").val(data.id);
            $("#carName").text(data.name);
            $("#carNumber").text(data.number);
            $("#deadlineFix").modal("show");
        },
        error: function (response) {

        console.log('Error', response);
        }
    });
});

jQuery(".actionBtn").click( function(){
    var carId = jQuery(this).attr("carId");
    var driverId = jQuery(this).attr("driverId");
    var driverName = jQuery(this).attr("driverName");
    var carName = jQuery(this).attr("carName");
    var carNumber = jQuery(this).attr("carNumber");
    var driverImage = jQuery(this).attr("driverImage");
    var carImage = jQuery(this).attr("carImage");
    var path = "{{ asset('/') }}";
    jQuery("#modalDriverId").val(driverId);
    jQuery("#modalCarId").val(carId);
    jQuery("#modalDriverName").text(driverName);
    jQuery("#modalCarName").text(carName);
    jQuery("#modalCarNumber").text(carNumber);

    jQuery("#modalDriverImageSrc").attr("src", path+driverImage);
    jQuery("#modalCarImageSrc").attr("src", path+carImage);

   jQuery("#modalAction").modal("show");

});


$(document).ready(function() {
    $("#time_show").on("change", function() {
    if (this.value == "manualInput") {
    $("#manual_input_show").show();
    } else {
    $("#manual_input_show").hide();
    }
    });
});


</script>

@endsection
{{-- End Js Section --}}

{{-- Start Main Content --}}
@section('content')
@php
  use \App\Http\Controllers\CheckStForCarpool;
  $checkStatus = new CheckStForCarpool();
@endphp

<!-- Alternative pagination table -->
<section id="pagination">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">All Driver Information
                        <a href="{{ route('driver.add') }}">
                            <button class="btn gradient-nepal white big-shadow float-right">Add <i class="fa fa-pencil"
                                    aria-hidden="true"></i></button>
                        </a>

                    </h4>

                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard table-responsive">
                        <table class="table table-striped table-bordered alt-pagination">
                            <thead>
                                <tr class="text-center">
                                    <th>Driver Details</th>
                                    <th>Car Information</th>
                                    <th>Leave Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allData as $row )
                                <tr>
                                    <td>
                                        <img src="{{ asset($row->image) }}" alt="Image" class="carViewSize rounded mx-auto d-block">
                                        <div class="dropdown-divider"></div>
                                        <b>Name : </b>{{ $row->name }}<br>
                                        <b>Phone : </b>{{ $row->contact }}<br>
                                        <b>License : </b>{{ $row->license }}
                                    </td>

                                    <td>
                                        <img src="{{ asset($row->carImage) }}" alt="Image" class="carViewSize rounded mx-auto d-block">
                                        <div class="dropdown-divider"></div>
                                        <b>Name : </b>{{ $row->carName }}<br>
                                        <b>Number : </b>{{ $row->number }}<br>
                                        <b>Car Type : </b>
                                        @if ($row->temporary == 1)
                                            Temporary
                                        @else
                                            Regular
                                        @endif
                                    </td>

                                    <td>
                                        @php
                                        // Driver Personal Leave
                                        $drverLeave =  $checkStatus->CheckDriverLeave($row->carId, $row->id);
                                        // Car Maintance data
                                        $carMaintance = $checkStatus->CheckCarMaintance($row->carId, $row->id);
                                        // Police Reqisition data
                                        $carRequisition = $checkStatus->CheckCarRequisition($row->carId, $row->id);
                                        @endphp
                                        <!-- Driver Personal Leave -->
                                        <b>Leave : </b>
                                        @if ($drverLeave)

                                            {{ date("j-M-Y", strtotime($drverLeave->start)) }} ||
                                            {{ date("j-M-Y", strtotime($drverLeave->end)) }}
                                            <a id="cancel" class="btn-success pl-1 pr-1 rounded" href="{{ route('change.status',[$drverLeave->id,'diver_leaves','status','0']) }}" >Clear</a>
                                        @else
                                            No Data
                                        @endif
                                       <div class="dropdown-divider"></div>
                                        <b>Maintenance:</b>
                                        @if ($carMaintance)
                                          {{ date("j-M-Y", strtotime($carMaintance->start)) }} ||
                                          {{ date("j-M-Y", strtotime($carMaintance->end)) }}
                                            <a id="cancel" class="btn-success pl-1 pr-1 rounded" id="clearData"  href="{{ route('change.status',[$carMaintance->id,'car_maintenances','status','0']) }}">Clear</a>
                                        @else
                                            No Data
                                        @endif

                                       <div class="dropdown-divider"></div>
                                        <b>Police Reqisition:</b>
                                        @if ($carRequisition)
                                            {{ date("j-M-Y", strtotime($carRequisition->start)) }} ||
                                            {{ date("j-M-Y", strtotime($carRequisition->end)) }}
                                            <a id="cancel" class="btn-success pl-1 pr-1 rounded" id="clearData"
                                                href="{{ route('change.status',[$carRequisition->id,'car_requisitions','status','0']) }}">Clear</a>
                                        @else
                                            No Data
                                        @endif

                                    </td>


                                    <td>

                                        <button type="button"
                                            carId = "{{ $row->carId }}"
                                            driverId = "{{ $row->id }}"
                                            driverImage = "{{ $row->image }}"
                                            carImage = "{{ $row->carImage }}"
                                            driverName = "{{ $row->name }}"
                                            carName = "{{ $row->carName }}"
                                            carNumber = "{{ $row->number }}"
                                        class="actionBtn btn gradient-blue-grey-blue white">Action
                                        </button> <div class="dropdown-divider"></div>

                                        {{-- block --}}
                                        @if($row->status == 1)
                                        <a href="{{ route('change.status',[$row->id,'drivers','status','0']) }}" id="block"
                                            class="btn text-success"><i class="fa fa-check-square fa-lg"></i>
                                            : Block Status</a>

                                        @else
                                        <a href="{{ route('change.status',[$row->id,'drivers','status','1']) }}"
                                            id="unblock" class="btn text-danger"><i class="fa fa-times fa-lg"></i> :
                                            Block Status</a>
                                        @endif
                                        <br>
                                        <a href="{{ route('car.delete', [$row->id]) }}" id="delete"
                                            class="btn text-danger" title="Delete">
                                            <i class="fa fa-trash fa-lg"></i>: Delete</a>
                                        <br>

                                        <a href="{{ route('driver.edit', [$row->id]) }}" title="Edit"
                                            class="btn text-info"> <i class="fa fa-edit fa-lg"></i>: Edit</a>

                                    </td>


                                </tr>
                                @endforeach


                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--/ Alternative pagination table -->


{{-- modal  --}}


<!-- Modal -->
<div class="modal fade text-left" id="modalAction" tabindex="-1" role="dialog" aria-labelledby="modalActionLabel17"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalActionLabel17">Leave </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-6">
                        <table class="table">
                            <tr>
                                <th> Name:</th>
                                <td id="modalDriverName">No Data</td>
                            </tr>
                            <tr>
                                <th> Car Name:</th>
                                <td id="modalCarName">No Data</td>
                            </tr>
                            <tr>
                                <th> Car Number:</th>
                                <td id="modalCarNumber">No Data</td>
                            </tr>
                        </table>

                    </div>
                    <div class="col-md-6 text-center">
                        <img id="modalDriverImageSrc" src=""  class="img-responsive rounded" alt="Image" height="126"
                            width="135" />
                            <img id="modalCarImageSrc" src=""  class="img-responsive rounded ml-3" alt="Image" height="126" width="135" />
                    </div>
                </div>



                <form action="{{ route('driver.modal.action') }}" method="post">
                    @csrf
                    <input type="hidden" id="modalDriverId" name="driver_id">
                    <input type="hidden" id="modalCarId" name="car_id">
                    <div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                                <label>Leave Start:</label>
                                <div class='input-group'>
                                    <input type='text' class="form-control" id="datepicker" name="start"
                                        placeholder="Enter Start Date" required="required" />
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <span class="fa fa-calendar-o"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                           
                        </div>

                        <div class="col-md-6">
                            
                            <div class="form-group">
                                <label>Leave End:</label>
                                <div class='input-group'>
                                    <input type='text' class="form-control" id="datepicker2" name="end" placeholder="Enter End Date"
                                        required="required" />
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <span class="fa fa-calendar-o"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-md-4 label-control">Leave Type:</label>
                                <div class="col-md-8">
                                    <select name="leaveType" class="form-control" required>
                                        <option value="" disabled selected>Select Type </option>
                                        <option value="personal">Personal Leave</option>
                                        <option value="police">Police Requsition</option>
                                        <option value="maintenance">Car Maintenance</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-md-4 label-control">Leave Time:</label>
                                <div class="col-md-8">
                                    <select id="time_show" class="form-control">
                                        <option value="">Full Day</option>
                                        <option value="manualInput">Manual Input</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="manual_input_show" style="display:none;">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-md-4 label-control">Start Time:</label>
                                <div class="col-md-8">
                                    <select name="startHour" class="form-control">
                                        <option value="01:01:01">Default Time </option>
                                        <option value="09:00:00">9.00 AM </option>
                                        <option value="10:00:00">10.00 AM </option>
                                        <option value="11:00:00">11.00 AM </option>
                                        <option value="12:00:00">12.00 PM (Noon)</option>
                                        <option value="13:00:00">01.00 PM </option>
                                        <option value="14:00:00">02.00 PM </option>
                                        <option value="15:00:00">03.00 PM </option>
                                        <option value="16:00:00">04.00 PM </option>
                                        <option value="17:00:00">05.00 PM </option>
                                        <option value="18:00:00">06.00 PM </option>
                                        <option value="19:00:00">07.00 PM </option>
                                        <option value="20:00:00">08.00 PM </option>
                                        <option value="21:00:00">09.00 PM </option>
                                        <option value="22:30:00">10.00 PM </option>
                                        <option value="23:00:00">11.00 PM </option>
                                        <option value="23:59:00">12.00 AM (Night) </option>
                                        <option value="01:00:00">01.00 AM </option>
                                        <option value="02:00:00">02.00 AM </option>
                                        <option value="03:00:00">03.00 AM </option>
                                        <option value="04:00:00">04.00 AM </option>
                                        <option value="05:00:00">05.00 AM </option>
                                        <option value="06:00:00">06.00 AM </option>
                                        <option value="07:00:00">07.00 AM </option>
                                        <option value="08:00:00">08.00 AM </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-md-4 label-control">End Time:</label>
                                <div class="col-md-8">
                                    <select name="endHour" class="form-control">
                                        <option value="23:59:01">Default Time </option>
                                        <option value="09:00:00">9.00 AM </option>
                                        <option value="10:00:00">10.00 AM </option>
                                        <option value="11:00:00">11.00 AM </option>
                                        <option value="12:00:00">12.00 PM (Noon)</option>
                                        <option value="13:00:00">01.00 PM </option>
                                        <option value="14:00:00">02.00 PM </option>
                                        <option value="15:00:00">03.00 PM </option>
                                        <option value="16:00:00">04.00 PM </option>
                                        <option value="17:00:00">05.00 PM </option>
                                        <option value="18:00:00">06.00 PM </option>
                                        <option value="19:00:00">07.00 PM </option>
                                        <option value="20:00:00">08.00 PM </option>
                                        <option value="21:00:00">09.00 PM </option>
                                        <option value="22:30:00">10.00 PM </option>
                                        <option value="23:00:00">11.00 PM </option>
                                        <option value="23:59:00">12.00 AM (Night) </option>
                                        <option value="01:00:00">01.00 AM </option>
                                        <option value="02:00:00">02.00 AM </option>
                                        <option value="03:00:00">03.00 AM </option>
                                        <option value="04:00:00">04.00 AM </option>
                                        <option value="05:00:00">05.00 AM </option>
                                        <option value="06:00:00">06.00 AM </option>
                                        <option value="07:00:00">07.00 AM </option>
                                        <option value="08:00:00">08.00 AM </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>


            </div>

            <div class="modal-footer">
                <button type="submit" id="btnSubmitModal" name="submit"
                    class="btn btn-block gradient-sublime-vivid white">Apply Changes</button>
                <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
            </div>
            </form>


        </div>
    </div>
</div>


@endsection
