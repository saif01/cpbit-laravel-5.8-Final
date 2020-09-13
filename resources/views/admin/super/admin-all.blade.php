@extends('admin.layout.master')
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
                    <h4 class="card-title">All Admin Information
                        <a href="{{ route('admin.add') }}">
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
                                <tr class="text-center" >
                                    <th>Image</th>
                                    <th>Details</th>
                                    <th>Admin Status</th>
                                    <th>Authorization</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allData as $row )
                                <tr>
                                    <td class="text-center">
                                        <a href="javascript:void(0);" class="viewAdminData" id="{{ $row->id }}" title="ViewAdmin Details"><img src="{{ asset($row->image) }}" alt="Image" height="100" width="100">
                                        </a></td>

                                    </td>

                                    <td>
                                        <b>Login : </b>{{ $row->login }}<br>
                                        <b>Name : </b>{{ $row->name }}
                                            <div class="dropdown-divider"></div>
                                        <b>Phone : </b>{{ $row->contact }}<br>
                                        <b>Email : </b>{{ $row->email }}<br>
                                    </td>
                                    <td>

                                        {{-- Super Admin Access --}}
                                        @if($row->super == 1)
                                        <a href="{{ route('change.status',[$row->id,'admins','super','0']) }}" id="remove" class=" text-success"><i
                                                class="fa fa-check-square fa-lg"></i> : Super Admin</a>

                                        @else
                                        <a href="{{ route('change.status',[$row->id,'admins','super','1']) }}" id="give" class=" text-danger"><i
                                                class="fa fa-times fa-lg"></i> : Super Admin</a>
                                        @endif
                                        <br>
                                        {{-- Admin Create Access --}}
                                        @if($row->admin_cr == 1)
                                        <a href="{{ route('change.status',[$row->id,'admins','admin_cr','0']) }}" id="remove" class=" text-success"><i
                                                class="fa fa-check-square fa-lg"></i> :  Admin Create</a>

                                        @else
                                        <a href="{{ route('change.status',[$row->id,'admins','admin_cr','1']) }}" id="give" class=" text-danger"><i
                                                class="fa fa-times fa-lg"></i> : Admin Create</a>
                                        @endif
                                        <br>

                                        {{--User Create Access --}}
                                            @if($row->user_cr == 1)
                                            <a href="{{ route('change.status',[$row->id,'admins','user_cr','0']) }}" id="remove" class=" text-success"><i
                                                    class="fa fa-check-square fa-lg"></i> : User Create</a>

                                            @else
                                            <a href="{{ route('change.status',[$row->id,'admins','user_cr','1']) }}" id="give" class=" text-danger"><i
                                                    class="fa fa-times fa-lg"></i> : User Create</a>
                                            @endif

                                    </td>

                                    <td>

                                        {{-- carpool Access --}}
                                        @if($row->car == 1)
                                        <a href="{{ route('change.status',[$row->id,'admins','car','0']) }}"
                                            id="remove" class="text-success"><i class="fa fa-check-square fa-lg"></i> : Carpool </a>

                                        @else
                                        <a href="{{ route('change.status',[$row->id,'admins','car','1']) }}"
                                            id="give" class="text-danger"><i class="fa fa-times fa-lg"></i> :
                                            Carpool </a>
                                        @endif
                                        <br>

                                       {{-- room Access --}}
                                        @if($row->room == 1)
                                        <a href="{{ route('change.status',[$row->id,'admins','room','0']) }}" id="remove" class="text-success"><i
                                                class="fa fa-check-square fa-lg"></i> : Room </a>

                                        @else
                                        <a href="{{ route('change.status',[$row->id,'admins','room','1']) }}" id="give" class="text-danger"><i
                                                class="fa fa-times fa-lg"></i> :
                                            Room </a>
                                        @endif
                                        <br>

                                       {{-- Hardware Access --}}
                                        @if($row->hard == 1)
                                        <a href="{{ route('change.status',[$row->id,'admins','hard','0']) }}" id="remove" class="text-success"><i
                                                class="fa fa-check-square fa-lg"></i> : Hardware </a>

                                        @else
                                        <a href="{{ route('change.status',[$row->id,'admins','hard','1']) }}" id="give" class="text-danger"><i
                                                class="fa fa-times fa-lg"></i> :
                                            Hardware </a>
                                        @endif
                                        <br>

                                        {{-- Application Access --}}
                                        @if($row->app == 1)
                                        <a href="{{ route('change.status',[$row->id,'admins','app','0']) }}" id="remove" class="text-success"><i
                                                class="fa fa-check-square fa-lg"></i> : Application </a>

                                        @else
                                        <a href="{{ route('change.status',[$row->id,'admins','app','1']) }}" id="give" class="text-danger"><i
                                                class="fa fa-times fa-lg"></i> :
                                            Application </a>
                                        @endif
                                        <br>

                                        {{-- Inventory Access --}}
                                        @if($row->inventory == 1)
                                        <a href="{{ route('change.status',[$row->id,'admins','inventory','0']) }}" id="remove" class="text-success"><i
                                                class="fa fa-check-square fa-lg"></i> : Inventory </a>

                                        @else
                                        <a href="{{ route('change.status',[$row->id,'admins','inventory','1']) }}" id="give" class="text-danger"><i
                                                class="fa fa-times fa-lg"></i> :
                                            Inventory </a>
                                        @endif

                                        <br>
                                        {{-- Network Access --}}
                                        @if($row->network == 1)
                                        <a href="{{ route('change.status',[$row->id,'admins','network','0']) }}" id="remove" class="text-success"><i
                                                class="fa fa-check-square fa-lg"></i> : Network </a>

                                        @else
                                        <a href="{{ route('change.status',[$row->id,'admins','network','1']) }}" id="give" class="text-danger"><i
                                                class="fa fa-times fa-lg"></i> :
                                            Network </a>
                                        @endif

                                        <br>

                                        {{-- it_connect Access --}}
                                        @if($row->it_connect == 1)
                                        <a href="{{ route('change.status',[$row->id,'admins','it_connect','0']) }}" id="remove" class="text-success"><i
                                                class="fa fa-check-square fa-lg"></i> : iService </a>

                                        @else
                                        <a href="{{ route('change.status',[$row->id,'admins','it_connect','1']) }}" id="give" class="text-danger"><i
                                                class="fa fa-times fa-lg"></i> :
                                                iService </a>
                                        @endif
                                        <br>

                                        {{-- Corona Access --}}
                                        @if($row->corona == 1)
                                        <a href="{{ route('change.status',[$row->id,'admins','corona','0']) }}" id="remove" class="text-success"><i
                                                class="fa fa-check-square fa-lg"></i> : CoronaDesk </a>

                                        @else
                                        <a href="{{ route('change.status',[$row->id,'admins','corona','1']) }}" id="give" class="text-danger"><i
                                                class="fa fa-times fa-lg"></i> :
                                                CoronaDesk </a>
                                        @endif

                                    </td>

                                    <td>
                                        {{-- Admin block --}}
                                        @if($row->status == 1)
                                        <a href="{{ route('change.status',[$row->id,'admins','status','0']) }}" id="block" class="text-success btn"><i
                                                class="fa fa-check-square fa-lg"></i> : Active</a>

                                        @else
                                        <a href="{{ route('change.status',[$row->id,'admins','status','1']) }}" id="unblock" class="text-danger btn"><i
                                                class="fa fa-times fa-lg"></i> : Deactive</a>
                                        @endif
                                        <br>
                                        <a href="{{ route('admin.delete', [$row->id]) }}" id="delete" class="text-danger btn" title="Delete">
                                            <i class="fa fa-trash fa-lg"></i>: Delete</a>
                                        <br>

                                        <a href="{{ route('admin.edit', [$row->id]) }}" title="Edit" class="text-info btn"> <i class="fa fa-edit fa-lg"></i>:
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

{{-- Admin Details Modal --}}
@include('admin.layout.commonModals.adminDetails')

@endsection
