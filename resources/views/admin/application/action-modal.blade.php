<div class="modal fade text-left" id="actionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
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
                        <th>Sofware:</th>
                        <td id="software">{{ $compData->category }}</td>
                        <th>Module:</th>
                        <td id="module">{{ $compData->subcategory }}</td>
                    </tr>

                </table>

                <form action="{{ route('app.complain.action.update',[$compData->id,$compData->user_id]) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-md-3 label-control" for="userinput5">Process: </label>
                                <div class="col-md-9">
                                    <select class="form-control" name="process">
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
