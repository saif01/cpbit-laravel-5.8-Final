@extends('admin.layout.network-master')

@section('page-css')
{{-- Data table css --}}
<link rel="stylesheet" type="text/css"
    href="{{ asset('admin/app-assets/vendors/css/tables/datatable/datatables.min.css') }}">

@endsection
{{-- Page Js --}}
@section('page-js')

<!-- Modal Show-->
<script src="{{ asset('admin/app-assets/js/components-modal.min.js') }}" type="text/javascript"></script>

{{-- Data table js --}}
<script src="{{ asset('admin/app-assets/vendors/js/datatable/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('admin/app-assets/js/data-tables/datatable-basic.js') }}" type="text/javascript"></script>
<!-- Custom Sweet alert -->
<script src="{{ asset('admin/app-assets/custom/sweetAlert2Function.js') }}" type="text/javascript"></script>

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


        $(document).ready(function(){
        $('#checkValue').blur(function(){
        var error_Msg = '';
        var table ="network_ips";
        var field ="ip";
        var value = $('#checkValue').val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
                url:"{{ route('value_available.check') }}",
                method:"POST",
                data:{ _token:_token, value:value, table:table, field:field },
                success:function(result)
                {
                    if(result == 'unique')
                    {
                        $('#error_value').html('<label class="text-success">Value Available</label>');
                        $('#value').removeClass('has-error');
                        $('#btnSubmit').attr('disabled', false).css({"background-color": ""});
                    }
                    else
                    {
                        $('#error_value').html('<label class="text-danger">Value not Available</label>');
                        $('#value').addClass('has-error');
                        $('#btnSubmit').attr('disabled', 'disabled').css({"background-color": "red"});
                    }
                }
            })
        });
        });



        $('#dataAddByModal').click(function() {

            $('#modalForm')[0].reset();
            $('#dataModal').modal('show');
        });


         $(".editByModal").click(function(){

            var id = $(this).attr("id");

            $('#dataModalLabel').text('IP Edit');
            $('#id').val(id);
            $('.inputField').val( $(this).attr("dataIp") );
            $('.inputField2').val( $(this).attr("dataName") );
            $('#modalForm').prop('action', '{{ route("main.ip.update.action") }}');
            $('#dataModal').modal('show');

         });


         $('.viewPingData').click(function(){
        var pingIp = $(this).attr('pingIp');


            $.ajax({
                url:  "{{ route('single.ip.report') }}",
                type: "GET",
                data: { pingIp: pingIp },
                success: function(data){

                    if(data.length === 0)
                    {
                        $('#remarksModalTbl').html('<h3 class="text-info">No Data Available</h1>');
                        $('#dataShowModal').modal('show');
                    }
                    else
                    {
                        $("#remarksModalTbl > tbody > tr").remove();
                        $.each(data, function(index, dataObj){


                            $('#remarksModalTbl').append('<tbody><tr><td>'+dataObj.ip+'</td><td>'+dataObj.name+'</td><td>'+dataObj.latency+' ms.</td><td>'+dataObj.status+'</td><td>'+dataObj.created_at+'</td></tr></tbody>');


                        });
                        $('#dataShowModal').modal('show');

                   }

                },
                error: function (request, status, error) {
                console.log(request.responseText);
                }
            });
    });

</script>


@endsection
{{-- End Js Section --}}

{{-- Start Main Content --}}
@section('content')
<!-- Alternative pagination table -->
<section id="pagination">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header ">
                    <div class="row">
                        <div class="col">
                            <h4 class="card-title"><span class="text-success" >{{ $group_name }}</span> Group Ip List

                            </h4>
                        </div>

                        <div class="col text-center">
                        <a href="{{ route('group.ip.ping.offline.report',$group_name) }}" class="btn btn-lg gradient-green-tea white big-shadow"
                            >Ping Reports <i class="fa fa-files-o"
                                 aria-hidden="true"></i></a>
                        </div>
                        <div class="col">
                            <button class="btn gradient-nepal white big-shadow float-right" id="dataAddByModal"
                               >Ping All <i class="fa fa-signal"
                                    aria-hidden="true"></i></button>
                        </div>
                    </div>

                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard table-responsive">
                        <table class="table table-striped table-bordered alt-pagination">
                            <thead>
                                <tr class="text-center">
                                    <th>IP</th>
                                    <th>Name</th>
                                    <th>Group</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allData as $row )
                                <tr class="text-center">

                                    <td>{{ $row->ip }}</td>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->group_name }}</td>
                                    <td>
                                         {{-- block --}}
                                         @if($row->status == 1)
                                         <a href="{{ route('change.status',[$row->id,'network_sub_ips','status','0']) }}" id="block"
                                             class="btn text-success"><i class="fa fa-check-square fa-lg"></i>
                                             : Active</a>

                                         @else
                                         <a href="{{ route('change.status',[$row->id,'network_sub_ips','status','1']) }}"
                                             id="unblock" class="btn text-danger"><i class="fa fa-times fa-lg"></i> :
                                             Deactive</a>
                                         @endif

                                    </td>

                                    <td>

                                        {{-- <a href="{{ route('main.ip.delete',[$row->id]) }}" id="delete"
                                            class="btn gradient-ibiza-sunset white mr-1" title="Delete"> <i
                                                class="fa fa-trash"></i>: Delete</a> --}}


                                        {{-- <button title="Edit" id="{{ $row->id }}" dataIp="{{ $row->ip }}" dataName="{{ $row->name }}"
                                            class="editByModal btn gradient-purple-bliss white mr-1"><i
                                                class="fa fa-edit"></i>: Edit</button> --}}

                                        <button title="Edit" pingIp="{{ $row->ip }}"
                                                    class="viewPingData btn gradient-purple-bliss white mr-1"><i
                                                        class="fa fa-search-plus"></i>: Report</button>

                                         <a href="{{ route('single.ip.ping',[$row->ip]) }}"
                                                            class="btn gradient-ibiza-sunset white" title="Delete"> <i
                                                                class="fa fa-signal"></i>: Ping</a>
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


<!-- Modal -->
<div class="modal fade" id="dataModal" tabindex="-1" role="dialog" aria-labelledby="dataModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dataModalLabel"><span class="text-success" >{{ $group_name }}</span> Group All Active Ip Ping</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form action="{{ route('group.ip.ping', [$group_name]) }}" method="POST" id="modalForm">
                    @csrf

                    <div class="form-group">
                        <select name='pingType' class="form-control" required="required" >
                            <option value="1" > 1 Time Ping</option>
                            <option value="2" > 2 Time Ping</option>
                            <option value="3" > 3 Time Ping</option>
                            <option value="4" > 4 Time Ping</option>
                        </select>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" id="btnSubmit" class="btn btn-primary">Start Ping</button>
            </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="dataShowModal" tabindex="-1" role="dialog" aria-labelledby="dataShowModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dataShowModalLabel">IP Ping Reports</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body table-responsive">
                <table class="table text-center" id="remarksModalTbl" >
                    <thead class="thead-dark">
                        <tr>
                            <th>IP</th>
                            <th>Name</th>
                            <th>Latency</th>
                            <th>Status</th>
                            <th>Time</th>
                        </tr>
                    </thead>

                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection
