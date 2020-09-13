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
                    <h4 class="card-title">All Warranty <b class="text-danger" >Expired</b> Product Information </h4>

                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard table-responsive">
                        <table class="table table-striped table-bordered file-export text-center smal">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Subcategory</th>
                                    <th>Product Model</th>
                                    <th>Serial</th>
                                    <th>Warranty</th>
                                    <th>File</th>
                                    <th>Registration</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($allData as $row )
                                <tr>
                                   <td>{{ $row->category }}</td>
                                   <td>{{ $row->subcategory }}</td>
                                   <td>{{ $row->name }}</td>
                                   <td>{{ $row->serial }}</td>
                                   <td> {{ date("F j, Y", strtotime($row->warranty)) }} </td>
                                   <td>
                                        @if ($row->document)
                                            <a href="{{ asset($row->document) }}" class="btn btn-sm gradient-politics white" download>File <i class="ft-download"></i></a>
                                        @else
                                            No File
                                        @endif
                                   </td>
                                   <td>
                                       @if ($row->created_at)
                                            {{ date("F j, Y", strtotime($row->created_at)) }}
                                       @else
                                            No Data Available
                                       @endif
                                    </td>
                                   <td>
                                     {!! $row->remarks !!}
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



@endsection
