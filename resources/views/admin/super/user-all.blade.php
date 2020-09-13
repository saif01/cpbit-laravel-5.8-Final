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
                    <h4 class="card-title">All User Information
                        <a href="{{ route('user.add') }}">
                            <button class="btn gradient-nepal white big-shadow float-right"
                                >Add <i class="fa fa-pencil"
                                    aria-hidden="true"></i></button>
                        </a>

                    </h4>

                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard table-responsive">
                        <table class="table table-striped table-bordered alt-pagination">
                            <thead>
                                <tr class="text-center">
                                    <th>Image</th>
                                    <th>Details</th>
                                    <th>Authorization</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allData as $row )
                                <tr>
                                    <td class="text-center">
                                        <a href="javascript:void(0);" class="viewUserData" id="{{ $row->id }}" title="View User Details">
                                            <img src="{{ asset($row->image) }}" alt="Image" height="100" width="100">
                                        </a>
                                    </td>

                                    <td>
                                        @if ($row->isOnline())
                                            <span class="float-right badge gradient-green-tea white"><i class="ft-disc"></i> Online</span>
                                        @else
                                            <span class="float-right badge gradient-shdow-night white"> <i class="ft-disc red"></i> Offline</span>
                                        @endif
                                        <b>Login : </b>{{ $row->login }}<br>
                                        <b>Name : </b>{{ $row->name }}
                                        <div class="dropdown-divider"></div>
                                        <b>Phone : </b>{{ $row->contact }}<br>
                                        <b>Email : </b>{{ $row->email }}<br>
                                    </td>


                                    <td>

                                        {{-- carpool Access --}}
                                        @if($row->car == 1)
                                        <a href="{{ route('change.status',[$row->id,'users','car','0']) }}" id="remove"
                                            class="text-success btn"><i class="fa fa-check-square fa-lg"></i> : Carpool </a>

                                        @else
                                        <a href="{{ route('change.status',[$row->id,'users','car','1']) }}" id="give"
                                            class="text-danger btn"><i class="fa fa-times fa-lg"></i> :
                                            Carpool </a>
                                        @endif
                                        <br>

                                        {{-- room Access --}}
                                        @if($row->room == 1)
                                        <a href="{{ route('change.status',[$row->id,'users','room','0']) }}"
                                            id="remove" class="text-success btn"><i class="fa fa-check-square fa-lg"></i> :
                                            Room </a>

                                        @else
                                        <a href="{{ route('change.status',[$row->id,'users','room','1']) }}" id="give"
                                            class="text-danger btn"><i class="fa fa-times fa-lg"></i> :
                                            Room </a>
                                        @endif

                                        <br>

                                        {{-- it_connect Access --}}
                                        @if($row->it_connect == 1)
                                        <a href="{{ route('change.status',[$row->id,'users','it_connect','0']) }}"
                                            id="remove" class="text-success btn"><i class="fa fa-check-square fa-lg"></i> :
                                       iService </a>

                                        @else
                                        <a href="{{ route('change.status',[$row->id,'users','it_connect','1']) }}" id="give"
                                            class="text-danger btn"><i class="fa fa-times fa-lg"></i> :
                                           iService </a>
                                        @endif

                                        <br>

                                        {{-- cms Access --}}
                                        @if($row->cms == 1)
                                        <a href="{{ route('change.status',[$row->id,'users','cms','0']) }}"
                                            id="remove" class="text-success btn"><i class="fa fa-check-square fa-lg"></i> :
                                            iHelpDesk </a>

                                        @else
                                        <a href="{{ route('change.status',[$row->id,'users','cms','1']) }}" id="give"
                                            class="text-danger btn"><i class="fa fa-times fa-lg"></i> :
                                            iHelpDesk </a>
                                        @endif

                                        <br>
                                        {{-- corona Access --}}
                                        @if($row->corona == 1)
                                        <a href="{{ route('change.status',[$row->id,'users','corona','0']) }}"
                                            id="remove" class="text-success btn"><i class="fa fa-check-square fa-lg"></i> :
                                            iTemp </a>

                                        @else
                                        <a href="{{ route('change.status',[$row->id,'users','corona','1']) }}" id="give"
                                            class="text-danger btn"><i class="fa fa-times fa-lg"></i> :
                                            iTemp </a>
                                        @endif

                                    </td>

                                    <td>
                                        {{-- block --}}
                                        @if($row->status == 1)
                                        <a href="{{ route('change.status',[$row->id,'users','status','0']) }}" id="block" class="btn text-success"><i
                                                class="fa fa-check-square fa-lg"></i>
                                            : Active</a>

                                        @else
                                        <a href="{{ route('change.status',[$row->id,'users','status','1']) }}" id="unblock" class="btn text-danger"><i
                                                class="fa fa-times fa-lg"></i> :
                                            Deactive</a>
                                        @endif
                                        <br>

                                        <a href="{{ route('user.delete', [$row->id]) }}" id="delete" class="btn text-danger" title="Delete">
                                            <i class="fa fa-trash fa-lg"></i>: Delete</a>
                                        <br>

                                        <a href="{{ route('user.edit', [$row->id]) }}" title="Edit" class="btn text-info"> <i class="fa fa-edit fa-lg"></i>:
                                            Edit</a>

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
