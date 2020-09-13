@extends('admin.layout.hard-master')

@section('page-css')
<!-- Summernote Editor CSS -->
<link href="{{ asset('admin/app-assets/custom/summernote/summernote-lite.css')}}" rel="stylesheet" />
<!--  for Mini Preview -->
<link href="{{ asset('admin/app-assets/custom/mini_preview/jquery.minipreview.css')}}" rel="stylesheet"
    type="text/css" />

@endsection

@section('page-js')
<!-- Summernote JS -->
<script src="{{ asset('admin/app-assets/custom/summernote/summernote-lite.js') }}"></script>
<!-- Modal Show-->
<script src="{{ asset('admin/app-assets/js/components-modal.min.js') }}" type="text/javascript"></script>
<!-- for Mini preview js -->
<script src="{{ asset('admin/app-assets/custom/mini_preview/jquery.minipreview.js')}}"></script>
{{-- User Details Modal --}}
@include('admin.layout.commonModals.userDetailsFunction')

<script>
    (function($) {

        $('.previewByModal').click(function() {
            var source = $(this).attr('source');
            $('#imgPreviewByModal').attr('src', source);
            $('#previewModal').modal('show');

        });


        $('textarea').summernote({
            placeholder: 'Write Detail about this issue.',
            tabsize: 5,
            height: 100,
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['font', ['strikethrough']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']]
            ],
        });


        $(document).ready(function() {
            $('form').submit(function() {
                setTimeout(function() {
                    disableButton();
                }, 0);
            });

            function disableButton() {
                $('#btnSubmit').attr('disabled', 'disabled').css({
                    "background-color": "red"
                });
            }
        });

        $('#preview a').miniPreview({
            width: 250,
            height: 150,
            scale: .25,
            prefetch: 'none'
        });


        $("#allProcess").on("change", function () {

                if (jQuery(this).val() == 'Closed') {

                    jQuery("#send_tools").css('display', 'none');
                    jQuery("#deliveryStatus").css('display', 'block');
                    jQuery("#Warranty_st").css('display', 'none');
                    jQuery("#d_req_st").attr('required', true);
                    jQuery("#w_req_st").attr('required', false);
                }

                else if (jQuery(this).val() == 'Not Process') {

                    jQuery("#send_tools").css('display', 'none');
                    jQuery("#deliveryStatus").css('display', 'none');
                    jQuery("#Warranty_st").css('display', 'none');
                    jQuery("#w_req_st").attr('required', false);
                    jQuery("#d_req_st").attr('required', false);

                }
                else if (jQuery(this).val() == 'Processing') {

                    jQuery("#send_tools").css('display', 'block').attr('required', true);
                    jQuery("#deliveryStatus").css('display', 'none');
                    jQuery("#Warranty_st").css('display', 'block');
                    jQuery("#w_req_st").attr('required', true);
                    jQuery("#d_req_st").attr('required', false);

                }

                return false;

        });



        $('.notProcessAction').click(function() {
            $('#notProcessForm')[0].reset();
            $('#notProcessModal').modal('show');
        });

         $('.warrantyProcessingAction').click(function() {
            $('#warrantyProcessForm')[0].reset();
            $('#warrantyProcessModal').modal('show');
        });

         $('.processingAction').click(function() {
            $('#processingForm')[0].reset();
            $('#ProcessingModal').modal('show');
        });

        $('#processSelect').on('change', function(){

            if( $(this).val() == 'Closed' ){
                $("#processDeliveryStatus").css('display', 'block');
                $("#d_req_st_pro").attr('required', true);
            }else{
                $("#processDeliveryStatus").css('display', 'none');
                $("#d_req_st_pro").attr('required', false);
            }

        });

         $('.delieveryAction').click(function() {
            $('#processingForm')[0].reset();
            $('#DelieveryModal').modal('show');
        });


    })(jQuery);
</script>
@endsection

