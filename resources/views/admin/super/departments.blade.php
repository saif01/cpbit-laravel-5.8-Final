@extends('admin.layout.master')

@section('page-css')
{{-- Data table css --}}
<link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/tables/datatable/datatables.min.css') }}">

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


        $(document).ready(function(){
        $('#checkValue').blur(function(){
        var error_Msg = '';
        var table ="departments";
        var field ="dept_name";
        var value = $('#checkValue').val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
                url:"{{ route('value_available.check') }}",
                method:"POST",
                data:{ _token:_token, value:value, table:table, field:field },
                success:function(result)
                {
                    if(result == 'unique')
                    {
                        $('#error_value').html('<label class="text-success">Value Available</label>');
                        $('#value').removeClass('has-error');
                        $('#btnSubmit').attr('disabled', false).css({"background-color": ""});
                    }
                    else
                    {
                        $('#error_value').html('<label class="text-danger">Value not Available</label>');
                        $('#value').addClass('has-error');
                        $('#btnSubmit').attr('disabled', 'disabled').css({"background-color": "red"});
                    }
                }
            })
        });
        });


        $('#departmentAdd').click(function() {

            $('#deptForm')[0].reset();

            $('#departmentLabel').text('Department Add');

            $('#deptForm').prop('action', '{{ route("department.add.action") }}');

            $('#department').modal('show');
        });


         $(".editByModal").click(function(){

            var _token = $('input[name="_token"]').val();
            var id = jQuery(this).attr("id");
            var table = "departments";
            $.ajax({
            url:"{{ route('edit.value') }}",
            method:"POST",
            data:{ _token:_token, id:id, table:table },
            dataType: "json",
                success:function(data)
                {

                    $('#departmentLabel').text('Department Edit');
                    $('#id').val(data.id);
                    $('.dept_name').val(data.dept_name);
                    $('#deptForm').prop('action', '{{ route("department.update.action") }}');
                    $('#department').modal('show');
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
                    <h4 class="card-title">All Departments Name
                       <button class="btn gradient-nepal white big-shadow float-right" id="departmentAdd" >Add <i
                                class="fa fa-pencil" aria-hidden="true"></i></button>

                    </h4>

                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard table-responsive">
                        <table class="table table-striped table-bordered alt-pagination">
                            <thead>
                                <tr class="text-center">
                                    <th>Departments</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allData as $row )
                                <tr class="text-center">

                                    <td>
                                        {{ $row->dept_name }}
                                    </td>

                                    <td>

                                        <a href="{{ route('department.delete',[$row->id]) }}" id="delete"
                                            class="btn text-danger" title="Delete"> <i
                                                class="fa fa-trash"></i>: Delete</a>


                                        <a href="javascript:void(0);" title="Edit" id="{{ $row->id }}"
                                            class="editByModal text-warning "><i
                                                class="fa fa-edit"></i>: Edit</a>
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
<div class="modal fade" id="department" tabindex="-1" role="dialog" aria-labelledby="departmentLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="departmentLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="deptForm" >
                    @csrf

                    <input type="hidden" name="id" id="id">

                    <div class="form-group">
                        <input type="text" name="dept_name" id="checkValue" class="dept_name form-control" placeholder="Type Department Name" required="required">
                        <span id="error_value"></span>
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
