@extends('admin.layout.master')
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

{{-- Admin Details Modal --}}
@include('admin.layout.commonModals.adminDetailsFunction')

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
                    <h4 class="card-title">All Admin LogIn <b class="text-success">Success</b> Information </h4>

                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard table-responsive">
                        <table class="table table-striped table-bordered alt-pagination text-center">
                            <thead>
                                <tr>
                                    <th>Admin</th>
                                    <th>Login</th>
                                    <th>Logout</th>
                                    <th>Status</th>
                                    <th>IP</th>
                                    <th>Device</th>
                                    <th>Browser</th>
                                    <th>City</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allData as $row )
                                <tr>
                                    <td>
                                        <a href="javascript:void(0);" class="viewAdminData" id="{{ $row->admin_id }}" title="View User Details">
                                           {{ $row->name }}
                                        </a>
                                    </td>

                                    <td>{{ date("F j, Y, g:i a", strtotime($row->created_at)) }}</td>
                                    <td>
                                        @if ($row->logout)
                                            {{ date("F j, Y, g:i a", strtotime($row->logout)) }}
                                        @else
                                            Not Logout
                                        @endif
                                    </td>
                                    <td>
                                        @if ($row->status == 1 )
                                            Ok
                                        @else
                                           Password Error
                                        @endif
                                    </td>
                                    <td> {{ $row->ip }}</td>
                                    <td> {{ $row->device }}</td>
                                    <td> {{ $row->browser }}</td>
                                    <td> {{ $row->city }}</td>

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

{{-- Admin Details Modal --}}
@include('admin.layout.commonModals.adminDetails')

@endsection
