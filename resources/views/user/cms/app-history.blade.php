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
        var path = "{{ asset('/') }}";

            $.ajax({
                url:  "{{ route('user.app.complain.remarks') }}",
                type: "GET",
                data: { id: id },
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

                             if(dataObj.document)
                                {
                                    $('#remarksModalTbl').append('<tbody><tr><td>'+dataObj.process+'</td><td>'+dataObj.remarks+'</td><td>'+dataObj.updated_at+'</td><td><a href="'+path+dataObj.document+'" class="btn btn-primary btn-sm" download><i class="fa fa-download"></i> Download</a></td></tr></tbody>');
                                }
                            else
                                {
                                    $('#remarksModalTbl').append('<tbody><tr><td>'+dataObj.process+'</td><td>'+dataObj.remarks+'</td><td>'+dataObj.updated_at+'</td><td>No File</td></tr></tbody>');
                                }

                        });
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
                    <h2>{{ session()->get('user.name') }}'s Application Complain History</h2>
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

        <thead style="background-color:#1E90FF">
            <tr>
                <th>Number</th>
                <th>Soft Name</th>
                <th>Soft Module</th>
                <th>Process</th>
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
                        @elseif($row->process == 'Processing')
                            <span class="bg-warning badge">Processing</span>
                        @elseif($row->process == 'Closed')
                            <span class="bg-success badge">Closed</span>
                        @endif
                    @else
                            <span class="bg-danger badge">Canceled</span>
                    @endif

                </td>

                <td>{{ date("F j, Y, g:i a", strtotime($row->created_at)) }}</td>
                <td>
                    @if ($row->status == 1)
                        @if ($row->process == 'Not Process')
                        <a href="{{ route('user.app.complain.cancel',$row->id ) }}" title="Complain Cancel" id="cancelBooking"
                            class="btn btn-danger mr-1 btn-sm">Cancel</a>
                        @endif
                        <button id="{{ $row->id }}" class="btn btn-success viewRemarks btn-sm">Details</button>

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
                <table class="table text-center" id="remarksModalTbl" >
                    <thead class="thead-dark">
                        <tr>
                            <th>Process</th>
                            <th>Remarks</th>
                            <th>Action</th>
                            <th>Document</th>
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
