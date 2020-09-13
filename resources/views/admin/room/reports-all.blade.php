@extends('admin.layout.room-master')

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


<script>

    (function(){
        $(".viewRoomData").click(function () {
        var id = $(this).attr("id");
        $.ajax({
        url: "{{ route('room.details') }}",
        method: "GET",
        data: { id: id },
        dataType: "json",
        success: function (data) {
        $(".RoomImageForModal").attr("src", "{{ asset('/') }}" + data.image);
        $(".RoomNameForModal").text(data.name);
        $(".RoomTypeForModal").text(data.type);
        $(".RoomCapacityForModal").text(data.capacity);
        $(".RoomRemarksForModal").text(data.remarks);
        $("#RoomDataModal").modal("show");

        },
        error: function (response) {
        console.log('Error', response);
        },
        });
        });
    })(jQuery);



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

                        Room Booking Reports
                        <span class="text-danger" >{{ date("F j, Y", strtotime($searchData->start))." To ".date("F j, Y", strtotime($searchData->end))  }}</span>

                        @else
                            All Booking Report's
                        @endif
                        <a href="{{ route('room.report.all') }}"
                            class="btn btn-primary gradient-green-tea float-right">Reload <i class="fa fa-refresh" aria-hidden="true"></i></a>

                            <button id="SearchByModal" class="btn btn-success gradient-sublime-vivid  float-right mr-1">Search <i class="fa fa-search-plus" aria-hidden="true"></i></button>
                    </h5>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard table-responsive">
                        <table class="table table-striped table-bordered file-export">
                            <thead>
                                <tr class="text-center">
                                    <th>Room</th>
                                    <th>Booking</th>
                                    <th>Purpose</th>
                                    <th>Hours</th>
                                    <th>Use Name</th>
                                    <th>Department</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allData as $row )
                                <tr>
                                    <td>
                                        <a href="javascript:void(0);" class="viewRoomData" id="{{ $row->room_id }}"
                                            title="View User Details">{{ $row->name}} </a>
                                    </td>
                                    <td>{{ date("F j, Y, g:i a", strtotime($row->start)) }}</td>
                                    <td>{{ $row->purpose }}</td>
                                    <td>{{ $row->hours }} Hours.</td>
                                    <td>
                                        <a href="javascript:void(0);" class="viewUserData" id="{{ $row->user_id }}"
                                            title="View User Details">{{ $row->userName }} </a>
                                    </td>
                                    <td> {{ $row->department }} </td>
                                    <td>
                                        @if ($row->status == 1)
                                            Ok
                                        @else
                                            Canceled
                                        @endif
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


<!--Search Modal -->
<div class="modal fade" id="SearchDataModal" tabindex="-1" role="dialog" aria-labelledby="SearchDataModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="SearchDataModalLabel">Search Room Report's</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

               <form action="{{ route('room.report.search') }}" id="ModalForm" method="post">
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
                                <label>Select Room</label>
                                <select name="room_id" class="form-control">
                                    <option value="Allroom">All Room Reports</option>
                                   @foreach ($roomData as $room)
                                    <option value="{{ $room->id }}">{{ $room->name }}</option>
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


<!--Meeting Room Details Modal -->
<div class="modal fade text-left" id="RoomDataModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel1">Room Details</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="data_show">
                <table class="table table-striped">

                    <div class="row">
                        <img src="" alt="Image" class="RoomImageForModal  user-s"
                            style="position: sticky !important;margin-top: -77px;">
                    </div>

                    <tr>
                        <td><label>Name</label></td>
                        <td class="RoomNameForModal">No Data</td>
                    </tr>
                    <tr>
                        <td><label>RoomType</label></td>
                        <td class="RoomTypeForModal">No Data</td>
                    </tr>
                    <tr>
                        <td><label>Capacity</label></td>
                        <td class="RoomCapacityForModal">No Data</td>
                    </tr>
                    <tr>
                        <td><label>Remarks</label></td>
                        <td class="RoomRemarksForModal">No Data</td>
                    </tr>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn gradient-plum white btn-block" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- User Details Modal --}}
@include('admin.layout.commonModals.userDetails')


@endsection
