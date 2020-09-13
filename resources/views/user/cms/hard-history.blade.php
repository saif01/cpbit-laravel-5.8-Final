@extends('user.layout.cms-master')

@section('page-css')
<!--*********** Simple Data table CDN ***********************-->
<link rel="stylesheet" type="text/css" href="{{ asset('user/assets/dataTable/data_table.css') }}">
@endsection

@section('page-js')
<script type="text/javascript" src="{{ asset('user/assets/dataTable/tbl.js') }}"></script>
<script type="text/javascript" src="{{ asset('user/assets/dataTable/boots.js') }}"></script>
{{-- Cancel Sweet alert --}}
@include('user.layout.sw-cancel-alert')

<script type="text/javascript">
(function(){

    $(document).ready(function() {
        $('#example').DataTable({
            "stateSave": true,
           "order": []
        });
    } );


    $('.viewRemarks').click(function(){
        var id = $(this).attr('id');
        var delivery = $(this).attr('delivery');
        var path = "{{ asset('/') }}";

            $.ajax({
                url:  "{{ route('user.hard.complain.remarks') }}",
                type: "GET",
                data: { id: id, delivery: delivery },
                success: function(data){

                    if(data.length === 0)
                    {
                        $('#remarksModalTbl').html('<h3 class="text-info">No Data Available</h1>');
                        $('#dataShowModal').modal('show');
                    }
                    else
                    {
                        $("#remarksModalTbl > tbody > tr").remove();

                        $.each(data.remarks, function(index, dataObj){

                             if(dataObj.document)
                                {
                                    $('#remarksModalTbl').append('<tbody><tr><td>'+dataObj.process+'</td><td>'+dataObj.remarks+'</td><td>'+dataObj.updated_at+'</td><td><a href="'+path+dataObj.document+'" class="btn btn-primary btn-sm" download><i class="fa fa-download"></i> Download</a></td></tr></tbody>');
                                }
                            else
                                {
                                    $('#remarksModalTbl').append('<tbody><tr><td>'+dataObj.process+'</td><td>'+dataObj.remarks+'</td><td>'+dataObj.updated_at+'</td><td>No File</td></tr></tbody>');
                                }

                        });

                        if(data.delivery == 'NoData' ){
                            $('#delieveryModalTbl').css('display', 'none');
                        }else{
                           $('#delieveryModalTbl').css('display', 'block');
                           $('#deliName').text(data.delivery.name);
                           $('#deliContact').text(data.delivery.contact);
                           $('#deliRemarks').html(data.delivery.remarks);
                        }


                        $('#dataShowModal').modal('show');

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

@section('content')

<!--== Page Title Area Start ==-->
<section id="page-title-area" class="section-padding overlay">
    <div class="container">
        <div class="row">
            <!-- Page Title Start -->
            <div class="col-lg-12">
                <div class="section-title text-center">
                    <h2>{{ session()->get('user.name') }}'s Hardware Complain History</h2>
                    <span class="title-line"><i class="fas fa-chalkboard-teacher"></i></span>
                </div>
            </div>
            <!-- Page Title End -->
        </div>
    </div>
</section>
<!--== Page Title Area End ==-->

<div class="container mt-3">


    <table id="example" class="table table-striped table-bordered table-dark text-center" style="width:100%">

        <thead style="background-color:#A0522D">
            <tr>
                <th>Number</th>
                <th>Category</th>
                <th>Subcategory</th>
                <th>Process/Warranty/Delievery</th>
                <th>Register</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($allData as $row)
            <tr>
                <td> <span class="badge badge-pill bg-success white" style="font-size: 20px;">{{ $row->id }}</span>
                </td>
                <td>{{ $row->category }}</td>
                <td>{{ $row->subcategory }}</td>
                <td>
                    @if ($row->status == 1)

                        @if ($row->process == 'Not Process')
                            <span class="bg-primary badge">Not Process</span>
                        @else
                            {{--  Process Status  --}}
                            @if($row->process == 'Processing')
                            <span class="bg-warning badge mr-1">Processing</span>
                            @elseif($row->process == 'Closed')
                            <span class="bg-success badge mr-1">Closed</span>
                            @elseif($row->process == 'Damaged')
                            <span class="bg-danger badge mr-1">Damaged</span>
                            @endif

                            {{--  Warranty Status  --}}
                            @if ($row->warranty == 's_w')
                            <span class="bg-warning badge mr-1">Send To Warranty</span>
                            @elseif ($row->warranty == 'b_w')
                            <span class="bg-success badge mr-1">Back To Warranty</span>
                            @elseif ($row->warranty == 'a_s_w')
                            <span class="bg-info badge mr-1">Again Send To Warranty</span>
                            @else
                            <span class="bg-secondary badge mr-1">No Warranty</span>
                            @endif
                            {{--  Delivery Status  --}}
                            @if ($row->process == 'Closed')
                                @if ($row->delivery == 'Deliverable')
                                <span class="bg-warning badge mr-1">Deliverable</span>
                                @elseif ($row->delivery == 'Delivered')
                                <span class="bg-success badge mr-1">Delivered</span>
                                @else
                                <span class="bg-secondary badge">Not Deliverable</span>
                                @endif
                            @endif

                        @endif

                    @else
                            <span class="bg-danger badge">Canceled</span>
                    @endif

                </td>

                <td>{{ date("F j, Y, g:i a", strtotime($row->created_at)) }}</td>
                <td>
                    @if ($row->status == 1)
                        @if ($row->process == 'Not Process')
                        <a href="{{ route('user.hard.complain.cancel',$row->id ) }}" title="Complain Cancel" id="cancelBooking"
                            class="btn btn-danger mr-1 btn-sm">Cancel</a>
                        @endif
                        <button id="{{ $row->id }}" delivery="{{ $row->delivery }}" class="btn btn-success viewRemarks btn-sm">Details</button>

                    @else
                            <span class="bg-danger badge h4">Complain Canceled</span>
                    @endif



                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>


<!-- Modal -->
<div class="modal fade" id="dataShowModal" tabindex="-1" role="dialog" aria-labelledby="dataShowModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dataShowModalLabel">Your Complain Remarks</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body table-responsive">
                <table class="table text-center mb-0" id="remarksModalTbl" >
                    <thead class="thead-dark">
                        <tr>
                            <th>Process</th>
                            <th>Remarks</th>
                            <th>Action</th>
                            <th>Document</th>
                        </tr>
                    </thead>

                </table>
                <div id="delieveryModalTbl">
                    <table class="table text-center table-responsive">
                        <tr>
                            <th>Receive By:</th>
                            <td id="deliName">No Data</td>
                            <th>Contact:</th>
                            <td id="deliContact">No Data</td>
                            <th>Remarks:</th>
                            <td id="deliRemarks">No data</td>
                        </tr>
                    </table>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection
