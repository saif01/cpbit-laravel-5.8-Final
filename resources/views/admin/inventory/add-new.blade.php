@extends('admin.layout.inv-master')

@section('page-css')
    <!-- Summernote Editor CSS -->
    <link href="{{ asset('admin/app-assets/custom/summernote/summernote-lite.css')}}" rel="stylesheet" />
@endsection

@section('page-js')
<!-- Summernote JS -->
<script src="{{ asset('admin/app-assets/custom/summernote/summernote-lite.js') }}"></script>

{{-- Deat Piker --}}
@include('admin.layout.datePiker.datePiker')


<script>
    (function ($) {


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


          $('textarea').summernote({
            placeholder: 'Write Detail about this Product.',
            tabsize: 5,
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


            $(document).ready(function(){
            $('#checkValue').blur(function(){
            var error_Msg = '';
            var table ="inv_new_products";
            var field ="serial";
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



            $("#activeY").change(function(){
                if( $(this).is(":checked") ){
                    $("#monOrYerInputW").css('display', 'block');
                    $("#numberInputW").css('display', 'block');
                    $(".inputNumberFiled").attr('required', true);
                }
            });

             $("#activeN").change(function(){
                if( $(this).is(":checked") ){
                    $("#monOrYerInputW").css('display', 'none');
                    $("#numberInputW").css('display', 'none');
                    $(".inputNumberFiled").attr('required', false);
                }
            });


        })(jQuery);

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
                <h4 class="card-title" id="bordered-layout-colored-controls">New Product Add</h4>

            </div>
            <div class="card-body">

                <form action="{{ route('inv.add.new.action') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                               <label>Category</label>
                                <select class="form-control" name="cat_id" id="hardCategory" required="required">
                                    <option value="" disabled selected>Select Category Name</option>
                                    @foreach ($hardCategoryData as $hardCategory)
                                    <option value="{{ $hardCategory->id }}">{{ $hardCategory->category }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <div class="col-md-6">
                           <label>Subcategory</label>
                        <select class="form-control" name="sub_id" id="hardSubCategory" required="required">
                        </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Product Name / Model</label>
                                <input type="text" class="form-control" name="name" {{ old('name') }}
                                    placeholder="Enter Name Or Model" required="required">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Serial Number</label>
                                <input type="text" name="serial" class="form-control" id="checkValue" placeholder="Enter Product Serial Number"
                                    required="required">
                                <span id="error_value"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                           <div class="form-group">
                                <label>Documents</label> <span class="text-danger">(Max. 3 MB)</span>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input " name="document" id="inputGroupFile01"
                                        aria-describedby="inputGroupFileAddon01"
                                        onchange="document.getElementById('preview1').src = window.URL.createObjectURL(this.files[0])"
                                        >
                                    <label class="custom-file-label" for="inputGroupFile01">Choose
                                        file</label>
                                </div>

                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Purchase Date</label>
                                <div class='input-group'>
                                    <input type='text' class="form-control" id="datepicker" name="purchase" placeholder="Enter Purchase Date"
                                        required="required" />
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <span class="fa fa-calendar-o"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">


                        <div class="col-md-12">
                           <div class="form-group">
                            <label>Remarks</label>
                            <textarea class="form-control" name="remarks" required="required"></textarea>
                            </div>
                        </div>
                    </div>


                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Warranty Status</label>
                                <div class="input-group">
                                    <div class="custom-control custom-radio d-inline-block ml-2">
                                        <input type="radio" id="activeY" value="1" name="warr_st" class="custom-control-input" required>
                                        <label class="custom-control-label" for="activeY">Yes</label>
                                    </div>
                                    <div class="custom-control custom-radio d-inline-block ml-2">
                                        <input type="radio" id="activeN" value="0" name="warr_st" class="custom-control-input">
                                        <label class="custom-control-label" for="activeN">No</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4" id="monOrYerInputW" style="display:none" >
                            <div class="form-group">
                                <label>Select Month / Year</label>
                                <select class="form-control" name="month_type">
                                    <option value="1">Month</option>
                                    <option value="12">Year</option>
                                </select>
                            </div>

                        </div>

                        <div class="col-md-4" id="numberInputW" style="display:none" >
                            <div class="form-group">
                                <label>Number Of Month / Year</label>
                                <input type="number" name="month_data" class="inputNumberFiled form-control">
                            </div>
                        </div>

                    </div>




                    <div class="form-actions right">
                        <button type="button" class="btn btn-raised btn-warning mr-1"
                            onClick="history.go(-1); return false;"><i class="ft-x"></i> Cancel</button>
                        <button id="btnSubmit" type="submit" name="submit" class="btn btn-raised btn-primary"><i class="fa fa-check-square-o"></i> Save</button>
                    </div>


                </form>


            </div>
        </div>
    </div>
</div>


@endsection
