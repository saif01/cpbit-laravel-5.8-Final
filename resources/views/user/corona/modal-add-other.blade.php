<!-- Modal -->
<div class="modal fade" id="addDataModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Add Others</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <span id="form_result"></span>
            <form method="post" id="sample_form" >
                @csrf
                    <div class="form-group">
                        <label class="control-label">Temperature : </label>
                        <input type="text" name="temp" id="temp" class="form-control" placeholder="User Temperature like : 98.6" required/>
                    </div>


                    <div class="form-group">
                        <label class="control-label">Name : </label>
                        <input type="text" name="name"  class="form-control" placeholder="Enter Name" required />
                    </div>

                    <div class="form-group">
                        <label class="control-label">From : </label>
                        <input type="text" name="from" class="form-control" placeholder="Enter Come From" required />
                    </div>

                   <div class="form-group">
                       <label class="control-label">To : </label>
                       <input type="text" name="to" class="form-control" placeholder="Enter Why or where Come" required />
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
                       <input type="submit"  class="btn btn-success btn-block" value="Submit Data" />
                   </div>
               </form>


        </div>

      </div>
    </div>
</div>
