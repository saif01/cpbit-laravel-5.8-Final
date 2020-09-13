@extends('admin.layout.corona-master')
@section('title', 'iTemp Temperature Records')

@section('page-css')
{{-- CSS tbl exports --}}
@include('user.layout.data-tbl.export-tbl-css')

@endsection


@section('content')
<!-- File export table -->
<section id="file-export" class="mt-3">
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8">
                            @if (!empty($search))

                            <h5>Display <span class="text-info">{{ date("F j, Y", strtotime($search->start))}}</span> To <span class="text-info">{{ date("F j, Y", strtotime($search->end))  }}</span> Temperature Records </h5>

                            @else
                            <h4>Display Others Records</h4>
                            @endif

                        </div>

                        <div class="col-md-4">

                            <button type="button" id="search_record" class="btn btn-info float-right mr-2">Search <i class="fa fa-search-plus"></i></button>

                        </div>
                    </div>

                </div>
                <div class="card-body card-dashboard table-responsive">
                    <div class="table-responsive">
                        <div class="card-content">

                            @if(!empty($allData))

                            <table class="table table-bordered table-striped text-center file-export">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Temperature</th>
                                        <th>Location</th>
                                        <th>Temperature By</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($allData as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->from }}</td>
                                        <td>{{ $item->to }}</td>
                                        <td>

                                            @if (round($item->temp) >= 101)
                                            <span class="h5 bg-danger p-1 text-light rounded">{{ $item->temp }} &#8457</span>
                                            @else
                                            <span class="h5 bg-success p-1 text-light rounded">{{ $item->temp }} &#8457</span>
                                            @endif

                                        </td>
                                        <td>{{ $item->temp_location }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        <td>{{ date("F j, Y", strtotime($item->created_at)) }}</td>

                                    </tr>
                                    @endforeach

                                </tbody>


                            </table>


                            <div class="row mt-2">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Temperature Chart By Search Data</h4>
                                        </div>
                                        <div class="card-content">
                                            <div class="card-body chartjs">
                                                <canvas id="myChart2" width="400" height="150"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            @else

                            <table class="table table-bordered table-striped text-center" id="JsDataTable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Temperature</th>
                                        <th>Location</th>
                                        <th>Temperature By</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                            </table>

                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- File export table -->


{{-- <!--Search Modal --> --}}
@include('admin.corona.modals.other-report-search')




@endsection




@section('page-js')

{{-- JS tbl exports --}}
@include('user.layout.data-tbl.export-tbl-js')

  <!-- Modal Show-->
  <script src="{{ asset('admin/app-assets/js/components-modal.min.js') }}" type="text/javascript" ></script>

<!--Chart.js-->
<script src="{{ asset('common/Chart/Chart.min.js') }}"></script>

{{-- Date Piker --}}
@include('admin.layout.datePiker.datePiker')

{{-- Common JS --}}
<script>
    $(document).on('click', '#search_record', function() {
        $('#SearchDataModal').modal('show');
    });


    (function($) {

        $('#reportType').click(function() {
            var valu = $(this).val();

            if (valu != '') {
                $('#datepicker').attr('disabled', 'disabled');
                $('#datepicker2').attr('disabled', 'disabled');
            } else {
                $('#datepicker').attr('disabled', false);
                $('#datepicker2').attr('disabled', false);
            }

        });

    })(jQuery)
</script>


@if(!empty($allData))



<script>
    var ctx = document.getElementById('myChart2').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            //labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            labels: [
                <?php foreach ($allData as $level ){ echo '"' . date("F j,", strtotime($level->created_at)) .' : '. $level->name.  '"' . ','; } ?>
            ],
            datasets: [{
                label: [],
                data: [
                    <?php foreach ($allData as $data ){ echo '"' . $data->temp . '"' . ','; } ?>
                ],
                backgroundColor: [<?php
                for ($i=0; $i <= $allData->count(); $i++) {
                    echo  "'#". substr(md5(rand()), 0, 6)."',";
                    }?>],
                borderColor: [],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>



<script>
    $(document).ready(function() {

        $('.file-export').DataTable({
            pagingType: "full_numbers",
            stateSave: true,
            order: [
                [0, 'desc']
            ],
            dom: 'lBfrtip',
            buttons: [
                'excel', 'csv', 'pdf', 'copy', 'print'
            ],

        });

    });
</script>

@else

<script>
    $(document).ready(function() {

        // Show data in page
        var table = $('#JsDataTable').DataTable({
            language: {
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw text-success"></i><span class="sr-only">Loading...</span> '
            },
            processing: true,
            serverSide: true,
            pagingType: "full_numbers",
            stateSave: true,
            order: [
                [0, 'desc']
            ],

            ajax: {
                url: "others-temp",
            },
            columns: [


                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'from',
                    name: 'from'
                },
                {
                    data: 'to',
                    name: 'to'
                },
                {
                    data: 'temperature',
                    name: 'temperature'
                },
                {
                    data: 'temp_location',
                    name: 'temp_location'
                },
                {
                    data: 'actionBy',
                    name: 'actionBy'
                },
                {
                    data: 'temp_date',
                    name: 'temp_date'
                },


                // {
                //     data: 'action',
                //     name: 'action',
                //     orderable: false,
                //     "searchable": false,
                //     "width": "13%",
                //     "class": "text-center"
                // }
            ],
            dom: 'lBfrtip',
            buttons: [
                'excel', 'csv', 'pdf', 'copy', 'print'
            ],

        });

        //Add Modal Show
        $(document).on('click', '#add_record', function() {

            $('#addDataModal').modal('show');
        });


        //Form Submit
        $('#sample_form').on('submit', function(event) {
            event.preventDefault();

            $.ajax({
                url: "\others-add",
                method: "POST",
                data: $(this).serialize(),
                dataType: "json",

                success: function(data) {

                    var html = '';
                    if (data.errors) {
                        html = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                        for (var count = 0; count < data.errors.length; count++) {
                            html += '<li>' + data.errors[count] + '</li>';
                        }
                        html += '</div>';

                        $('#form_result').html(html);
                    }
                    if (data.success) {
                        //console.log(data.success);

                        $('#sample_form')[0].reset();
                        $('#JsDataTable').DataTable().ajax.reload(null, false);
                        $('#addDataModal').modal('hide');

                        //Sweet alert
                        Swal.fire({
                            position: 'center',
                            icon: data.icon,
                            title: data.success,
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }



                },
                error: function(xhr, status, errorThrown) {
                    //Here the status code can be retrieved like;
                    console.log(xhr.status);
                    //The message added to Response object in Controller can be retrieved as following.
                    console.log(xhr.responseText);
                }
            });
        });






    });
</script>

@endif



@endsection
