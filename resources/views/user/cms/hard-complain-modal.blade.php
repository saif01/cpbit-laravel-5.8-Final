<!-- Hardware Model Modal  -->
<div id="Hardware" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- Main Content show -->
            <div class="modal-body text-success">
                <form action="{{ route('user.hard.complain.submit') }}" id="hardForm" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row col-md-12">
                        <div class="col-md-6">

                            <div class="form-group required">
                                <label>Category</label>
                                <select class="form-control " name="cat_id" id="hardCategory" required="required">
                                    <option value="" disabled selected>Select Category Name</option>
                                    @foreach ($hardCategoryData as $hardCategory)
                                    <option value="{{ $hardCategory->id }}">{{ $hardCategory->category }}</option>
                                    @endforeach
                                </select>
                            </div>


                        </div>
                        <div class="col-md-6">

                            <div class="form-group required">
                                <label>Subcategory</label>
                                <select class="form-control" name="sub_id" id="hardSubCategory" required="required">
                                </select>
                            </div>

                        </div>
                    </div>



                    <div class="form-group">
                        <p class="text-muted text-center">Which Accessories are you send in Hardware, Please Select</p>
                        <input type="checkbox" name="tools[]" value="Mouse"> Mouse
                        <input type="checkbox" name="tools[]" value="keybord"> keyboard
                        <input type="checkbox" name="tools[]" value="Power Cord"> Power Cord
                        <input type="checkbox" name="tools[]" value="AC Adeptar"> Adapter
                        <input type="checkbox" name="tools[]" value="VGA Cord"> VGA Cord
                        <input type="checkbox" name="tools[]" value="Usb Cord"> USB Cord
                        <input type="checkbox" name="tools[]" value="Toner/Cartridge"> Toner/Cartridge
                        <input type="text" name="tools[]" placeholder="Others product that you provide mention here" value="" class="form-control form-control-sm">

                    </div>


                    <div class="form-group required">
                        <label>Complain Detail's </label>
                        <textarea class="form-control" name="details" required="required"></textarea>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Document's (Photos or PDF)</label>
                                <input type="file" name="documents" class="form-control">
                                <span class="text-danger">* (Max. 3 MB)</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group required">
                                <label>Your Computer Name</label>
                                <input type="text" name="computer_name" class="form-control" required="required">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer mt-1">
                        <div class="col-md-12 row">
                            <div class="col-md-11">
                               <button type="submit" id="hardSubmit" name="submit" class="btn btn-success btn-block bold" >Submit</button>
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>