{{-- Start Main Content --}}
@section('content')
<!-- Alternative pagination table -->
<section id="pagination">
    <div class="row">
        <div class="col-12">
            <div class="card">
                @if ($errors->any())
                <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
                    <p class="text-dark"><strong>Whoops!</strong> There were some problems with your input.</p>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                <div class="card-header">
                    <h4 class="card-title">Hardware Complain <b>Actions</b> </h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">

                            @php
                            // returns a file extension
                            $file1 = $compData->documents;
                            if(!empty($file1)){
                            $info1 = pathinfo($file1);
                            $ExtFile1 = $info1["extension"];
                            }

                            @endphp

                            {{-- Start Complain Data Show  --}}
                            <table class="table mb-0">
                                <tr>
                                    <th>Complain No :</th>
                                    <td>{{ $compData->id }}</td>

                                    <th>Category : </th>
                                    <td>{{ $compData->category }}</td>

                                    <th>Subcategory : </th>
                                    <td>{{ $compData->subcategory }}</td>

                                </tr>

                                <tr>
                                    <th>User Name : </th>
                                    <td>

                                        <button class="viewUserData btn btn-info btn-sm" id="{{ $compData->user_id }}" >{{ $compData->name }}</button>
                                    </td>

                                    <th>Department : </th>
                                    <td> {{ $compData->department }} </td>

                                    <th>Register : </th>
                                    <td> {{ date("j-F-Y, g:i A", strtotime($compData->created_at)) }} </td>

                                </tr>
                                <tr>
                                    <th>Warranty : </th>
                                    <td>
                                        @if ($compData->process == 'Not Process')
                                            <span class="bg-info badge">Not Process</span>
                                        @elseif ($compData->warranty == 's_w')
                                            <span class="bg-warning badge">Send To Warranty</span>
                                        @elseif ($compData->warranty == 'b_w')
                                            <span class="bg-success badge">Back To Warranty</span>
                                        @elseif ($compData->warranty == 'a_s_w')
                                            <span class="bg-info badge">Again Send To Warranty</span>
                                        @else
                                            <span class="bg-secondary badge">No Warranty</span>
                                        @endif

                                    </td>

                                    <th>Delivery : </th>
                                    <td>
                                        @if ($compData->process == 'Not Process')
                                        <span class="bg-info badge">Not Process</span>
                                        @elseif ($compData->delivery == 'Deliverable')
                                        <span class="bg-warning badge">Deliverable</span>
                                        @elseif ($compData->delivery == 'Delivered')
                                        <span class="bg-success badge">Delivered</span>
                                        @else
                                        <span class="bg-secondary badge">Not Deliverable</span>
                                        @endif
                                    </td>

                                    <th>Update : </th>
                                    <td> {{ date("j-F-Y, g:i A", strtotime($compData->updated_at)) }} </td>

                                </tr>
                                <tr>
                                    <th>File : </th>
                                    @if ($file1)
                                    <!-- File One  -->
                                    @if ($file1)
                                    <td @if ($ExtFile1=="jpg" || $ExtFile1=="png" || $ExtFile1=="JPG" || $ExtFile1=="PNG" ) id='preview' @endif>

                                        {{-- Preview File  --}}
                                        @if ($ExtFile1 == "jpg" || $ExtFile1 == "png" || $ExtFile1 == "JPG" || $ExtFile1
                                        == "PNG")

                                        <button type="button" class="previewByModal btn gradient-politics white btn-sm mr-1 mb-0"
                                            source="{{ asset($file1) }}"> <i class="fa fa-search"></i> Preview
                                        </button>
                                        @endif
                                        <a href="{{ asset($file1) }}" class="btn btn-danger btn-sm mb-0" download><i class="fa fa-download"></i>
                                            Download</a>
                                    </td>
                                    @endif


                                    @else
                                    <td><span class="bg-danger badge">No Document's Send</span></td>
                                    @endif

                                    <th>Final Status :</th>
                                    <td> <span class="badge badge-pill gradient-green-tea white h5 mb-0 pl-2 pr-2">{{ $compData->process }}</span></td>

                                    <th>Computer : </th>
                                    <td> {{ $compData->computer_name }}</td>
                                </tr>
                            </table>


                            <table class="table mb-0">
                               <tr>
                                    <th>Details : </th>
                                    <td> {!! $compData->details !!}</td>
                                </tr>
                            </table>
                            {{-- Start Complain Data Show  --}}

                            {{-- Start Complain Remarks  --}}
                            @foreach ($remarksData as $remark)
                            <table class="table mb-0" style="background:#F9DECD;">
                                <tr>
                                    <th>Process : </th>
                                    <td>{{ $remark->process }}</td>
                                    <th>Document : </th>
                                    <td>
                                        @if (!empty($remark->document))
                                        <a href="{{ asset($remark->document) }}"
                                            class="btn gradient-purple-bliss white btn-sm mb-0" download><i
                                                class="fa fa-download"></i> Download</a>
                                        @else
                                        No Document's Send
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>ActionBy : </th>
                                    <td>{{ $remark->action_by }}</td>
                                    <th>R. Register : </th>
                                    <td>{{ date("j-F-Y, g:i A", strtotime($remark->created_at)) }}</td>
                                </tr>
                            </table>

                            <table class="table" style="background:#bbf1c9;">

                                <tr>
                                    <th>Remarks : </th>
                                    <td>{!! $remark->remarks !!}</td>
                                </tr>
                            </table>
                            @endforeach
                            {{-- End Complain Remarks  --}}

                            {{-- Start Delivery Section --}}

                            @if( !empty($deliveryData) )

                            <table class="table mb-0" style="background:#F9DECD;">
                                <tr>
                                    <th>Received By : </th>
                                    <td>{{ $deliveryData->name }} ( {{ $deliveryData->contact }} )</td>
                                    <th>Document : </th>
                                    <td>
                                        @if (!empty($deliveryData->document))
                                        <a href="{{ asset($deliveryData->document) }}"
                                            class="btn gradient-purple-bliss white btn-sm mb-0" download><i
                                                class="fa fa-download"></i> Download</a>
                                        @else
                                        No Document's Send
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Delivered By : </th>
                                    <td>
                                        {{ $deliveryData->action_by  }}

                                    <th>R. Register : </th>
                                    <td>{{ date("j-F-Y, g:i A", strtotime($deliveryData->created_at)) }}</td>
                                </tr>
                            </table>

                            <table class="table" style="background:#bbf1c9;">

                                <tr>
                                    <th>Remarks : </th>
                                    <td>{!! $deliveryData->remarks !!}</td>
                                </tr>
                            </table>

                            @endif


                            <!-- Take Action Part -->

                            <table class="table">
                                <tr>
                                    <th>
                                        Actions
                                    </th>
                                    <td class="text-center">
                                        @if ($compData->process == 'Not Process')
                                            <button class="notProcessAction btn gradient-plum white btn-block btn-rounded"><i class="fa fa-external-link"></i> Take Action</button>

                                        {{--  Send To Warranty  --}}
                                        @elseif($compData->process == 'Processing' && ($compData->warranty == 's_w' || $compData->warranty == 'a_s_w') )
                                        <button class="warrantyProcessingAction btn gradient-plum white btn-block btn-rounded"><i class="fa fa-external-link"></i> Take Action</button>

                                        {{--  Back From Warranty  --}}
                                        @elseif($compData->process == 'Processing' && $compData->warranty == 'b_w' )
                                        <button class="processingAction btn gradient-plum white btn-block btn-rounded"><i
                                                class="fa fa-external-link"></i> Take Action</button>

                                        @elseif($compData->process == 'Processing' && $compData->warranty == '')
                                        <button class="processingAction btn gradient-plum white btn-block btn-rounded"><i class="fa fa-external-link"></i> Take
                                            Action</button>
                                        @elseif( $compData->process == 'Closed' && $compData->delivery == 'Deliverable')
                                        <button class="delieveryAction btn gradient-plum white btn-block btn-rounded"><i class="fa fa-external-link"></i> Take
                                            Delievery </button>

                                        @elseif($compData->delivery == 'Delivered' && $compData->process == 'Closed')
                                            <span class="btn-block white gradient-plum p-1">Delivered</span>
                                        @elseif($compData->process == 'Closed' && $compData->delivery == '')
                                            <span class="btn-block white gradient-plum p-1">Closed</span>
                                        @else
                                            <span class="btn-block white gradient-plum p-1">No Action</span>
                                        @endif

                                    </td>
                                </tr>
                            </table>

                            <!-- End Take Action Part -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--/ Alternative pagination table -->

{{-- User Details Modal --}}
@include('admin.layout.commonModals.userDetails')

{{-- Image Preview Modal  --}}
@include('admin.layout.commonModals.previewModal')
{{-- Not Process Action Modal  --}}
@include('admin.hardware.modal-not-process')

{{-- Processing Action Modal  --}}
@include('admin.hardware.modal-processing')

{{-- Processing Action Modal  --}}
@include('admin.hardware.modal-warranty-process')

{{-- Delievery Action Modal  --}}
@include('admin.hardware.modal-delievery')


@endsection
