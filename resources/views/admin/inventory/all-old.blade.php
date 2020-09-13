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
                        @if (isset($srcTitle))
                            <b class="text-success" >Search</b> Product Information
                        @else
                            All Product Information
                        @endif

                        <a href="{{ route('inv.all.old') }}">
                            <button class="btn gradient-crystal-clear white big-shadow float-right mr-1">Reload <i class="ft-refresh-ccw"
                                    aria-hidden="true"></i></button>
                        </a>
                        <button id="searchBtn" class="btn gradient-politics white big-shadow float-right mr-1">Search <i class="fa fa-search" aria-hidden="true"></i></button>
                        <a href="{{ route('inv.add.old') }}">
                            <button class="btn gradient-nepal white big-shadow float-right mr-1"
                                >Add <i class="fa fa-pencil"
                                    aria-hidden="true"></i></button>
                        </a>

                    </h4>

                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard table-responsive">
                        <table class="table table-striped table-bordered file-export text-center small">
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>Category</th>
                                    <th>Subcategory</th>
                                    <th>Department</th>
                                    <th>B.U. Location</th>
                                    <th>Operations</th>
                                    <th>Product Model</th>
                                    <th>Serial</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allData as $row )
                                <tr>
                                    <td><button id="{{ $row->id }}" class="btn btn-sm gradient-politics white viewData mr-1"><i class="ft-eye"></i></button>
                                    <a href="{{ route('inv.eidt.old',$row->id ) }}" class="btn btn-sm gradient-purple-amber white" ><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                    </td>
                                    <td>{{ $row->category }}</td>
                                    <td>{{ $row->subcategory }}</td>
                                    <td>{{ $row->department }}</td>
                                    <td>{{ $row->bu_location }}</td>
                                    <td>{{ $row->operation }}</td>
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

{{-- Data Search Modal --}}
<div class="modal fade" id="dataSearchModal" tabindex="-1" role="dialog" aria-labelledby="dataSearchModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{ route('inv.old.search.action') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dataSearchModalLabel">Details Information </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Category</label>
                                <select class="form-control" name="category">
                                    <option value="">All Category </option>
                                    @foreach ($hardCategoryData as $hardCategory)
                                    <option value="{{ $hardCategory->category }}">{{ $hardCategory->category }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Department</label>
                                <select class="form-control" name="department">
                                    <option value="">All Department</option>
                                    @foreach ($deptData as $dept)
                                    <option value="{{ $dept->dept_name }}">{{ $dept->dept_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>B.U. Location</label>
                                <select class="form-control" name="bu_location">
                                    <option value="">All B.U. Location </option>
                                    @foreach ($buLocationData as $bulocation)
                                    <option value="{{ $bulocation->bu_location }}">{{ $bulocation->bu_location }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" id="btnSubmit" name="submit" class="btn btn-block gradient-nepal white">Apply
                        Changes</button>
                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>

    </div>
</div>

{{-- Data View Modal --}}
@include('admin.inventory.modal-data-view')


@endsection
