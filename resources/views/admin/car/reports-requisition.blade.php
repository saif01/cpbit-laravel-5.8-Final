@extends('admin.layout.car-master')

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


{{-- Driver Details Modal --}}
@include('admin.layout.commonModals.driverDetailsFunction')
{{-- Car Details Modal --}}
@include('admin.layout.commonModals.carDetailsFunction')

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
                    <h4 class="card-title">All Car Police Requisition Report's</h4>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard table-responsive">
                        <table class="table table-striped table-bordered file-export">
                            <thead>
                                <tr class="text-center">
                                    <th>Driver</th>
                                    <th>Car</th>
                                    <th>Req. Start</th>
                                    <th>Req. Ends</th>
                                    <th>Status</th>
                                    <th>Register</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allData as $row )
                                <tr>
                                    <td>
                                        <a href="javascript:void(0);" class="viewDriverData" id="{{ $row->driver_id }}"
                                            title="View User Details">{{ $row->driverName }} </a>
                                    </td>
                                    <td>
                                        <a href="javascript:void(0);" class="viewCarData" id="{{ $row->car_id }}"
                                            title="View User Details">{{ $row->name." || ".$row->number }} </a>
                                    </td>
                                    <td>{{ date("F j, Y, g:i a", strtotime($row->start)) }}</td>
                                    <td>{{ date("F j, Y, g:i a", strtotime($row->end)) }}</td>
                                    <td>
                                        @if ($row->status == 1)
                                        Active
                                        @else
                                        Canceled
                                        @endif
                                    </td>
                                    <td>{{ date("F j, Y, g:i a", strtotime($row->created_at)) }}</td>

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

{{-- Driver Details Modal --}}
@include('admin.layout.commonModals.driverDetails')
{{-- Car Details Modal --}}
@include('admin.layout.commonModals.carDetails')


@endsection
