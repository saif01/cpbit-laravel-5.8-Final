@extends('admin.layout.master')

@section('page-js')
<!-- Modal Show-->
<script src="{{ asset('admin/app-assets/js/components-modal.min.js') }}" type="text/javascript"></script>
{{-- User Details Modal --}}
@include('admin.layout.commonModals.userDetailsFunction')

<script>
$(function() {
$('form').submit(function() {
setTimeout(function() {
disableButton();
}, 0);
});
function disableButton() {
$("#btnSubmit").prop('disabled', true);
}
});
</script>

@endsection

@section('content')
@if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
 <div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title" id="bordered-layout-colored-controls">User SMS Generate Access</h4>

            </div>
            <div class="card-body">

                <div>
                    <table class="table table-striped table-bordered alt-pagination">
                        <thead>
                            <tr class="text-center">
                                <th>Image</th>
                                <th>User Details</th>
                               
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">
                                    <a href="javascript:void(0);" class="viewUserData" id="{{ $smsUser->id }}"
                                        title="View User Details">
                                        <img src="{{ asset($smsUser->image) }}" alt="Image" height="100" width="100">
                                    </a>
                                </td>
                                <td>
                                    <b>Login : </b>{{ $smsUser->login }}<br>
                                    <b>Name : </b>{{ $smsUser->name }}
                                    <div class="dropdown-divider"></div>
                                    <b>Phone : </b>{{ $smsUser->contact }}<br>
                                    <b>Email : </b>{{ $smsUser->email }}<br>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            <form action="{{ route('sms.user.super.update') }}" method="post" >
                    @csrf

            <input type="hidden" name="user_id" value="{{ $smsUser->id }}">

                        <hr>
                    
                        <div class="custom-control custom-checkbox form-check-inline">
                            @foreach ($smsOperationData as $item)

                            <span class="mr-4">
                                <input type="checkbox" name="access[]" value="{{ $item->id }}" class="custom-control-input" id="{{ $item->id }}"

                                @if( !empty($smsUser->access ) )
                                    @php
                                        $smsCode = $smsUser->access;
                                        $arrayUserAccessCodeData = explode(",", $smsCode);
                                    @endphp

                                    @foreach ($arrayUserAccessCodeData as $smsId)
                                        @if ($item->id == $smsId)
                                        checked
                                        @endif 
                                    @endforeach
                                @endif
                                >
                                <label class="custom-control-label" for="{{ $item->id }}">{{ $item->name }} </label>
                            </span>

                            @endforeach
                           
                        </div>
                    



                    <div class="form-actions right">
                        <button type="button" class="btn btn-raised btn-warning mr-1" onClick="history.go(-1); return false;"><i
                                class="ft-x"></i> Cancel</button>
                        <button id="btnSubmit" type="submit" name="submit" class="btn btn-raised btn-primary"><i
                                class="fa fa-check-square-o"></i> Update</button>
                    </div>


                </form>


            </div>
        </div>
    </div>
</div>

{{-- User Details Modal --}}
@include('admin.layout.commonModals.userDetails')

@endsection
