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
        var table ="network_main_ips";
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





         (function(){


            $('#dataAddByModal').click(function() {

                $('#modalForm')[0].reset();

                $('#dataModalLabel').text('IP Add');

                $('#modalForm').prop('action', '{{ route("main.ip.add.action") }}');

                $('#dataModal').modal('show');
            });


            $(".editByModal").click(function(){

                $('#modalForm')[0].reset();

                var id = $(this).attr("id");
                var pingTypeVal = $(this).attr("dataPingType");

                $('#dataModalLabel').text('IP Edit');
                $('#id').val(id);
                $('.inputField').val( $(this).attr("dataIp") );
                $('.inputField2').val( $(this).attr("dataName") );



                if(  pingTypeVal.length == 0 ){

                    $('#startTime').attr('disabled', false);
                    $('#endTime').attr('disabled', false);

                    $('.inputField3').val( $(this).attr("dataStart") );
                    $('.inputField4').val( $(this).attr("dataEnd") );

                }else{
                    $('.pingType').val( pingTypeVal  );
                    $('#startTime').attr('disabled', 'disabled');
                    $('#endTime').attr('disabled', 'disabled');
                    $('.inputField3').val( $(this).attr("dataStart") );
                    $('.inputField4').val( $(this).attr("dataEnd") );
                }

                $('#modalForm').prop('action', '{{ route("main.ip.update.action") }}');
                $('#dataModal').modal('show');

            });



            $('#pingType').click( function(){
                var valu = $(this).val();

                if( valu != '' ){
                    $('#startTime').attr('disabled', 'disabled');
                    $('#endTime').attr('disabled', 'disabled');
                }else{
                    $('#startTime').attr('disabled', false);
                    $('#endTime').attr('disabled', false);
                }

            });

})(jQuery);

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
                <div class="card-header">
                    {{-- <h4 class="card-title">All Main Ip List
                        <button class="btn gradient-nepal white big-shadow float-right" id="dataAddByModal"
                           >Add <i class="fa fa-pencil"
                                aria-hidden="true"></i></button>

                    </h4> --}}

                    <div class="row">
                        <div class="col">
                            <h4 class="card-title">All Main Ip List</h4>
                        </div>

                        <div class="col text-center">
                        {{-- <a href="{{ route('group.ip.ping.offline.report',$group_name) }}" class="btn btn-lg gradient-green-tea white big-shadow"
                            >Ping Reports <i class="fa fa-files-o"
                                 aria-hidden="true"></i></a> --}}
                        </div>
                        <div class="col">
                        <a href="{{ route('network.main.ip.ping') }}" class="btn gradient-nepal white big-shadow float-right" >Ping All <i class="fa fa-signal"
                            aria-hidden="true"></i></a>


                                <button class="btn gradient-nepal white big-shadow float-right mr-1" id="dataAddByModal"
                                >Add <i class="fa fa-pencil"
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
                                    <th>Status</th>
                                    <th>Ping Time</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allData as $row )
                                <tr class="text-center">

                                    <td>{{ $row->ip }}</td>
                                    <td>{{ $row->name }}</td>

                                    <td>
                                           {{-- block --}}
                                           @if($row->status == 1)
                                           <a href="{{ route('change.status',[$row->id,'network_main_ips','status','0']) }}" id="block"
                                               class="btn text-success"><i class="fa fa-check-square fa-lg"></i>
                                               : Active </a>

                                           @else
                                           <a href="{{ route('change.status',[$row->id,'network_main_ips','status','1']) }}"
                                               id="unblock" class="btn text-danger"><i class="fa fa-times fa-lg"></i> :
                                               Deactive </a>
                                           @endif
                                    </td>

                                    @php
                                    $start = $row->start;
                                    $end = $row->end;
                                    if( $start == '09:00:00' && $end == '18:00:00' ){
                                        $dataPingType = 'OfficeTime';
                                    } elseif( $start == '06:00:00' && $end == '18:00:00'  ){
                                        $dataPingType = 'fullDay';
                                    }elseif( $start == '18:00:00' && $end == '06:00:00'  ){
                                        $dataPingType = 'fullNight';
                                    }elseif( $start == '01:01:01' && $end == '23:59:59'  ){
                                        $dataPingType = 'dayNight';
                                    }else{
                                        $dataPingType = '';
                                    }
                                @endphp

                                    <td>{{ date('h:i A', strtotime($row->start)) ." -- " . date('h:i A', strtotime($row->end)) }}
                                        @if ( !empty($dataPingType) )
                                       <span class="text-success"> ( {{ $dataPingType }} )</span>
                                        @endif
                                    </td>

                                    <td>

                                        <a href="{{ route('main.ip.delete',[$row->id]) }}" id="delete"
                                            class="btn gradient-ibiza-sunset white mr-1" title="Delete"> <i
                                                class="fa fa-trash"></i>: Delete</a>




                                        <button title="Edit" id="{{ $row->id }}" dataIp="{{ $row->ip }}" dataName="{{ $row->name }}" dataStart="{{ $row->start }}" dataEnd="{{ $row->end }}"  dataPingType="{{ $dataPingType }}"
                                            class="editByModal btn gradient-purple-bliss white"><i
                                                class="fa fa-edit"></i>: Edit</button>
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
                <h5 class="modal-title" id="dataModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="modalForm">
                    @csrf

                    <input type="hidden" name="id" id="id">

                    <div class="form-group">
                        <input type="text" name="ip" id="checkValue" class="inputField form-control"
                            placeholder="Type IP ( 10.20.30.40 )" required="required">
                        <span id="error_value"></span>
                    </div>

                    <div class="form-group">
                        <input type="text" name="name" class="inputField2 form-control"
                            placeholder="Type IP Address Name" required="required">
                    </div>
                    <div class="form-group">
                        <label>Select Ping Time</label>
                        <select name="pingType" id="pingType" class="pingType form-control">
                            <option value="" >Select One Ping Time</option>
                            <option value="OfficeTime">Office Time (9.00 AM - 6.00 PM)</option>
                            <option value="fullDay">Full Day (6.00 AM - 6.00 PM)</option>
                            <option value="fullNight">Full Night (6.00 PM - 6.00 AM)</option>
                            <option value="dayNight">Full Day Night (1.00 AM - 11.59 PM)</option>

                        </select>

                    </div>

                    {{-- <div class="row">
                               <div class="custom-control custom-radio">
                                <input type="radio" id="customRadio1" name="customRadio" class="custom-control-input">
                                <label class="custom-control-label" for="customRadio1">Office Time (9.00 AM - 6.00 PM)</label>
                              </div>
                              <div class="custom-control custom-radio">
                                <input type="radio" id="customRadio2" name="customRadio" class="custom-control-input">
                                <label class="custom-control-label" for="customRadio2">Full Day (6.00 AM - )</label>
                              </div>
                              <div class="custom-control custom-radio">
                                <input type="radio" id="customRadio3" name="customRadio" class="custom-control-input">
                                <label class="custom-control-label" for="customRadio3">Full Day Night</label>
                              </div>
                    </div> --}}


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="startTime">Start Ping:</label>
                                <input type="time" id="startTime" name="start" class="inputField3 form-control" >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="endTime">End Ping:</label>
                                <input type="time" id="endTime" name="end" class="inputField4 form-control" >
                            </div>
                        </div>
                    </div>



            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" id="btnSubmit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>

@endsection
