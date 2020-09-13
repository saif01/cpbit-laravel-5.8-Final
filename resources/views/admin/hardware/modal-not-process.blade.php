<div class="modal fade text-left" id="notProcessModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel17">Complain Actions</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                    <tr>
                        <th>Complain No:</th>
                        <td id="app_id">{{ $compData->id }}</td>
                        <th>Category:</th>
                        <td id="software">{{ $compData->category }}</td>
                        <th>Subcategory:</th>
                        <td id="module">{{ $compData->subcategory }}</td>
                    </tr>

                </table>

                <form id="notProcessForm" action="{{ route('hard.complain.action.notprocess',[$compData->id,$compData->user_id]) }}" method="post" enctype="multipart/form-data" >
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-md-3 label-control" for="userinput5">Process: </label>
                                <div class="col-md-9">
                                   <select id="allProcess" class="form-control" name="process">
                                        <option value="Not Process">Not Process</option>
                                        <option value="Processing">Processing</option>
                                        <option value="Closed">Closed</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-md-3 label-control" for="userinput5">File's: </label>
                                <div class="col-md-9">
                                    <input type="file" name="document">
                                    <span class="text-danger">* (Max. 3 MB)</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="deliveryStatus" style="display:none">
                        <div class="row">
                            <label class="col-sm-3 control-label text-danger">Deliverable:</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="custom-control custom-radio d-inline-block ml-1">
                                        <input type="radio" id="d_req_st" value="Deliverable" name="delivery" class="custom-control-input">
                                        <label class="custom-control-label" for="d_req_st">Yes</label>
                                    </div>
                                    <div class="custom-control custom-radio d-inline-block ml-2">
                                        <input type="radio" id="activeN" value="" name="delivery" class="custom-control-input">
                                        <label class="custom-control-label" for="activeN">No</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="Warranty_st" style="display: none;">
                        <div class="row">
                            <label class="col-sm-3 control-label text-danger">Warranty Status:</label>
                            <div class="col-sm-9">

                                <div class="input-group">
                                    <div class="custom-control custom-radio d-inline-block ml-1">
                                        <input type="radio" id="w_req_st" name="warranty" value="s_w" class="custom-control-input">
                                        <label class="custom-control-label" for="w_req_st">Yes</label>
                                    </div>
                                    <div class="custom-control custom-radio d-inline-block ml-2">
                                        <input type="radio" id="activeN2" name="warranty" value="" class="custom-control-input">
                                        <label class="custom-control-label" for="activeN2">No</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($compData->tools != "")
                    <div id="send_tools" style="display: none;">
                        <div class="row p-3">
                                <label class="control-label">Tools: </label>
                                <div class="input-group">

                                    <div class="custom-control custom-checkbox mr-1">
                                        <input type="checkbox" class="custom-control-input" id="Mouse" name="tools[]" value="Mouse">
                                        <label class="custom-control-label" for="Mouse">Mouse</label>
                                    </div>

                                    <div class="custom-control custom-checkbox mr-1">
                                        <input type="checkbox" class="custom-control-input" id="Cord" name="tools[]" value="Power Cord">
                                        <label class="custom-control-label" for="Cord">Power Cord</label>
                                    </div>

                                    <div class="custom-control custom-checkbox mr-1">
                                        <input type="checkbox" class="custom-control-input" id="Adeptar" name="tools[]" value="AC Adeptar">
                                        <label class="custom-control-label" for="Adeptar">Adaptar</label>
                                    </div>

                                    <div class="custom-control custom-checkbox mr-1">
                                        <input type="checkbox" class="custom-control-input" id="VGA" name="tools[]" value="VGA Cord">
                                        <label class="custom-control-label" for="VGA">VGA Cord</label>
                                    </div>

                                    <div class="custom-control custom-checkbox mr-1">
                                        <input type="checkbox" class="custom-control-input" id="USB" name="tools[]" value="USB Cord">
                                        <label class="custom-control-label" for="USB">USB Cord</label>
                                    </div>

                                    <div class="custom-control custom-checkbox mr-1">
                                        <input type="checkbox" class="custom-control-input" id="Toner" name="tools[]" value="Toner/Cartridge">
                                        <label class=" custom-control-label" for="Toner">Tonar/Cartridge</label>
                                    </div>
                                    <input type="text" name="tools[]" placeholder="Others" value="" class="form-control form-control-sm">

                                </div>
                        </div>
                    </div>
                    @endif


                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Remarks</label>
                                <textarea class="form-control" name="remarks" required="required"></textarea>
                            </div>
                        </div>
                    </div>



                    <div class="modal-footer">
                        <button type="submit" id="btnSubmit" name="submit"
                            class="btn btn-block gradient-nepal white">Apply Changes</button>
                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
