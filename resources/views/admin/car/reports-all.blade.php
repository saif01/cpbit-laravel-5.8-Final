@extends('admin.layout.car-master')

@section('page-css')
    {{-- Data table css --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
@endsection

{{-- Page Js --}}
@section('page-js')
{{-- ExportAble dataTable --}}
@include('admin.layout.dataTable.datatableExportJs')
{{-- Deat Piker --}}
@include('admin.layout.datePiker.datePiker')
<!-- Modal Show-->
<script src="{{ asset('admin/app-assets/js/components-modal.min.js') }}" type="text/javascript"></script>
<!-- Custom Sweet alert -->
<script src="{{ asset('admin/app-assets/custom/sweetAlert2Function.js') }}" type="text/javascript"></script>

{{-- User Details Modal --}}
@include('admin.layout.commonModals.userDetailsFunction')
{{-- Driver Details Modal --}}
@include('admin.layout.commonModals.driverDetailsFunction')
{{-- Car Details Modal --}}
@include('admin.layout.commonModals.carDetailsFunction')

<script>
    (function(){
    $("#SearchByModal").click( ()=>{
    $('#ModalForm')[0].reset();
    $("#SearchDataModal").modal("show");
    });
    })(jQuery);
</script>

@endsection
{{-- End Js Section --}}

{{-- Start Main Content --}}
@section('content')

<!-- Alternative pagination table -->
<section id="pagination">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title text-capitalize">
                        @if (isset($searchData))

                        Car Booking Reports
                        <span class="text-danger" >{{ date("F j, Y", strtotime($searchData->start))." To ".date("F j, Y", strtotime($searchData->end))  }}</span>

                        @else
                            All Booking Report's
                        @endif
                        <a href="{{ route('car.report.all') }}"
                            class="btn btn-primary gradient-green-tea float-right">Reload <i class="fa fa-refresh" aria-hidden="true"></i></a>

                            <button id="SearchByModal" class="btn btn-success gradient-sublime-vivid  float-right mr-1">Search <i class="fa fa-search-plus" aria-hidden="true"></i></button>
                    </h5>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard table-responsive small" >
                        <table class="table table-striped table-bordered file-export">
                            <thead>
                                <tr class="text-center">
                                    <th>Car</th>
                                    <th>Booking Start</th>
                                    <th>Booking Ends</th>
                                    <th>Destination</th>
                                    <th>Purpose</th>
                                    <th>User</th>
                                    <th>Driver</th>
                                    <th>Status</th>
                                    <th>Gasoline</th>
                                    <th>Octane</th>
                                    <th>Toll</th>
                                    <th>Total</th>
                                    <th>Milage</th>
                                    <th>K.M.</th>
                                    <th>Rating</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allData as $row )
                                <tr>
                                    <td>
                                        <a href="javascript:void(0);" class="viewCarData" id="{{ $row->car_id }}"
                                            title="View User Details">{{ $row->name." || ".$row->number }} </a>
                                    </td>
                                    <td>{{ date("F j, Y, g:i a", strtotime($row->start)) }}</td>
                                    <td>{{ date("F j, Y, g:i a", strtotime($row->end)) }}</td>
                                    <td>{{ $row->destination }}</td>
                                    <td>{{ $row->purpose }}</td>
                                    <td>
                                        <a href="javascript:void(0);" class="viewUserData" id="{{ $row->user_id }}"
                                            title="View User Details">{{ $row->userName }} </a>
                                    </td>
                                    <td>
                                        <a href="javascript:void(0);" class="viewDriverData" id="{{ $row->driver_id }}"
                                            title="View User Details">{{ $row->driverName }} </a>
                                    </td>
                                    <td>
                                        @if ($row->status == 1)
                                            Booked
                                        @else
                                            Canceled
                                        @endif
                                    </td>
                                    <td>{{ $row->gas }}</td>
                                    <td>{{ $row->octane }}</td>
                                    <td>{{ $row->toll }}</td>
                                    <td>{{ $row->cost }}</td>
                                    <td>{{ $row->start_mileage ." || ".$row->end_mileage  }}</td>
                                    <td>{{ $row->km }}</td>
                                    <td>{{ $row->driver_rating }}</td>
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


<!-- Modal -->
<div class="modal fade" id="SearchDataModal" tabindex="-1" role="dialog" aria-labelledby="SearchDataModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="SearchDataModalLabel">Single Car Report's</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

               <form action="{{ route('car.report.search') }}" id="ModalForm" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Start Date</label>
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

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>End Date</label>
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

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Select Car</label>
                                <select name="car_id" class="form-control">
                                    <option value="AllCar">All Car Reports</option>
                                   @foreach ($carData as $car)
                                    <option value="{{ $car->id }}">{{ $car->name .' || '. $car->number .' || '. $car->driverName}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">View Reports</button>
                </div>

            </form>
        </div>
    </div>
  </div>
</div>

{{-- User Details Modal --}}
@include('admin.layout.commonModals.userDetails')
{{-- Driver Details Modal --}}
@include('admin.layout.commonModals.driverDetails')
{{-- Car Details Modal --}}
@include('admin.layout.commonModals.carDetails')



@endsection
