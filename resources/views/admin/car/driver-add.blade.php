@extends('admin.layout.car-master')

@section('page-js')
<script>
    (function ($) {

            $(document).ready(function(){
            $('#checkValue').blur(function(){
            var error_Msg = '';
            var table ="drivers";
            var field ="name";
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
                <h4 class="card-title" id="bordered-layout-colored-controls">Driver Add</h4>

            </div>
            <div class="card-body">

                <form action="{{ route('driver.add.action') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 label-control">Name</label>
                                        <div class="col-md-9">
                                          <input type="text" name="name" class="form-control" id="checkValue" placeholder="Enter Driver Name"
                                            required="required">
                                          <span id="error_value"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 label-control">For Car</label>
                                        <div class="col-md-9">
                                            <select name="car_id" class="form-control" required="required">
                                                <option value="">Select Car For Driver </option>
                                                @foreach ($carData as $car)
                                                    <option value="{{ $car->id }}">{{ $car->name .' || '. $car->number }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 label-control">Contract</label>
                                        <div class="col-md-9">
                                            <input type="number" name="contact" class="form-control"
                                                placeholder="Enter Driver Phone Number" required="required" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 label-control">NID</label>
                                        <div class="col-md-9">
                                            <input type="text" name="nid" class="form-control" placeholder="Enter Driver NID"
                                                required="required" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 label-control">License</label>
                                        <div class="col-md-9">
                                            <input type="text" name="license" class="form-control" placeholder="Enter Driver License"
                                                required="required" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 label-control">Image:</label>
                                        <div class="col-md-9">
                                            <input name="image" type="file" class="form-control-file"
                                                onchange="document.getElementById('preview').src = window.URL.createObjectURL(this.files[0])"
                                                required="required">
                                            <p style="color:red;">Resolution 300*250 pixels</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-2">
                            <img id="preview" alt="Image Not Selected" width="160" height="200" />
                        </div>

                    </div>


                    <div class="form-actions right">
                        <button type="button" class="btn btn-raised btn-warning mr-1"
                            onClick="history.go(-1); return false;"><i class="ft-x"></i> Cancel</button>
                        <button id="btnSubmit" type="submit" name="submit" class="btn btn-raised btn-primary"><i
                                class="fa fa-check-square-o"></i> Save</button>
                    </div>


                </form>


            </div>
        </div>
    </div>
</div>


@endsection
