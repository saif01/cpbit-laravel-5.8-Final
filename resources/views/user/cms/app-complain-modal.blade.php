<!-- Application Model Modal  -->
<div id="Application" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- Main Content show -->
            <div class="modal-body text-info">
                <form action="{{ route('user.app.complain.submit') }}" id="appForm" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row col-md-12">
                        <div class="col-md-6">
                            <div class="form-group required">
                                <label>Software Select</label>
                                <select class="form-control" name="cat_id" id="appCategory" required="required">
                                    <option value="" disabled selected>Select SoftWare Name</option>
                                    @foreach ($categoryData as $category)
                                    <option value="{{ $category->id }}">{{ $category->category }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group required">
                                <label>Module Select</label>
                                <select class="form-control" name="sub_id" id="appSubCategory" required="required">

                                </select>
                            </div>
                        </div>
                    </div>


                    <label>Document's (Photos / PDF / Screenshort)</label><span>(Max 1.5MB)</span>
                    <div class="row col-md-12">
                        <div class="col-md-3">
                            <div class="form-group">

                                <input type="file" name="doc1" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="file" name="doc2" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="file" name="doc3" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="file" name="doc4" class="form-control form-control-sm">
                            </div>
                        </div>
                    </div>

                    <div class="form-group required">
                        <label>Application Complain's Details</label>
                        <textarea class="form-control" name="details" required="required"></textarea>
                    </div>
            </div>

            <div class="modal-footer">
                <div class="col-md-12 row">
                    <div class="col-md-11">
                       <button type="submit" id="appSubmit" name="submit" class="btn btn-success btn-block bold">Submit</button>
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
<!-- End Application Modal -->
