@extends('admin.layout.inv-master')
{{-- Page CSS --}}
@section('page-css')
{{-- Data table css --}}
<link rel="stylesheet" type="text/css"
    href="{{ asset('admin/app-assets/vendors/css/tables/datatable/datatables.min.css') }}">

<!-- Summernote Editor CSS -->
<link href="{{ asset('admin/app-assets/custom/summernote/summernote-lite.css')}}" rel="stylesheet" />
@endsection
{{-- Page Js --}}
@section('page-js')
{{-- Data table js --}}
<script src="{{ asset('admin/app-assets/vendors/js/datatable/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('admin/app-assets/js/data-tables/datatable-basic.js') }}" type="text/javascript"></script>
<!-- Custom Sweet alert -->
<script src="{{ asset('admin/app-assets/custom/sweetAlert2Function.js') }}" type="text/javascript"></script>
<!-- Custom Sweet alert -->
<script src="{{ asset('admin/app-assets/custom/sweetAlert2Function.js') }}" type="text/javascript"></script>
<!-- Modal Show-->
<script src="{{ asset('admin/app-assets/js/components-modal.min.js') }}" type="text/javascript"></script>

<!-- Summernote JS -->
<script src="{{ asset('admin/app-assets/custom/summernote/summernote-lite.js') }}"></script>

<script>

        (function(){


            $('textarea').summernote({
            placeholder: 'Write Detail about this Product.',
            tabsize: 5,
            height: 80,
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['font', ['strikethrough']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']]
            ],
        });

            $('.productGive').click(function(){
                var id = $(this).attr('id');
                    $.ajax({
                        url:  "{{ route('inv.single.new.product') }}",
                        type: "GET",
                        data: { id : id },
                        success: function(data){

                            $("#giveForm")[0].reset();
                            $('#new_pro_id').val(data.id);
                            $('#category').val(data.category);
                            $('#subcategory').val(data.subcategory);
                            $('#name').val(data.name);
                            $('#serial').val(data.serial);
                            $('#dataGiveModal').modal('show');

                        },
                        error: function (request, status, error) {
                        console.log(request.responseText);
                        }
                    });
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
                    <h4 class="card-title">All New Product Information
                        <a href="{{ route('inv.add.new') }}">
                            <button class="btn gradient-nepal white big-shadow float-right mr-1"
                               >Add <i class="fa fa-pencil"
                                    aria-hidden="true"></i></button>
                        </a>

                    </h4>

                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard table-responsive">
                        <table class="table table-striped table-bordered alt-pagination text-center ">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Subcategory</th>
                                    <th>Product Model</th>
                                    <th>Serial</th>
                                    <th>Warranty</th>
                                    <th>Purchase Date</th>
                                    <th>File</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allData as $row )
                                <tr>
                                   <td>{{ $row->category }}</td>
                                   <td>{{ $row->subcategory }}</td>
                                   <td>{{ $row->name }}</td>
                                   <td>{{ $row->serial }}</td>
                                   <td>
                                        @if ($row->warranty)
                                            {{ date("F j, Y", strtotime($row->warranty)) }}
                                        @else
                                            No Warranty
                                        @endif
                                    </td>
                                   <td>{{ date("F j, Y", strtotime($row->purchase)) }}</td>
                                   <td>
                                        @if ($row->document)
                                            <a href="{{ asset($row->document) }}" class="btn btn-sm gradient-politics white" download>File <i class="ft-download"></i></a>
                                        @else
                                            No File
                                        @endif
                                   </td>
                                   <td>
                                        @if (session()->get('admin.super') == 1)
                                            <a href="{{ route('inv.new.delete', $row->id) }}" id="delete" class="btn btn-danger btn-sm">Delete <i class="ft-trash-2"></i></a>
                                        @endif

                                       <a href="{{ route('inv.add.new.edit', $row->id) }}" class="btn btn-warning btn-sm white ">Edit <i class="ft-edit"></i></a>

                                       <button  id="{{ $row->id }}" class="productGive btn btn-sm btn-success" >Give <i class="ft-upload" ></i></button>
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

<!--  Modal content for Product Give -->
<div class="modal fade" id="dataGiveModal" tabindex="-1" role="dialog" aria-labelledby="DataGiveModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="DataGiveModalLabel">Product Give</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <form method="post" action="{{ route('inv.give.new.action') }}" id="giveForm" >
                @csrf
                    <input type="hidden" name="new_pro_id" id="new_pro_id" >
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Category</label>
                                <input type="text" class="form-control" id="category" name="category" readonly>

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Subcategory</label>
                                <input type="text" class="form-control" id="subcategory" name="subcategory" readonly>

                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Product Name</label>
                                <input type="text" class="form-control" id="name" name="name" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Serial Number</label>
                                <input type="text" class="form-control" id="serial" name="serial" readonly>
                            </div>
                        </div>
                    </div>


                <div>

                    <div class="row">


                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">B.U. Location</label>
                               <select class="form-control" name="bu_location" required="required">
                                    <option value="" disabled selected>Select B.U. Location Name</option>
                                    @foreach ($buLocationData as $bulocation)
                                    <option value="{{ $bulocation->bu_location }}">{{ $bulocation->bu_location }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Department</label>
                               <select class="form-control" name="department" required="required">
                                    <option value="" disabled selected>Select Department Name</option>
                                    @foreach ($deptData as $dept)
                                    <option value="{{ $dept->dept_name }}">{{ $dept->dept_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Operation Name</label>
                                <select class="form-control" name="operation" required="required">
                                    <option value="" disabled selected>Select Operation Name</option>
                                    @foreach ($operationData as $operation)
                                    <option value="{{ $operation->operation }}">{{ $operation->operation }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Receiever Name</label>
                                <input type="text" class="form-control" name="rec_name" placeholder="Enter Receiever Name"
                                    required="required">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="control-label">Remarks</label>
                                <textarea name="remarks" class="form-control"
                                    placeholder="Enter some remarks about Product or Receiever........." rows="4" cols="20"
                                    required="required"></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Contact Number</label>
                                <input type="number" class="form-control" name="rec_contact"
                                    placeholder="Enter Receiever Contact Number" required="required">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Designation</label>
                                <input type="text" class="form-control" name="rec_position" placeholder="Enter Receiever Designation"
                                    required="required">
                            </div>
                            <input type="hidden" class="form-control" id="quentity" name="quentity" value="1">

                        </div>
                    </div>


                </div>


                </div>
                <div class="modal-footer">
                    <button type="submit" id="btnSubmit" name="submit" class="btn btn-block gradient-nepal white">Apply Changes</button>
                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                </div>

            </form>
        </div>
    </div>
</div>


@endsection
