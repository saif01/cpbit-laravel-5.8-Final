@extends('admin.layout.inv-master')
{{-- Page CSS --}}
@section('page-css')
{{-- Data table css --}}
<link rel="stylesheet" type="text/css"
    href="{{ asset('admin/app-assets/vendors/css/tables/datatable/datatables.min.css') }}">

@endsection
{{-- Page Js --}}
@section('page-js')
{{-- ExportAble dataTable --}}
@include('admin.layout.dataTable.datatableExportJs')

<!-- Modal Show-->
<script src="{{ asset('admin/app-assets/js/components-modal.min.js') }}" type="text/javascript"></script>

<script>
    (function(){

    $(".viewData").click(function(){
          var id = $(this).attr("id");
        $.ajax({
        url: "{{ route('inv.given.details') }}",
        method: "GET",
        data: { id: id },
        dataType: "json",
        success: function (data) {
        $("#givenDataViewTbl > tr > td").remove();
        $("#category_m").text(data.category);
        $("#subcategory_m").text(data.subcategory);
        $("#bu_location_m").text(data.bu_location);
        $("#department_m").text(data.department);
        $("#operation_m").text(data.operation);
        $("#name_m").text(data.name);
        $("#remarks_m").html(data.remarks);
        $("#type_m").text(data.type);
        $("#serial_m").text(data.serial);
        $("#rec_name_m").text(data.rec_name);
        $("#rec_contact_m").text(data.rec_contact);
        $("#rec_position_m").text(data.rec_position);
        $("#reg_m").text(data.created_at);

        $("#dataViewModal").modal("show");

        },
        error: function (response) {
        console.log('Error', response);
        },
        });
    });

    $("#searchBtn").click(function(){
        $("#dataSearchModal").modal("show");
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
                    <h4 class="card-title">All Given Product Information </h4>

                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard table-responsive">
                        <table class="table table-striped table-bordered file-export text-center small">
                            <thead>
                                <tr>
                                    <th>View</th>
                                    <th>Category</th>
                                    <th>Subcategory</th>
                                    <th>Product Model</th>
                                    <th>Serial</th>
                                    <th>Warranty</th>
                                    <th>Purchase Date</th>
                                    <th>File</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allData as $row )
                                <tr>
                                    <td><button id="{{ $row->id }}" class="btn btn-sm gradient-politics white viewData">View <i class="ft-eye"></i></button></td>
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
                                  <td>{!! $row->remarks !!}</td>

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

{{-- Data View Modal --}}
<div class="modal fade" id="dataViewModal" tabindex="-1" role="dialog" aria-labelledby="dataViewModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dataViewModalLabel">Given Product Details Information </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12 row">
                    <div class="col-md-6 mb-0">

                        <table class="table" id="givenDataViewTbl">
                            <tr>
                                <th>Category Name</th>
                                <td id="category_m">No data</td>
                            </tr>

                            <tr>
                                <th>Subcategory </th>
                                <td id="subcategory_m">No data</td>
                            </tr>
                            <tr>
                                <th>B.U. location</th>
                                <td id="bu_location_m">No data</td>
                            </tr>
                            <tr>
                                <th>Department </th>
                                <td id="department_m">No data</td>
                            </tr>
                            <tr>
                                <th>Operation </th>
                                <td id="operation_m">No data</td>
                            </tr>
                            <tr>
                                <th>Product Name</th>
                                <td id="name_m">No data</td>
                            </tr>
                        </table>

                    </div>

                    <div class="col-md-6">
                        <table class="table mb-0">
                            <tr>
                                <th>Product Type</th>
                                <td id="type_m">No data</td>
                            </tr>
                            <tr>
                                <th>Product Serial</th>
                                <td id="serial_m">No data</td>
                            </tr>
                            <tr>
                                <th>Receiver Name</th>
                                <td id="rec_name_m">No data</td>
                            </tr>

                            <tr>
                                <th>Receiver Contact</th>
                                <td id="rec_contact_m">No data</td>
                            </tr>
                            <tr>
                                <th>Designation</th>
                                <td id="rec_position_m">No data</td>
                            </tr>
                            
                            <tr>
                                <th>Registration</th>
                                <td id="reg_m">No data</td>
                            </tr>
                        </table>
                    </div>

                    <table class="table">
                        <tr>
                            <th>Remarks</th>
                            <td id="remarks_m">sefjkettjio4tj weweogjje uejwetgjj4h</td>
                        </tr>
                    </table>

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
