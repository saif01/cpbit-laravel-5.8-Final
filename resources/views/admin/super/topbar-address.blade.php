@extends('admin.layout.master')

@section('page-css')
{{-- Data table css --}}
<link rel="stylesheet" type="text/css"
    href="{{ asset('admin/app-assets/vendors/css/tables/datatable/datatables.min.css') }}">

@endsection
{{-- Page Js --}}
@section('page-js')

<!-- Modal Show-->
<script src="{{ asset('admin/app-assets/js/components-modal.min.js') }}" type="text/javascript"></script>

{{-- Data table js --}}
<script src="{{ asset('admin/app-assets/vendors/js/datatable/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('admin/app-assets/js/data-tables/datatable-basic.js') }}" type="text/javascript"></script>
<!-- Custom Sweet alert -->
<script src="{{ asset('admin/app-assets/custom/sweetAlert2Function.js') }}" type="text/javascript"></script>

<script>
    $(function() {
        $('form').submit(function() {
        setTimeout(function() {
        disableButton();
        }, 0);
        });

        function disableButton() {
        $("#btnSubmit").prop('disabled', true);
        }
        });


        $('#departmentAdd').click(function() {

            $('#modalForm')[0].reset();

            $('#modalLebel').text('Topbar Information Add');

            $('#modalForm').prop('action', '{{ route("topbar.add.action") }}');

            $('#dataModal').modal('show');
        });


         $(".editByModal").click(function(){

            $('#modalLebel').text('Topbar Information Edit');
            $('#modalForm').prop('action', '{{ route("topbar.update.action") }}');
            $('input[name="id"]').val( $(this).attr("id") );
            $('select[name="project"]').val( $(this).attr("project") );
            $('input[name="address"]').val( $(this).attr("address") );
            $('input[name="contact_name"]').val( $(this).attr("contact_name") );
            $('input[name="office_time"]').val( $(this).attr("office_time") );
            $('input[name="office_day"]').val( $(this).attr("office_day") );
            $('#dataModal').modal('show');

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
                    <h4 class="card-title">All Project Topbar Information
                        <button class="btn gradient-nepal white big-shadow" id="departmentAdd"
                            style="float: right; margin-right:3px;">Add <i class="fa fa-pencil"
                                aria-hidden="true"></i></button>

                    </h4>

                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard table-responsive">
                        <table class="table table-striped table-bordered alt-pagination">
                            <thead>
                                <tr class="text-center">
                                    <th>Project</th>
                                    <th>Address</th>
                                    <th>Contact & Name</th>
                                    <th>Office Time</th>
                                    <th>Office Day</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allData as $row )
                                <tr>
                                    <td>
                                        {{ $row->project }}
                                    </td>
                                    <td>
                                        {{ $row->address }}
                                    </td>
                                    <td>
                                        {{ $row->contact_name }}
                                    </td>

                                    <td>
                                        {{ $row->office_time }}
                                    </td>
                                    <td>
                                        {{ $row->office_day }}
                                    </td>

                                    <td>

                                        <a href="{{ route('topbar.delete',[$row->id]) }}" id="delete"
                                            class="text-danger" title="Delete"> <i class="fa fa-trash"></i>: Delete</a> <br>

                                        <a href="javascript:void(0);" title="Edit" id="{{ $row->id }}" project="{{ $row->project }}" address="{{ $row->address }}" contact_name="{{ $row->contact_name }}" office_time="{{ $row->office_time }}" office_day="{{ $row->office_day }}" class="editByModal "><i class="fa fa-edit"></i>: Edit</a>
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


<!-- Modal -->
<div class="modal fade" id="dataModal" tabindex="-1" role="dialog" aria-labelledby="dataModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLebel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="modalForm">
                    @csrf

                    <input type="hidden" name="id" id="id">

                    <div class="form-group row">
                        <div class="col-md-6">
                            <select name="project" class="form-control" required="required">
                                <option value="" >Select Project For Topbar</option>
                                <option value="carpool">Carpool</option>
                                <option value="room">Room Booking</option>
                                <option value="cms">CMS</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="address" class="address form-control" placeholder="Type Company Address"
                                required="required">
                        </div>

                    </div>
                    <div class="form-group row">
                       <div class="col-md-12">
                        <input type="text" name="contact_name" class="form-control" placeholder="Type  Name & Contact"
                            required="required">
                      </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <input type="text" name="office_day" class="form-control" placeholder="Type Office Day ( Sat-Thu )"
                                required="required">
                        </div>
                      <div class="col-md-6">
                        <input type="text" name="office_time" class="form-control"
                            placeholder="Type Office Time ( 09.00 AM - 6.00 PM )" required="required">
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
