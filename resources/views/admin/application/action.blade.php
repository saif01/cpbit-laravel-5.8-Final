@extends('admin.layout.app-master')

@section('page-css')
<!-- Summernote Editor CSS -->
<link href="{{ asset('admin/app-assets/custom/summernote/summernote-lite.css')}}" rel="stylesheet" />
<!--  for Mini Preview -->
<link href="{{ asset('admin/app-assets/custom/mini_preview/jquery.minipreview.css')}}" rel="stylesheet" type="text/css" />
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


        $('.frist_action').click(function() {
            $('#actionModal').modal('show');
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
                {{-- <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
                    <p class="text-dark"><strong>Whoops!</strong> There were some problems with your input.</p>
                    <ul>
                        <li>There were some problems with your input</li>
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div> --}}

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
                    <h4 class="card-title">Application Complain <b>Actions</b> </h4>
                </div>


                <div class="card-content">
                    <div class="card-body">
                        <div class="row">

                            @php
                            // returns a file extension
                            $file1 = $compData->doc1;
                            if(!empty($file1)){
                            $info1 = pathinfo($file1);
                            $ExtFile1 = $info1["extension"];
                            }

                            $file2 = $compData->doc2;
                            if(!empty($file2)){
                            $info2 = pathinfo($file2);
                            $ExtFile2 = $info2["extension"];
                            }

                            $file3 = $compData->doc3;
                            if(!empty($file3)){
                            $info3 = pathinfo($file3);
                            $ExtFile3 = $info3["extension"];
                            }

                            $file4 = $compData->doc4;
                            if(!empty($file4)){
                            $info4 = pathinfo($file4);
                            $ExtFile4 = $info4["extension"];
                            }

                            @endphp

                            {{-- Start Complain Data Show  --}}
                            <table class="table mb-0">
                                <tr>
                                    <th>Complain No:</th>
                                    <td>{{ $compData->id }}</td>

                                    <th>Software: </th>
                                    <td> {{ $compData->category }}</td>

                                    <th>Module: </th>
                                    <td>{{ $compData->subcategory }}</td>

                                </tr>

                                <tr>
                                    <th>User Name:</th>
                                    <td>
                                        <a href="javascript:void(0);" class="viewUserData" id="{{ $compData->user_id }}" title="View User Details">{{ $compData->name }}
                                        </a>
                                    </td>

                                    <th>Department:</th>
                                    <td> {{ $compData->department }} </td>

                                    <th>Register:</th>
                                    <td> {{ date("j-F-Y, g:i A", strtotime($compData->created_at)) }} </td>

                                </tr>
                            </table>

                            <table class="table mb-0">
                                <tr>
                                    @if ($file1 || $file2 || $file3 || $file4 )
                                    <th>File:</th>
                                    <!-- File One  -->
                                    @if ($file1)
                                    <td @if ($ExtFile1=="jpg" || $ExtFile1=="png" || $ExtFile1=="JPG" || $ExtFile1=="PNG" ) id='preview' @endif>

                                        {{-- Preview File  --}}
                                        @if ($ExtFile1 == "jpg" || $ExtFile1 == "png" || $ExtFile1 == "JPG" || $ExtFile1 == "PNG")

                                        <button type="button" class="previewByModal btn gradient-politics white btn-sm mr-1 mb-0" source="{{ asset($file1) }}"> <i class="fa fa-search"></i> Preview 1</button>
                                        @endif
                                        <a href="{{ asset($file1) }}" class="btn btn-danger btn-sm mb-0" download><i class="fa fa-download"></i>
                                            Download 1</a>
                                    </td>
                                    @endif

                                    @if ($file2)
                                    <td @if ($ExtFile2=="jpg" || $ExtFile2=="png" || $ExtFile2=="JPG" || $ExtFile2=="PNG" ) id='preview' @endif>

                                        {{-- Preview File  --}}
                                        @if ($ExtFile2 == "jpg" || $ExtFile2 == "png" || $ExtFile2 == "JPG" || $ExtFile2 == "PNG")

                                        <button type="button" class="previewByModal btn gradient-politics white btn-sm mr-1 mb-0" source="{{ asset($file2) }}">
                                            <i class="fa fa-search"></i> Preview 2</button>
                                        @endif
                                        <a href="{{ asset($file2) }}" class="btn btn-danger btn-sm mb-0" download><i class="fa fa-download"></i>
                                            Download 2</a>
                                    </td>
                                    @endif

                                    @if ($file3)
                                    <td @if ($ExtFile3=="jpg" || $ExtFile3=="png" || $ExtFile3=="JPG" || $ExtFile3=="PNG" ) id='preview' @endif>

                                        {{-- Preview File  --}}
                                        @if ($ExtFile3 == "jpg" || $ExtFile3 == "png" || $ExtFile3 == "JPG" || $ExtFile3 == "PNG")

                                        <button type="button" class="previewByModal btn gradient-politics white btn-sm mr-1 mb-0" source="{{ asset($file3) }}">
                                            <i class="fa fa-search"></i> Preview 3</button>
                                        @endif
                                        <a href="{{ asset($file3) }}" class="btn btn-danger btn-sm mb-0" download><i class="fa fa-download"></i>
                                            Download 3</a>
                                    </td>
                                    @endif

                                    @if ($file4)
                                    <td @if ($ExtFile4=="jpg" || $ExtFile4=="png" || $ExtFile4=="JPG" || $ExtFile4=="PNG" ) id='preview' @endif>

                                        {{-- Preview File  --}}
                                        @if ($ExtFile4 == "jpg" || $ExtFile4 == "png" || $ExtFile4 == "JPG" || $ExtFile4 == "PNG")

                                        <button type="button" class="previewByModal btn gradient-politics white btn-sm mr-1 mb-0" source="{{ asset($file4) }}">
                                            <i class="fa fa-search"></i> Preview 4</button>
                                        @endif
                                        <a href="{{ asset($file4) }}" class="btn btn-danger btn-sm mb-0" download><i class="fa fa-download"></i>
                                            Download 4</a>
                                    </td>
                                    @endif
                                    @else
                                    <td class="text-danger text-center">No Document's Send</td>
                                    @endif
                                </tr>
                            </table>


                            <table class="table mb-0">
                                <tr>
                                    <th>Final Status:</th>
                                    <td><span class="badge badge-pill gradient-green-tea white h4 mb-0 pl-2 pr-2">{{ $compData->process }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Details: </th>
                                    <td> {!! $compData->details !!}</td>
                                </tr>
                            </table>
                            {{-- Start Complain Data Show  --}}

                            {{-- Start Complain Remarks  --}}
                            @foreach ($remarksData as $remark)
                            <table class="table mb-0" style="background:#F9DECD;">
                                <tr>
                                    <th>Process:</th>
                                    <td>{{ $remark->process }}</td>
                                    <th>Document:</th>
                                    <td>
                                        @if (!empty($remark->document))
                                        <a href="{{ asset($remark->document) }}" class="btn gradient-purple-bliss white btn-sm mb-0" download><i class="fa fa-download"></i>
                                            Download</a>
                                        @else
                                        No Document's Send
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>ActionBy:</th>
                                    <td>{{ $remark->action_by }}</td>
                                    <th>R. Register:</th>
                                    <td>{{ date("j-F-Y, g:i A", strtotime($remark->created_at)) }}</td>
                                </tr>
                            </table>


                            <table class="table" style="background:#bbf1c9;">
                                <tr>
                                    <th>Remarks:</th>
                                    <td>{!! $remark->remarks !!}</td>
                                </tr>
                            </table>
                            @endforeach
                            {{-- End Complain Remarks  --}}

                            <!-- Take Action Part -->
                            @if ($compData->process != 'Closed')
                            <table class="table">
                                <tr>
                                    <th>
                                        Actions
                                    </th>
                                    <td class="text-center">
                                        <button class="frist_action btn gradient-plum white btn-block btn-rounded"><i class="fa fa-external-link"></i> Take Action</button>
                                    </td>
                                </tr>
                            </table>
                            @endif
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
{{--  Action Modal  --}}
@include('admin.application.action-modal')


@endsection
