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
                    <h4 class="card-title">All User Activity</h4>

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
                                @foreach ($smsUser as $row )
                                <tr>
                                    <td class="text-center">
                                        <a href="javascript:void(0);" class="viewUserData" id="{{ $row->id }}"
                                            title="View User Details">
                                            <img src="{{ asset($row->image) }}" alt="Image" height="100" width="100">
                                        </a>
                                    </td>

                                    <td>
                                       
                                        <b>Login : </b>{{ $row->login }}<br>
                                        <b>Name : </b>{{ $row->name }}
                                        <div class="dropdown-divider"></div>
                                        <b>Phone : </b>{{ $row->contact }}<br>
                                        <b>Email : </b>{{ $row->email }}<br>
                                    </td>

                                    <td class="text-center">
                                        @if ( !empty($row->access) )
                                            @php
                                                 $smsCode = $row->access;
                                                 $arrayUserAccessCodeData = explode(",", $smsCode);
                                            @endphp

                                           @foreach ($arrayUserAccessCodeData as $userAccessCodeId)
                                                @foreach ($smsOperationData as $operationRow)
                                                    @if ($operationRow->id == $userAccessCodeId)
                                                    <span class="bg-success badge m-1"> {{ $operationRow->name }} </span>
                                                    @endif 
                                                @endforeach
                                           @endforeach

                                        @else
                                            <span class="bg-danger badge"> No Access </span>   
                                        @endif

                                    </td>

                                    <td>
                                        <a href="{{ route('sms.user.access.super',$row->id) }}"
                                            class="btn gradient-nepal white big-shadow">
                                                Give Access <i class="ft-upload" ></i>
                                        </a>

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
