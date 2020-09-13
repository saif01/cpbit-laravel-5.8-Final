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
                    <h4 class="card-title"><span class="text-success">{{ $operation }}</span> All Product Count List </h4>

                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard table-responsive">
                        <table class="table table-striped table-bordered file-export text-center">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
 
                                @foreach ($allData as $row )
                                <tr>
                                   <td>{{ $row->category }}</td>
                                   <td>{{ $row->total }}</td>
                                  
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
