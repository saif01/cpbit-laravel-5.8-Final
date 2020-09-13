@extends('admin.layout.app-master')

{{-- Page CSS --}}
@section('page-css')
{{-- Data table css --}}
<link rel="stylesheet" type="text/css"
    href="{{ asset('admin/app-assets/vendors/css/tables/datatable/datatables.min.css') }}">

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
{{-- User Details Modal --}}
@include('admin.layout.commonModals.userDetailsFunction')

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
                    <h4 class="card-title">All <b>Closed</b> Complains Reports </h4>

                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard table-responsive">
                        <table class="table table-striped table-bordered alt-pagination text-center">
                            <thead>
                                <tr class="text-center">
                                <tr>
                                    <th>Num.</th>
                                    <th>Software</th>
                                    <th>Module</th>
                                    <th>User</th>
                                    <th>Dept.</th>
                                    <th>Actions</th>
                                </tr>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allData as $row )
                                <tr>
                                    <td> <span class="badge badge-pill gradient-green-tea white h5">{{ $row->id }}</span>
                                    </td>
                                    <td> {{ $row->category }} </td>
                                    <td> {{ $row->subcategory }} </td>
                                    <td> <a href="javascript:void(0);" class="viewUserData" id="{{ $row->user_id }}" title="View User Details">{{ $row->name }}
                                    </a></td>
                                    <td> {{ $row->department }} </td>
                                    <td>
                                       <a href="{{ route('app.complain.action', $row->id) }}" title="Action"> <span class="btn gradient-amber-amber white"><i
                                                    class="fa fa-edit text-success"></i> Details</span> </a>
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
{{-- User Details Modal --}}
@include('admin.layout.commonModals.userDetails')

@endsection
