<div id="formModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <span id="form_result"></span>

            <form method="post" id="sample_form" >
             @csrf

             <input type="hidden" name="user_tbl_id" id="user_tbl_id">

                <div class="form-group">
                    <label class="control-label">Today Temperature : </label>
                    <input type="text" name="temp" id="temp" class="form-control" placeholder="User Today Temperature like : 98.6" />
                </div>

                <div class="form-group">
                    <label class="control-label">Check Point : </label>
                    <select name="checkpoint" class="form-control" required>
                        <option selected="true" disabled="disabled">Choose Check Point</option>
                        @foreach ($checkPoints as $checkPoint)
                            <option value="{{ $checkPoint->name }}">{{ $checkPoint->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="control-label">Remarks : </label>
                    <textarea name="remarks" id="remarks" class="form-control" placeholder="Remarks If Any"></textarea>
                </div>



                <br />
                <div class="form-group text-center">
                    <input type="submit"  class="btn btn-primary btn-block" value="Record Add" />
                </div>
            </form>
        </div>
      </div>
    </div>
</div>
