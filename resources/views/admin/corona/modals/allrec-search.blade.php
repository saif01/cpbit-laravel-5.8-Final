<div class="modal fade" id="SearchDataModal" tabindex="-1" role="dialog" aria-labelledby="SearchDataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="SearchDataModalLabel">Search Record's</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form method="post" action="{{ route('admin.corona.search.data') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Select Report Type</label>
                                <select name="reportType" id="reportType" class="form-control">
                                    <option value="">Select One</option>
                                    <option value="last3D">Last 3 Days Reports</option>
                                    <option value="last5D">Last 5 Days Reports</option>
                                    <option value="last7D">Last 7 Days Reports</option>
                                    <option value="last10D">Last 10 Days Reports</option>
                                    <option value="last15D">Last 15 Days Reports</option>
                                    <option value="last30D">Last 30 Days Reports</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Start Date</label>
                                <div class='input-group'>
                                    <input type='text' class="form-control" id="datepicker" name="start" placeholder="Enter Start Date" />
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <span class="fa fa-calendar-o"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>End Date</label>
                                <div class='input-group'>
                                    <input type='text' class="form-control" id="datepicker2" name="end" placeholder="Enter End Date" />
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <span class="fa fa-calendar-o"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>All User</label>
                                <select name="user_id" class="form-control">
                                    <option value="">All User Data</option>
                                    @foreach ($userData as $user)
                                    <option value="{{ $user->id }}">{{ $user->id_number }} || {{ $user->name }}</option>
                                    {{-- <option value="{{ $user->id }}">{{ ltrim(substr($user->id_number, 2), 0)  }} || {{ $user->name }}</option> --}}
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">View Reports</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
