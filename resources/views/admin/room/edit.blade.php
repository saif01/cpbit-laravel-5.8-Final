@extends('admin.layout.room-master')

@section('page-js')
<script>
    (function ($) {

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
                <h4 class="card-title" id="bordered-layout-colored-controls">Room Edit</h4>
            </div>
            <div class="card-body">

                <form action="{{ route('room.update.action',$data->id) }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Room Name</label>
                                <input type="text" name="name" class="form-control" id="checkValue"
                                    placeholder="Enter Car Number" value="{{ $data->name }}" readonly>
                                <span id="error_value"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Room Capacity</label>
                                <input type="number" class="form-control" name="capacity" placeholder="Enter Car name" value="{{ $data->capacity }}"
                                    required="required">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Room Type</label>
                                <select class="form-control" name="type">
                                    <option value="Meeting" @if ($data->type == 'Meeting')
                                        selected @endif >Meeting</option>
                                    <option value="Residance" @if ($data->type == 'Residance')
                                        selected @endif >Residance</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label>Active</label>
                           <div class="input-group">
                                <div class="custom-control custom-radio d-inline-block ml-1">
                                    <input type="radio" id="activeY" value="1" name="status" class="custom-control-input" @if ($data->status == 1)
                                    checked
                                    @endif >
                                    <label class="custom-control-label" for="activeY">Yes</label>
                                </div>
                                <div class="custom-control custom-radio d-inline-block ml-2">
                                    <input type="radio" id="activeN" value="0" name="status" class="custom-control-input" @if ($data->status == 0)
                                    checked
                                    @endif >
                                    <label class="custom-control-label" for="activeN">No</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label>Room Projector</label>
                            <div class="input-group">
                                <div class="custom-control custom-radio d-inline-block ml-1">
                                    <input type="radio" id="temporaryN" value="1" name="projector"
                                        class="custom-control-input" @if ($data->projector == 1)
                                    checked
                                    @endif>
                                    <label class="custom-control-label" for="temporaryN">Yes</label>
                                </div>
                                <div class="custom-control custom-radio d-inline-block ml-2">
                                    <input type="radio" id="temporaryY" value="0" name="projector"
                                        class="custom-control-input" @if ($data->projector == 0)
                                    checked
                                    @endif>
                                    <label class="custom-control-label" for="temporaryY">No</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label class="label-control" for="timesheetinput7">Room Remarks </label>
                            <textarea id="timesheetinput7" class="form-control" placeholder="Enter Room Remarks"
                                name="remarks">{{ $data->remarks }}</textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label class="col-md-3 label-control">1st Image</label>
                                <div class="col-md-9">
                                    <input name="image" type="file" class="file"
                                        onchange="document.getElementById('preview11').src = window.URL.createObjectURL(this.files[0])"
                                        />
                                    <p style="color:red;">Resolution 1280*800 pixels</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label class="col-md-3 label-control">2nd Image</label>
                                <div class="col-md-9">
                                    <input name="image2" type="file" class="file"
                                        onchange="document.getElementById('preview22').src = window.URL.createObjectURL(this.files[0])"
                                         />
                                    <p style="color:red;">Resolution 1280*800 pixels</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label class="col-md-3 label-control">3rd Image</label>

                                <div class="col-md-9">
                                    <input name="image3" type="file" class="file"
                                        onchange="document.getElementById('preview33').src = window.URL.createObjectURL(this.files[0])"
                                         />
                                    <p style="color:red;">Resolution 1280*800 pixels</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                      <div class="col-md-4 carImgPreview">
                            <img id="preview11" src="{{ asset($data->image) }}" alt="Image Not Selected" class="rounded mx-auto d-block"
                                width="200" height="100" />
                        </div>
                        <div class="col-md-4 carImgPreview">
                            <img id="preview22" src="{{ asset($data->image2) }}" alt="Image Not Selected" class="rounded mx-auto d-block"
                                width="200" height="100" />
                        </div>
                        <div class="col-md-4 carImgPreview">
                            <img id="preview33" src="{{ asset($data->image3) }}" alt="Image Not Selected" class="rounded mx-auto d-block"
                                width="200" height="100" />
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
