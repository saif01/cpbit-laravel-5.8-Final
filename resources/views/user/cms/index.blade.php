@extends('user.layout.cms-master')

@section('page-css')
<!-- Summernote Editor CSS -->
<link href="{{ asset('user/assets/coustom/summernote/summernote-lite.css')}}" rel="stylesheet">

@endsection

@section('page-js')
<!-- Summernote Editor JS -->
<script type="text/javascript" src="{{ asset('user/assets/coustom/summernote/summernote-lite.min.js')}}"></script>

    <script>
    $('textarea').summernote({
    placeholder: 'Write details about your problem......',
    height: 80,
    toolbar: [
    ['style', ['bold', 'italic', 'underline']],
    ['font', ['strikethrough']],
    ['fontsize', ['fontsize']],
    ['color', ['color']],
    ['para', ['ul', 'ol', 'paragraph']],
    ['height', ['height']]
    ],
    });
    </script>

    <script>
    jQuery(document).ready(function() {

        jQuery("#hard_com").click(function() {
            jQuery('#hardForm')[0].reset();
            jQuery("#Hardware").modal("show");
        });

        jQuery("#app_com").click(function() {
            jQuery('#appForm')[0].reset();
            jQuery("#Application").modal("show");
        });
    });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
                $('form').submit(function() {
                    setTimeout(function() {
                        disableButton();
                    }, 0);
                });

                function disableButton() {
                    $("#appSubmit").prop('disabled', true).css({"background-color": "red"});
                    $("#hardSubmit").prop('disabled', true).css({"background-color": "red"});
                }
            });
    </script>

    <script>

     $(document).ready(function() {
            $("#appCategory").on("change", function() {
                var cat_id = $(this).val();
                jQuery.ajax({
                    url: "{{ route('user.app.subcategory') }}",
                    type: "GET",
                    data: {
                        cat_id: cat_id
                    },

                    success: function(data) {
                       $('#appSubCategory').empty();
                       $.each(data, function(index, subcatObj){
                        $('#appSubCategory').append('<option value="'+subcatObj.id+'">'+subcatObj.subcategory+'</option> ');
                       });
                    }

                });
            });
        });

        $(document).ready(function() {
            $("#hardCategory").on("change", function() {
                var cat_id = $(this).val();
                jQuery.ajax({
                    url: "{{ route('user.hard.subcategory') }}",
                    type: "GET",
                    data: {
                        cat_id: cat_id
                    },

                    success: function(data) {
                       $('#hardSubCategory').empty();
                       $.each(data, function(index, subcatObj){
                        $('#hardSubCategory').append('<option value="'+subcatObj.id+'">'+subcatObj.subcategory+'</option> ');
                       });
                    }

                });
            });
        });

    </script>
@endsection

@section('content')
<!--== Page Title Area Start ==-->
<section id="page-title-area" class="section-padding overlay">
    <div class="container">
        <div class="row">
            <!-- Page Title Start -->
            <div class="col-lg-12">
                <div class="section-title  text-center">

                    <h2>Register Your Complain's</h2>
                    <span class="title-line"><i class="fas fa-chalkboard-teacher"></i></span>

                </div>
            </div>
            <!-- Page Title End -->
        </div>
    </div>
</section>
<!--== Page Title Area End ==-->

<section class="section-padding bg" >
    <div class="container">
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
        <div class="row col-md-12 text-center">

            <div class="col-md-4 zoom">

                <a href="#" id="hard_com" title="Hardware">
                    <i class="fas fa-tools hard-icon"></i>
                    <span class="h4 text-white">Hardware & Network</span>
                </a>

            </div>

            <div class="col-md-2">
                <i class="fas fa-arrows-alt-v divide-icon comtext"></i>
            </div>


            <div class="col-md-4 zoom">

                <a href="#" id="app_com" title="Application">
                    <i class="fas fa-laptop-medical app-icon"></i>
                    <span class="h4 text-white">Business Application</span>
                </a>

            </div>

        </div>



        <!-- About Fretutes Start -->
        <div class="about-feature-area ">
            <div class="row">
                <!-- Single Fretutes Start -->
                <div class="col-lg-12 comtext">
                    <div class="about-feature-item active">
                        <i class="fas fa-chalkboard-teacher comtext"></i>
                    </div>
                </div>
                <!-- Single Fretutes End -->

            </div>
        </div>
        <!-- About Fretutes End -->
    </div>
</section>


{{-- Application Model --}}
@include('user.cms.app-complain-modal')
{{-- Hardware Model --}}
@include('user.cms.hard-complain-modal')


@endsection
