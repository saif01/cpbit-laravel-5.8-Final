<div class="modal fade text-left" id="ProcessingModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel17">Complain Processing Actions</h4>
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

                <form id="processingForm" action="{{ route('hard.complain.action.processing',[$compData->id,$compData->user_id]) }}" method="post" enctype="multipart/form-data" >
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-md-3 label-control" for="userinput5">Process: </label>
                                <div class="col-md-9">
                                   <select id="processSelect" class="form-control" name="process">
                                        <option value="Processing">Processing</option>
                                        <option value="Closed">Closed</option>
                                        <option value="Damaged">Damaged</option>
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

                    <div id="processDeliveryStatus" style="display:none">
                        <div class="row">
                            <label class="col-sm-3 control-label text-danger">Deliverable:</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="custom-control custom-radio d-inline-block ml-1">
                                        <input type="radio" id="d_req_st_pro" value="Deliverable" name="delivery" class="custom-control-input">
                                        <label class="custom-control-label" for="d_req_st_pro">Yes</label>
                                    </div>
                                    <div class="custom-control custom-radio d-inline-block ml-2">
                                        <input type="radio" id="activeNpro" value="" name="delivery" class="custom-control-input">
                                        <label class="custom-control-label" for="activeNpro">No</label>
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
