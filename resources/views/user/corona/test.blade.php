@extends('user.layout.corona-master')
@section('title', 'corona-dashboard')

@section('page-css')

    <!-- Summernote Editor CSS -->
    <link href="{{ asset('user/assets/coustom/summernote/summernote-lite.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('common/datatables/css/1.10.20.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('common/datatables/css/2.2.3.responsive.bootstrap4.min.css') }}">

    {{-- button exports --}}
    <link rel="stylesheet" href="{{ asset('common/export-datatable/css/jquery.dataTables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('common/export-datatable/css/datatable.button.min.css') }}" />
    {{-- button exports --}}

@endsection


@section('content')
<!-- File export table -->
<section id="file-export" class="mt-3">
  <div class="row">
    <div class="col-12">
      <div class="card">
         <form id="frm-example" method="get">
        <div class="card-header">
         <div class="row">
           <div class="col-md-6">
             <h4 class="">Display Today Temperature Records</h4>
           </div>

           <div class="col-md-6">

            <button type="button" name="create_record" id="create_record" class="btn gradient-nepal white big-shadow float-right">Add <i class="fa fa-pencil"></i></button>

           </div>
         </div>

        </div>
          <div class="card-body card-dashboard table-responsive">
            <div class="table-responsive">
              <div class="card-content">

           <br />

              <table class="table table-bordered table-striped text-center" id="JsDataTable">
                <thead>
                  <tr>
                    <th>ID</th>
                    {{-- <th>Name</th>
                    <th>Department</th>
                    <th>Temperature</th>
                    <th>Date</th> --}}

                  </tr>
                </thead>


              </table>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- File export table -->





@endsection




@section('page-js')

    {{-- DataTable --}}
    <script src="{{ asset('common/datatables/js/1.10.20.jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('common/datatables/js/1.10.20.dataTables.bootstrap4.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('common/datatables/js/2.2.3.dataTables.responsive.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('common/datatables/js/2.2.3.responsive.bootstrap4.min.js') }}" type="text/javascript"></script>


    {{-- button exports --}}
    <script src="{{ asset('common/export-datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('common/export-datatable/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('common/export-datatable/js/jszip.min.js') }}"></script>
    <script src="{{ asset('common/export-datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('common/export-datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('common/export-datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('common/export-datatable/js/buttons.print.min.js') }}"></script>
    {{-- button exports --}}


<script>

$(document).ready(function(){


    //For Warranty
    (function($){




    })(jQuery)

  // Show data in page
   var table= $('#JsDataTable').DataTable({
    language: {
        processing: '<i class="fa fa-refresh fa-spin fa-3x fa-fw green"></i><span class="sr-only">Loading...</span> '},
    processing: true,
    serverSide: true,
    pagingType: "full_numbers",
    stateSave: true,
    order: [ [0, 'desc'] ],

    ajax:{
    url: "\test",
    },
      columns:[

            {
                data: 'data.id_number',
                name: 'data.id_number'
            },
            //    {
            //     data: 'name',
            //     name: 'name'
            // },
            // {
            //     data: 'department',
            //     name: 'department'
            // },
            // {
            //     data: 'temperature',
            //     name: 'temperature'
            // },
            // {
            //     data: 'temp_date',
            //     name: 'temp_date'
            // },


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
          'excel', 'csv', 'pdf', 'copy'
        ],
        extend: 'csv',
        text:   'Save Log Info syful',
        filename: function () { return getExportFileName();}
  });





});




</script>

 @endsection



