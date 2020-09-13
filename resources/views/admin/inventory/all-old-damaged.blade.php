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

<!-- Custom Sweet alert -->
<script src="{{ asset('admin/app-assets/custom/sweetAlert2Function.js') }}" type="text/javascript"></script>

<!-- Modal Show-->
<script src="{{ asset('admin/app-assets/js/components-modal.min.js') }}" type="text/javascript"></script>

{{-- Data View JS Functions --}}
@include('admin.inventory.modal-data-view-function')

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
                    <h4 class="card-title">
                       <b class="text-danger">Damaged</b> Product Information </h4>

                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard table-responsive">
                        <table class="table table-striped table-bordered file-export text-center small">
                            <thead>
                                <tr>
                                    <th>View</th>
                                    <th>Category</th>
                                    <th>Subcategory</th>
                                    <th>Department</th>
                                    <th>B.U. Location</th>
                                    <th>Product Model</th>
                                    <th>Serial</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allData as $row )
                                <tr>
                                    <td><button id="{{ $row->id }}" class="btn btn-sm gradient-politics white viewData"><i class="ft-eye"></i></button>
                                    </td>
                                    <td>{{ $row->category }}</td>
                                    <td>{{ $row->subcategory }}</td>
                                    <td>{{ $row->department }}</td>
                                    <td>{{ $row->bu_location }}</td>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->serial }}</td>

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
@include('admin.inventory.modal-data-view')


@endsection
