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
        var table ="network_sub_ips";
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

            $('#dataModalLabel').text('IP Add');

            $('#modalForm').prop('action', '{{ route("sub.ip.add.action") }}');

            $('#dataModal').modal('show');
        });


         $(".editByModal").click(function(){

            var id = $(this).attr("id");

            $('#dataModalLabel').text('IP Edit');
            $('#id').val(id);
            $('.inputField').val( $(this).attr("dataIp") );
            $('.inputField2').val( $(this).attr("dataName") );
            $('.inputField3').val( $(this).attr("groupName") );
            $('#modalForm').prop('action', '{{ route("sub.ip.update.action") }}');
            $('#dataModal').modal('show');

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
                <div class="card-header">
                    <h4 class="card-title">All Sub Ip List
                        <button class="btn gradient-nepal white big-shadow float-right" id="dataAddByModal"
                           >Add <i class="fa fa-pencil"
                                aria-hidden="true"></i></button>

                    </h4>

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
                                             : Active </a>

                                         @else
                                         <a href="{{ route('change.status',[$row->id,'network_sub_ips','status','1']) }}"
                                             id="unblock" class="btn text-danger"><i class="fa fa-times fa-lg"></i> :
                                             Deactive </a>
                                         @endif

                                    </td>

                                    <td>

                                        <a href="{{ route('sub.ip.delete',[$row->id]) }}" id="delete"
                                            class="btn gradient-ibiza-sunset white mr-1" title="Delete"> <i
                                                class="fa fa-trash"></i>: Delete</a>


                                        <button title="Edit" id="{{ $row->id }}" dataIp="{{ $row->ip }}" dataName="{{ $row->name }}" groupName="{{ $row->group_name }}"
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
                        <select name="group_name" class="inputField3 form-control" required="required">
                            <option value="" >Select Group Name</option>
                            @foreach ($groupData as $group)
                            <option value="{{ $group->name }}">{{ $group->name }}</option>
                            @endforeach
                        </select>
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
