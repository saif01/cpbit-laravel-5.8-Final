@extends('admin.layout.app-master')

@section('page-css')
    {{-- Data table css --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
@endsection

{{-- Page Js --}}
@section('page-js')
{{-- ExportAble dataTable --}}
@include('admin.layout.dataTable.datatableExportJs')

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
                    <h5 class="card-title text-capitalize"> All Application Complain Report's </h5>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard table-responsive">
                        <table class="table table-striped table-bordered file-export">
                            <thead>
                                <tr class="text-center">
                                    <th>No.</th>
                                    <th>Process</th>
                                    <th>Category</th>
                                    <th>Subcategory</th>
                                    <th>User</th>
                                    <th>Dept.</th>
                                    <th>Registration</th>
                                    <th>Last Update</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allData as $row )
                                <tr>
                                   <td> <span class="badge badge-pill gradient-green-tea white h5" >{{ $row->id }}</span>
                                    </td>
                                    <td> {{ $row->process }} </td>
                                    <td> {{ $row->category }} </td>
                                    <td> {{ $row->subcategory }} </td>
                                    <td> <a href="javascript:void(0);" class="viewUserData" id="{{ $row->user_id }}" title="View User Details">{{ $row->name }} </a></td>
                                    <td>{{ $row->department }} </td>
                                    <td>{{ date("F j, Y, g:i a", strtotime($row->created_at)) }}</td>
                                    <td>{{ date("F j, Y, g:i a", strtotime($row->updated_at)) }}</td>
                                    <td>
                                        @if ($row->status == 1)
                                            Ok
                                        @else
                                            Canceled
                                        @endif
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
