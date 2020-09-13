@extends('admin.layout.room-master')

{{-- Page CSS --}}
@section('page-css')
{{-- Data table css --}}
<link rel="stylesheet" type="text/css"
    href="{{ asset('admin/app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
<style>
    .ViewSize {
        height: 150px;
        width: 150px;
    }
</style>
@endsection
{{-- Page Js --}}
@section('page-js')

{{-- Data table js --}}
<script src="{{ asset('admin/app-assets/vendors/js/datatable/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('admin/app-assets/js/data-tables/datatable-basic.js') }}" type="text/javascript"></script>
<!-- Custom Sweet alert -->
<script src="{{ asset('admin/app-assets/custom/sweetAlert2Function.js') }}" type="text/javascript"></script>
<!-- Modal Show-->
<script src="{{ asset('admin/app-assets/js/components-modal.min.js') }}" type="text/javascript"></script>
{{-- Deat Piker --}}
@include('admin.layout.datePiker.datePiker')

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
                    <h4 class="card-title">All Room Information
                        <a href="{{ route('room.add') }}">
                            <button class="btn gradient-nepal white big-shadow"
                                style="float: right; margin-right:3px;">Add <i class="fa fa-pencil"
                                    aria-hidden="true"></i></button>
                        </a>

                    </h4>

                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard table-responsive">
                        <table class="table table-striped table-bordered alt-pagination">
                            <thead>
                                <tr class="text-center">
                                    <th>Room Image</th>
                                    <th>Room Details</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allData as $row )
                                <tr>
                                    <td class="text-center">
                                        <img src="{{ asset($row->image) }}" alt="Image" class="ViewSize mr-1">
                                        <img src="{{ asset($row->image2) }}" alt="Image" class="ViewSize mr-1">
                                        <img src="{{ asset($row->image3) }}" alt="Image" class="ViewSize">

                                    </td>

                                    <td>
                                        <b>Name : </b>{{ $row->name }}<br>
                                        <b>Capacity : </b>{{ $row->capacity }} Persons<br><br>
                                        <b>Type : </b>{{ $row->type }}<br>
                                        <b>Remarks : </b>{{ $row->remarks }}
                                    </td>
                                    <td>

                                        {{-- block --}}
                                        @if($row->status == 1)
                                        <a href="{{ route('change.status',[$row->id,'rooms','status','0']) }}" id="block"
                                            class="btn text-success"><i class="fa fa-check-square fa-lg"></i>
                                            : Block Status</a>

                                        @else
                                        <a href="{{ route('change.status',[$row->id,'rooms','status','1']) }}"
                                            id="unblock" class="btn text-danger"><i class="fa fa-times fa-lg"></i> :
                                            Block Status</a>
                                        @endif
                                        <br>
                                        <a href="{{ route('room.delete', [$row->id]) }}" id="delete"
                                            class="btn text-danger" title="Delete">
                                            <i class="fa fa-trash fa-lg"></i>: Delete</a>
                                        <br>

                                        <a href="{{ route('room.edit', [$row->id]) }}" title="Edit"
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



@endsection
