@extends('admin.layout.car-master')

{{-- Page CSS --}}
@section('page-css')
{{-- Data table css --}}
<link rel="stylesheet" type="text/css"
    href="{{ asset('admin/app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
    <style>
    .carViewSize{
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
                    <h4 class="card-title">All Car Information
                        <a href="{{ route('car.add') }}">
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
                                    <th>Car Image</th>
                                    <th>Car Details</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allData as $row )
                                <tr>
                                    <td class="text-center">
                                        <img src="{{ asset($row->image) }}" alt="Image" class="carViewSize">
                                        <img src="{{ asset($row->image2) }}" alt="Image" class="carViewSize">
                                        <img src="{{ asset($row->image3) }}" alt="Image" class="carViewSize">

                                    </td>

                                    <td>
                                        <b>Name : </b>{{ $row->name }}<br>
                                        <b>Number : </b>{{ $row->number }}
                                        <br>


                                        <b>Car Type : </b>
                                        @if($row->temporary == 1)
                                        Temporary <a href="{{ route('change.status',[$row->id,'cars','temporary','0']) }}" id="regular"
                                            class="float-right btn-success pl-1 pr-1"> Regular</a>
                                        @else
                                        Regular <a href="{{ route('change.status',[$row->id,'cars','temporary','1']) }}" id="temporaty"
                                            class="float-right btn-info pl-1 pr-1"> Temporary</a>
                                        @endif
                                        <br>
                                        <b>Capacity : </b>{{ $row->capacity }} Persons<br>
                                        <b>Remarks : </b>{{ $row->remarks }}
                                        {{-- <div class="dropdown-divider"></div> --}}<br>
                                        <b>Use Deadline : </b>

                                        @if (!empty($row->last_use))
                                            {{ date("j-M-Y", strtotime($row->last_use))  }}
                                            <a href="{{ route('car.deadline.clear',[$row->id]) }}" id="clearDeadline"
                                                class="float-right btn-success pl-1 pr-1"> Clear</a>
                                        @else
                                            <s>Not Fix</s>
                                        @endif




                                    </td>
                                    <td>

                                        <button type="button" id="{{ $row->id }}" class="deadlineFixBtn btn gradient-blue-grey-blue white" >Car Deadline Fix</button> <br>

                                        {{-- block --}}
                                        @if($row->status == 1)
                                        <a href="{{ route('change.status',[$row->id,'cars','status','0']) }}"
                                            id="block" class="btn text-success"><i class="fa fa-check-square fa-lg"></i>
                                            : Block Status</a>

                                        @else
                                        <a href="{{ route('change.status',[$row->id,'cars','status','1']) }}"
                                            id="unblock" class="btn text-danger"><i class="fa fa-times fa-lg"></i> :
                                            Block Status</a>
                                        @endif
                                        <br>
                                        <a href="{{ route('car.delete', [$row->id]) }}" id="delete"
                                            class="btn text-danger" title="Delete">
                                            <i class="fa fa-trash fa-lg"></i>: Delete</a>
                                        <br>

                                        <a href="{{ route('car.edit', [$row->id]) }}" title="Edit"
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
<div class="modal fade" id="deadlineFix" tabindex="-1" role="dialog" aria-labelledby="deadlineFixLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deadlineFixLabel">Car Deadline Fix Date</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <table class="table table-striped">
                    <tr>
                        <th> Car Name:</th>
                        <td id="carName">No data </td>

                        <th> Car Number:</th>
                        <td id="carNumber"> No Data</td>
                    </tr>
                </table>


                <form action="{{ route('car.deadline.fix') }}" method="POST">
                    @csrf

                    <input type="hidden" id="IdDateLineFix" name="id">

                   <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-md-3 label-control">Effective Date: </label>
                                <div class="col-md-9">
                                    <div class='input-group'>
                                        <input type='text' id="datepicker" class="form-control" name="last_use" placeholder="Date of birth"
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
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" id="btnSubmit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>




@endsection
