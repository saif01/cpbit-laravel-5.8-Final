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
           <div class="col-md-10">
               @if (!empty($search))

           <h5>Display  <span class="text-info" >{{ date("F j, Y", strtotime($search->start))}}</span> To <span class="text-info">{{ date("F j, Y", strtotime($search->end))  }}</span> Temperature Records of <b>{{ $search->name }} ({{ $search->empID }})</b></h5>
               @else
                    <h4>Display All Letest Temperature Records</h4>
               @endif

           </div>

           <div class="col-md-2">

            <button type="button" id="search_record" class="btn btn-info float-right">Search Record <i class="fa fa-search-plus"></i></button>

           </div>
         </div>

        </div>
          <div class="card-body card-dashboard table-responsive">
            <div class="table-responsive">
              <div class="card-content">

        @if(!empty($allData))

                <table class="table table-bordered table-striped text-center file-export" >
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Temperature</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($allData as $item)
                        <tr>
                            <td>{{ $item->id_number }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->department }}</td>
                            <td>

                                @if (round($item->temp_final) >= 101)
                                    <button type="button" id="{{ $item->id }}" class="view_record btn btn-danger" >{{ $item->temp_final }} &#8457</button>
                                @else
                                <button type="button" id="{{ $item->id }}" class="view_record btn btn-success" >{{ $item->temp_final }} &#8457</button>
                                @endif

                            </td>
                            <td>{{ date("F j, Y", strtotime($item->created_at)) }}</td>

                        </tr>
                        @endforeach

                    </tbody>


                </table>


                <div class="row mt-2">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">User Temperature Chart By Search Data</h4>
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
                    <th>ID</th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Temperature</th>
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


<!--Search Modal -->
@include('admin.corona.modals.user-report-search')
{{-- View Single Report --}}
@include('admin.corona.modals.user-single-report')



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

    <script>
                $(document).on('click', '#search_record', function(){
                    $('#SearchDataModal').modal('show');
                });

                $(document).on('click', '.view_record', function(){

                    //From Tbl Field
                     id = $(this).attr('id');

                    //AJAX Request
                    $.ajax({
                        url:"single-details/"+id,
                        dataType:"json",
                        success:function(data)
                        {

                            //console.log(data);
                            $('#id_number').html(data.id_number);
                            $('#name').html(data.name);
                            $('#department').html(data.department);
                            $('#temp_final').html(data.temp_final+' &#8457');
                            $('#temp_1').html(data.temp_1);
                            $('#temp_1_location').html(data.temp_1_location);
                            $('#temp_1_time').html(data.temp_1_time);
                            $('#temp_1_by_name').html(data.temp_1_by_name);
                            $('#temp_2').html(data.temp_2+' &#8457');
                            $('#temp_2_location').html(data.temp_2_location);
                            $('#temp_2_time').html(data.temp_2_time);
                            $('#temp_2_by_name').html(data.temp_2_by_name);
                            $('#temp_3').html(data.temp_3+' &#8457');
                            $('#temp_3_location').html(data.temp_3_location);
                            $('#temp_3_time').html(data.temp_3_time);
                            $('#temp_3_by_name').html(data.temp_3_by_name);
                            $('#temp_4').html(data.temp_4+' &#8457');
                            $('#temp_4_location').html(data.temp_4_location);
                            $('#temp_4_time').html(data.temp_4_time);
                            $('#temp_4_by_name').html(data.temp_4_by_name);
                            $('#temp_5').html(data.temp_5+' &#8457');
                            $('#temp_5_location').html(data.temp_5_location);
                            $('#temp_5_time').html(data.temp_5_time);
                            $('#temp_5_by_name').html(data.temp_5_by_name);
                            $('#remarks').html(data.remarks);



                            //Set Modal Title
                            $('.modal-title').text('View Single Temperature Details');
                            //Set Action Btn Value
                            $('#action_button').val('Edit');

                            //Show Modal
                            $('#showDataModal').modal('show');
                        },
                        error: function (xhr, status, errorThrown) {
                            //Here the status code can be retrieved like;
                            console.log(xhr.status);
                            //The message added to Response object in Controller can be retrieved as following.
                            console.log(xhr.responseText);
                        }
                    });
                });

                (function($){

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

                })(jQuery)
    </script>


    @if(!empty($allData))

    @php
        $chartTitle = "Temperature chart : ".$search->name." (".  $search->empID .")";
    @endphp


    <script>
        var ctx = document.getElementById('myChart2').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                //labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                labels: [
                        <?php foreach ($allData as $level ){ echo '"' . date("F j,", strtotime($level->created_at)) .' : '. $level->id_number.  '"' . ','; } ?>
                        ],
                datasets: [{
                    label: <?php echo '"' . $chartTitle . '"'  ?>,
                    data: [
                        <?php foreach ($allData as $data ){ echo '"' . $data->temp_final . '"' . ','; } ?>
                        ],
                        backgroundColor: [<?php
                for ($i=0; $i <= $allData->count(); $i++) {
                    echo  "'#". substr(md5(rand()), 0, 6)."',";
                    }?> ],
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
                order: [ [0, 'desc'] ],
                dom: 'lBfrtip',
                buttons: [
                'excel', 'csv', 'pdf', 'copy', 'print'
                ],

            });

        });

    </script>

    @else

    <script>

        $(document).ready(function(){



            // Show data in page
            var table= $('#JsDataTable').DataTable({
                language: {
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw text-success"></i><span class="sr-only">Loading...</span> '},
                processing: true,
                serverSide: true,
                pagingType: "full_numbers",
                stateSave: true,
                order: [ [0, 'desc'] ],

                ajax:{
                url: "user-temp",
                },
                columns:[

                        {
                            data: 'id_number',
                            name: 'id_number'
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'department',
                            name: 'department'
                        },
                        {
                            data: 'temperature',
                            name: 'temperature'
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




        });


        </script>

    @endif



 @endsection



