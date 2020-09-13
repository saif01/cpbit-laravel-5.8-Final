@extends('admin.layout.network-master')

@section('page-css')
    {{-- Data table css --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
@endsection

{{-- Page Js --}}
@section('page-js')
{{-- ExportAble dataTable --}}
@include('admin.layout.dataTable.datatableExportJs')
{{-- Date Piker --}}
@include('admin.layout.datePiker.datePiker')
<!-- Modal Show-->
<script src="{{ asset('admin/app-assets/js/components-modal.min.js') }}" type="text/javascript"></script>
<!-- Custom Sweet alert -->
<script src="{{ asset('admin/app-assets/custom/sweetAlert2Function.js') }}" type="text/javascript"></script>


<script>

    (function(){

        $('#reportType').click( function(){
            var valu = $(this).val();

            if( valu != '' ){
                $('#datepicker').attr('disabled', 'disabled');
                $('#datepicker2').attr('disabled', 'disabled');
            }else{
                $('#datepicker').attr('disabled', false);
                $('#datepicker2').attr('disabled', false);
            }

        });

    })(jQuery);



    (function(){
    $("#SearchByModal").click( ()=>{
    $('#ModalForm')[0].reset();
    $("#SearchDataModal").modal("show");
    });
    })(jQuery);
</script>

@endsection
{{-- End Js Section --}}

{{-- Start Main Content --}}
@section('content')

<!-- Alternative pagination table -->
<section id="pagination">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title text-capitalize">
                        @if (isset($search))

                        <span class="text-info"> {{ $search->ip }}</span> Ping Reports
                        <span class="text-info" >{{ date("F j, Y", strtotime($search->start))." To ".date("F j, Y", strtotime($search->end))  }}</span>

                        @else
                            Last 7 Days Offline Report's
                        @endif
                        <a href="{{ route('report.main.ip') }}"
                            class="btn btn-primary gradient-green-tea float-right">Reload <i class="fa fa-refresh" aria-hidden="true"></i></a>

                            <button id="SearchByModal" class="btn btn-success gradient-sublime-vivid  float-right mr-1">Search <i class="fa fa-search-plus" aria-hidden="true"></i></button>
                    </h5>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard table-responsive ">
                        <table class="table table-striped table-bordered file-export text-center">
                            <thead>
                                <tr>
                                    <th>IP</th>
                                    <th>Name</th>
                                    <th>Latency</th>
                                    <th>Status</th>
                                    <th>Ping Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allData as $row )
                                <tr>
                                    <td>{{ $row->ip }}</td>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->latency }} ms.</td>
                                    <td> {{ $row->status }} </td>
                                    <td>{{ date("F j, Y, g:i a", strtotime($row->created_at)) }}</td>

                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--/ Alternative pagination table -->


<!--Search Modal -->
<div class="modal fade" id="SearchDataModal" tabindex="-1" role="dialog" aria-labelledby="SearchDataModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="SearchDataModalLabel">Search IP Ping Report's</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

               <form action="{{ route('report.main.ip.search') }}" id="ModalForm" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Select Report Type</label>
                                <select name="reportType" id="reportType" class="form-control">
                                    <option value="" >Select One</option>
                                    <option value="last3">Last 3 Days Reports</option>
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
                                    <input type='text' class="form-control" id="datepicker" name="start"
                                        placeholder="Enter Start Date" />
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
                                    <input type='text' class="form-control" id="datepicker2" name="end" placeholder="Enter End Date"
                                        />
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
                                <label>All IP & Name</label>
                                <select name="ip" class="form-control" required="required">
                                    <option value=""  >Select Reporting IP</option>
                                    @foreach ($allIp as $ip)
                                    <option value="{{ $ip->ip }}">{{ $ip->ip }} || {{ $ip->name }}</option>
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



@endsection
