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

<script>

(function(){

     $('.viewLogInLog').click(function(){
        var login = $(this).attr('login');
            $.ajax({
                url:  "{{ route('user.activity.loginlog') }}",
                type: "GET",
                data: { login: login },
                success: function(data){

                    if(data.length === 0)
                    {
                        $('#loginModalTbl').html('<h3 class="text-info">No Data Available</h1>');
                        $('#showDataModal').modal('show');
                    }
                    else
                    {
                        $("#loginModalTbl > tbody > tr").remove();
                        $.each(data, function(index, dataObj){
                            if(dataObj.logout === null ){
                                 $('#loginModalTbl').append('<tbody><tr><td>'+dataObj.device+'</td><td>'+dataObj.browser+'</td><td>'+dataObj.created_at+'</td><td>Not LogOut</td></tr></tbody>');
                            }else{
                                 $('#loginModalTbl').append('<tbody><tr><td>'+dataObj.device+'</td><td>'+dataObj.browser+'</td><td>'+dataObj.created_at+'</td><td>'+dataObj.logout+'</td></tr></tbody>');
                            }


                        });
                        $('#showDataModal').modal('show');

                   }

                },
                error: function (request, status, error) {
                console.log(request.responseText);
                }
            });
    });

})(jQuery);




</script>

@endsection
{{-- End Js Section --}}

{{-- Start Main Content --}}
@section('content')

@php
    use App\Http\Controllers\UserController;
    $Object = new UserController();

@endphp

<!-- Alternative pagination table -->
<section id="pagination">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">All User Activity
                        <a href="{{ route('user.add') }}">
                            <button class="btn gradient-nepal white big-shadow"
                                style="float: right; margin-right:3px;">Add <i class="fa fa-pencil"
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
                                    <th>Last Login</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allData as $row )
                                <tr>

                                    <td class="text-center">
                                        <a href="javascript:void(0);" class="viewUserData" id="{{ $row->id }}"
                                            title="View User Details">
                                            <img src="{{ asset($row->image) }}" alt="Image" height="100" width="100">
                                        </a>
                                    </td>

                                    <td>
                                        @if ($row->isOnline())
                                        <span class="float-right badge gradient-green-tea white"><i class="ft-disc"></i>
                                            Online</span>
                                        @else
                                        <span class="float-right badge gradient-shdow-night white"> <i
                                                class="ft-disc red"></i> Offline</span>
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
                                        <span class="text-success"><i class="fa fa-check-square fa-lg"></i> : Carpool</span>

                                        @else
                                        <span class="text-danger"><i class="fa fa-check-square fa-lg"></i> : Carpool</span>

                                        @endif
                                        <br>

                                        {{-- room Access --}}
                                        @if($row->room == 1)
                                        <span class="text-success"><i class="fa fa-check-square fa-lg"></i> : Room</span>

                                        @else
                                        <span class="text-danger"><i class="fa fa-check-square fa-lg"></i> : Room</span>
                                        @endif

                                        <br>

                                        {{-- cms Access --}}
                                        @if($row->cms == 1)
                                       <span class="text-success"><i class="fa fa-check-square fa-lg"></i> : iHelpDesk</span>

                                        @else
                                        <span class="text-danger"><i class="fa fa-check-square fa-lg"></i> : iHelpDesk</span>
                                        @endif


                                        <br>

                                        {{-- it_connect Access --}}
                                        @if($row->it_connect == 1)
                                       <span class="text-success"><i class="fa fa-check-square fa-lg"></i> : iService</span>

                                        @else
                                        <span class="text-danger"><i class="fa fa-check-square fa-lg"></i> : iService</span>
                                        @endif


                                        <br>

                                        {{-- status Access --}}
                                        @if($row->status == 1)
                                        <span class="text-success"><i class="fa fa-check-square fa-lg"></i> : Active</span>

                                        @else
                                        <span class="text-danger"><i class="fa fa-check-square fa-lg"></i> : Deactive</span>
                                        @endif

                                    </td>
                                    <td class="text-center" >
                                        @php
                                        $lastLoginData = $Object->LastLogin($row->login);
                                        @endphp

                                        @if ($lastLoginData)
                                        {{ date("F j, Y, g:i a", strtotime($lastLoginData->created_at)) }}
                                        <hr>
                                    <button login="{{ $row->login }}" class="viewLogInLog btn btn-info btn-sm">View login Log</button>

                                        @else
                                        Not Login At All
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


<!--Login Log Modal -->
<div class="modal fade" id="showDataModal" tabindex="-1" role="dialog" aria-labelledby="showDataModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showDataModalLabel">Login Log</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
           <div class="modal-body table-responsive">
                <table class="table text-center" id="loginModalTbl">
                    <thead class="thead-dark">
                        <tr>
                            <th>Device</th>
                            <th>Browser</th>
                            <th>LogIn</th>
                            <th>LogOut</th>
                        </tr>
                    </thead>

                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection
