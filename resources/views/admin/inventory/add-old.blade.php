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
            var table ="inv_old_products";
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
                <h4 class="card-title" id="bordered-layout-colored-controls">Old Product Add</h4>

            </div>
            <div class="card-body">

                <form action="{{ route('inv.add.old.action') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-4">
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

                        <div class="col-md-4">
                            <label>Subcategory</label>
                            <select class="form-control" name="sub_id" id="hardSubCategory" required="required">
                            </select>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Operation Name</label>
                                <select class="form-control" name="operation" required="required">
                                    <option value="" disabled selected>Select Operation Name</option>
                                    @foreach ($operationData as $operation)
                                    <option value="{{ $operation->operation }}">{{ $operation->operation }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>B.U. Location</label>
                                <select class="form-control" name="bu_location" required="required">
                                    <option value="" disabled selected>Select B.U. Location Name</option>
                                    @foreach ($buLocationData as $bulocation)
                                    <option value="{{ $bulocation->bu_location }}">{{ $bulocation->bu_location }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                                <div class="form-group">
                                    <label>Department</label>
                                    <select class="form-control" name="department" required="required">
                                        <option value="" disabled selected>Select Department Name</option>
                                        @foreach ($deptData as $dept)
                                        <option value="{{ $dept->dept_name }}">{{ $dept->dept_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Product Type</label>
                                <select class="form-control" name="type" required="required">
                                    <option value="Running">Running Product</option>
                                    <option value="Damaged">Damaged Product</option>
                                </select>
                            </div>
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
                                <input type="text" name="serial" class="form-control" id="checkValue"
                                    placeholder="Enter Product Serial Number" required="required">
                                <span id="error_value"></span>
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
