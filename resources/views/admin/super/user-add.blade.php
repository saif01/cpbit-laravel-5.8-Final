@extends('admin.layout.master')

@section('page-js')
<script>
    (function ($) {

            $(document).ready(function(){
            $('#checkValue').blur(function(){
            var error_Msg = '';
            var table ="admins";
            var field ="login";
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
                <h4 class="card-title" id="bordered-layout-colored-controls">User Add</h4>

            </div>
            <div class="card-body">

                <form action="{{ route('user.add.action') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>LogIn ID</label>
                                <input type="text" name="login" class="form-control" id="checkValue"
                                    placeholder="Enter User login Id" required="required">
                                <span id="error_value"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Password</label>
                                <input type="text" class="form-control" name="password" placeholder="AD Server Password"
                                    disabled="disabled">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>User Name</label>
                                <input type="text" class="form-control" name="name" placeholder="Enter User Full Name"
                                    required="required">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>User Contact</label>
                                <input type="number" class="form-control" name="contact"
                                    placeholder="Enter User Contact Number" required="required">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                       <div class="col-md-6">
                            <div class="form-group">
                                <label>User Location (BU Location)</label>
                                <select class="form-control" name="bu_location" required="required">
                                    <option value="" disabled selected>Select User Location Name</option>
                                    @foreach($buLocation as $location)
                                    <option value="{{ $location->bu_location }}">{{ $location->bu_location }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Department</label>
                                <select class="form-control" name="department" required="required">
                                    <option value="" disabled selected>Select Department Name</option>
                                    @foreach($deptData as $item)
                                    <option value="{{ $item->dept_name }}">{{ $item->dept_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>User Email</label>
                                <input type="email" class="form-control" name="email"
                                    placeholder="Enter User E-mail Address" required="required">
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label>B.U. Email</label>
                                <input type="text" class="form-control" name="bu_email" placeholder="Enter User E-mail Address"
                                    required="required">
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>User Office ID</label>
                                <input type="text" class="form-control" name="office_id"
                                    placeholder="Enter User Office ID" required="required">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label>Active</label>
                            <div class="input-group">
                                <div class="custom-control custom-radio d-inline-block ml-1">
                                    <input type="radio" id="activeY" value="1" name="status"
                                        class="custom-control-input" checked>
                                    <label class="custom-control-label" for="activeY">Yes</label>
                                </div>
                                <div class="custom-control custom-radio d-inline-block ml-2">
                                    <input type="radio" id="activeN" value="0" name="status"
                                        class="custom-control-input">
                                    <label class="custom-control-label" for="activeN">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="control-label">User Access</label>
                            <div class="input-group">

                                <div class="custom-control custom-checkbox mr-1">
                                    <input type="checkbox" class="custom-control-input" id="car" name="car" value="1">
                                    <label class="custom-control-label" for="car">Carpool</label>
                                </div>

                                <div class="custom-control custom-checkbox mr-1">
                                    <input type="checkbox" class="custom-control-input" id="room" name="room" value="1">
                                    <label class="custom-control-label" for="room">Room</label>
                                </div>

                                <div class="custom-control custom-checkbox mr-1">
                                    <input type="checkbox" class="custom-control-input" id="it_connect" name="it_connect" value="1">
                                    <label class="custom-control-label" for="it_connect">iService</label>
                                </div>

                                <div class="custom-control custom-checkbox mr-1">
                                    <input type="checkbox" class="custom-control-input" id="cms" name="cms"
                                        value="1">
                                    <label class="custom-control-label" for="cms">iHelpDesk</label>
                                </div>

                                <div class="custom-control custom-checkbox mr-1">
                                    <input type="checkbox" class="custom-control-input" id="corona" name="corona"
                                        value="1">
                                    <label class="custom-control-label" for="corona">iTemp</label>
                                </div>

                            </div>
                        </div>

                    </div>



                    <div class="row">
                        <div class="col-md-6">
                            <label>User Image</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input " name="image" id="inputGroupFile01"
                                        aria-describedby="inputGroupFileAddon01"
                                        onchange="document.getElementById('preview1').src = window.URL.createObjectURL(this.files[0])"
                                        required="required">
                                    <label class="custom-file-label" for="inputGroupFile01">Choose
                                        file</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <img id="preview1" alt="Image Not Selected" class="rounded mx-auto d-block"
                                    width="90px" height="100px" />
                            </div>
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
