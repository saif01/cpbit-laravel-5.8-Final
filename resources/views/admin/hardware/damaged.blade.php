@extends('admin.layout.hard-master')

{{-- Page CSS --}}
@section('page-css')
{{-- Data table css --}}
<link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/tables/datatable/datatables.min.css') }}">

@endsection
{{-- Page Js --}}
@section('page-js')


{{-- Data table js --}}
<script src="{{ asset('admin/app-assets/vendors/js/datatable/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('admin/app-assets/js/data-tables/datatable-basic.js') }}" type="text/javascript"></script>

<!-- Modal Show-->
<script src="{{ asset('admin/app-assets/js/components-modal.min.js') }}" type="text/javascript"></script>
{{-- User Details Modal --}}
@include('admin.layout.commonModals.userDetailsFunction')


<script>


    $(document).ready(function(){

        //All Data
        $('#jsDatatable').DataTable({
                language: {
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw text-success"></i><span class="sr-only">Loading...</span> '},
                processing: true,
                serverSide: true,
                pagingType: "full_numbers",
                stateSave: true,
                order: [ [0, 'desc'] ],

                ajax: {
                    url: "\damaged",
                },
                columns: [

                    {
                        data: 'com_num',
                        name: 'com_num'
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
                        data: 'bu_location',
                        name: 'bu_location',
                    },
                    {
                        data: 'lastUpdated',
                        name: 'lastUpdated',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        "searchable": false
                    },

                ]
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
                    <h4 class="card-title">All <b>Damaged</b> Complains Reports</h4>

                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard table-responsive">
                        <table id="jsDatatable" class="table table-striped table-bordered text-center" >
                            <thead>

                                <tr>
                                    <th>Num.</th>
                                    <th>Category</th>
                                    <th>SubCategory</th>
                                    <th>User</th>
                                    <th>B.U. Location</th>
                                    <th>Closed At</th>
                                    <th>Actions</th>
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
