<div class="modal fade text-left" id="DelieveryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel17">Product Deliverable Actions</h4>
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

                <form id="delieveryForm" action="{{ route('hard.complain.action.delievery',[$compData->id,$compData->user_id]) }}" method="post" enctype="multipart/form-data" >
                    @csrf
                   <div class="row">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label class="col-md-3 label-control" for="userinput5">Receiver's Name: </label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="name" placeholder="Enter Product Receiver Name"
                                    required="required">
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-7">
                        <div class="form-group row">
                            <label class="col-md-3 label-control" for="userinput5">Contract : </label>
                            <div class="col-md-9">
                                <input type="number" class="form-control" name="contact"
                                    placeholder="Enter Product Receiver Phone Number" maxlength="11" required="required">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group row">
                            <label class="col-md-3 label-control">File's : </label>
                            <div class="col-md-9">
                                <input type="file" name="document">
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
