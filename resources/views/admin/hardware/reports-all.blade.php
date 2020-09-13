@extends('admin.layout.hard-master')

@section('page-css')
    {{-- Data table css --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
    <style>
        .btn-group, .btn-group-vertical {
            float: left;
        }
    </style>

@endsection

{{-- Page Js --}}
@section('page-js')
{{-- ExportAble dataTable --}}
@include('admin.layout.dataTable.datatableExportJs')

 {{-- JS tbl exports --}}
 {{-- @include('user.layout.data-tbl.export-tbl-js') --}}

<!-- Modal Show-->
<script src="{{ asset('admin/app-assets/js/components-modal.min.js') }}" type="text/javascript"></script>

{{-- User Details Modal --}}
@include('admin.layout.commonModals.userDetailsFunction')



<script>

    $(document).ready(function(){



        // Show data in page
        var table= $('#jsDataTable').DataTable({
            language: {
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw text-success"></i><span class="sr-only">Loading...</span> '},
            processing: true,
            serverSide: true,
            pagingType: "full_numbers",
            stateSave: true,
            order: [ [0, 'desc'] ],

            ajax:{
            url: "{{ route('hard.complain.report.all') }}",
            },
            columns:[

                    {
                        data: 'com_num',
                        name: 'com_num'
                    },
                    {
                        data: 'process',
                        name: 'process'
                    },
                    {
                        data: 'category',
                        name: 'category'
                    },
                    {
                        data: 'subcategory',
                        name: 'subcategory'
                    },
                    {
                        data: 'userName',
                        name: 'userName'
                    },
                    {
                        data: 'department',
                        name: 'department'
                    },
                    {
                        data: 'bu_location',
                        name: 'bu_location'
                    },
                    {
                        data: 'register',
                        name: 'register'
                    },
                    {
                        data: 'lastUpdated',
                        name: 'lastUpdated'
                    },
                    {
                        data: 'comStatus',
                        name: 'comStatus'
                    },



                    // {
                    //     data: 'action',
                    //     name: 'action',
                    //     orderable: false,
                    //     "searchable": false,
                    //     "width": "13%",
                    //     "class": "text-center"
                    // }
                ],
                dom: 'lBfrtip',
                buttons: [
                'excel', 'csv', 'pdf', 'copy', 'print'
                ],

        });




    });


    </script>


@endsection
{{-- End Js Section --}}

{{-- Start Main Content --}}
@section('content')

<!-- Alternative pagination table -->
<section >
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title text-capitalize"> All Hardware Complain Report's </h5>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard table-responsive">
                        <table id="jsDataTable" class="table table-striped table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Process</th>
                                    <th>Category</th>
                                    <th>Subcategory</th>
                                    <th>User</th>
                                    <th>Department</th>
                                    <th>B.U. Location</th>
                                    <th>Registration</th>
                                    <th>Last Update</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--/ Alternative pagination table -->

{{-- User Details Modal --}}
@include('admin.layout.commonModals.userDetails')

@endsection
