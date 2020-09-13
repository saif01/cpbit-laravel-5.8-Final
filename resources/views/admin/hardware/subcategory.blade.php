@extends('admin.layout.hard-master')

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


        $('#dataAddByModal').click(function() {

            $('#modalForm')[0].reset();

            $('#dataModalLabel').text('SubCategory Add');

            $('#modalForm').prop('action', '{{ route("hard.subcategory.add.action") }}');

            $('#dataModal').modal('show');
        });


         $(".editByModal").click(function(){

            var id = $(this).attr("id");


            $('input[name="id"]').val( $(this).attr("id") );
            $('select[name="cat_id"]').val( $(this).attr("cat_id") );
            $('input[name="subcategory"]').val( $(this).attr("subcategory") );

            $('#dataModalLabel').text('Category Edit');
            $('#modalForm').prop('action', '{{ route("hard.subcategory.update.action") }}');
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
                    <h4 class="card-title">All Hardware SubCategory Name
                        <button class="btn gradient-nepal white big-shadow float-right" id="dataAddByModal"
                           >Add <i class="fa fa-pencil"
                                aria-hidden="true"></i></button>

                    </h4>

                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard table-responsive">
                        <table class="table table-striped table-bordered alt-pagination">
                            <thead>
                                <tr class="text-center">
                                    <th>Category</th>
                                    <th>SubCategory</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allData as $row )
                                <tr class="text-center">

                                    <td>
                                        {{ $row->category }}
                                    </td>
                                    <td>
                                        {{ $row->subcategory }}
                                    </td>

                                    <td>

                                        <a href="{{ route('hard.subcategory.delete',[$row->id]) }}" id="delete"
                                            class="btn text-danger" title="Delete"> <i class="fa fa-trash"></i>:
                                            Delete</a>


                                        <a href="javascript:void(0);" title="Edit" id="{{ $row->id }}" cat_id="{{ $row->cat_id }}"
                                            subcategory="{{ $row->subcategory }}" category="{{ $row->category }}"  class="editByModal text-warning"><i
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
<div class="modal fade" id="dataModal" tabindex="-1" role="dialog" aria-labelledby="dataModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dataModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="modalForm">
                    @csrf

                    <input type="hidden" name="id" id="id">

                    <div class="form-group">
                        <select name="cat_id" class="form-control"  >
                            <option value="" >Select Category Name</option>
                           @foreach ($categoryData as $item)
                               <option value="{{ $item->id }}">{{ $item->category }}</option>
                           @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <input type="text" name="subcategory" id="checkValue" class="inputField form-control"
                            placeholder="Type Application Subcategory Name" required="required">
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
