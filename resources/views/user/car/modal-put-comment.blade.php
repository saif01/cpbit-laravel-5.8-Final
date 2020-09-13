<style type="text/css">
	.error{
		color:red;
	}

</style>
<!-- Modal -->
<div class="modal fade" id="CommentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Put Car Using Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"> 
                <form id="commentInputForm"  action="{{ route('user.car.comment.action') }}" method="post" name="chngpwd" id="commentForm" >
                    @csrf
                    <input type="hidden" id="booking_id" name="booking_id">

                    <div class="form-group">
                            <label class="col-sm-12 control-label" for="start_mileage">Start Mileage :</label>
                            <div class="col-sm-12">
                                <input type="number" class="start_mileage form-control" id="start_mileage" name="start_mileage" placeholder="Put Meter Reading" min="0" max="999999999999" />
                            </div>
                    </div>
                    <div class="form-group">
                            <label class="col-sm-12 control-label" for="end_mileage">End Mileage :</label>
                            <div class="col-sm-12">
                                <input type="number" class="end_mileage form-control" id="end_mileage" name="end_mileage" placeholder="Put Meter Reading" min="0" max="999999999999" />
                            </div>
                    </div>

                    
                    <div class="form-group">
                            <label class="col-sm-12 control-label" for="gas">CNG Bill :</label>
                            <div class="col-sm-12">
                                <input type="number" class="gas form-control" id="gas" name="gas" placeholder="Amount of Taka" min="0" max="999999999999" />
                            </div>
                    </div>
                    <div class="form-group">
                            <label class="col-sm-12 control-label" for="octane">Octane Bill :</label>
                            <div class="col-sm-12">
                                <input type="number" class="octane form-control" id="octane" name="octane" placeholder="Amount of Taka" min="0" max="999999999999" />
                            </div>
                    </div>
                    <div class="form-group">
                            <label class="col-sm-12 control-label" for="toll">Toll Bill :</label>
                            <div class="col-sm-12">
                                <input type="number" class="toll form-control" id="toll" name="toll" placeholder="Amount of Taka" min="0" max="999999999999" />
                            </div>
                    </div>

                    <div class="form-group">
                            <label class="col-sm-12 control-label" for="driver_rating">Driver Rating :</label>
                            <div class="col-sm-12">
                                <input type="number" class="driver_rating form-control" id="driver_rating" name="driver_rating" placeholder="Put marking out of 10" min="0" max="10" />
                            </div>
                    </div>
                    <div class='actions pt-3'>
                        <div id="afterComment">
                            <input type="submit" id="CloseBtn2" name="closeComit" class="btn btn-danger float-right"
                                onClick="return confirm('Are you sure you want to Close This???')"
                                value="Close Permanently" />
                        </div>
                        <div id="beforComment" style="display:none">
                            <input type="submit" formnovalidate id="updateBtn" name="update" class="btn btn-primary" value="Update">

                            <input type="submit" id="CloseBtn" name="closeComit" class="btn btn-danger float-right" value="Close Permanently" />
                        </div>


                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
