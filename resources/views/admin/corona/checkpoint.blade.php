@extends('admin.layout.corona-master')
@section('title', 'corona-all-user')

@section('page-css')

    <link rel="stylesheet" href="{{ asset('common/datatables/css/1.10.20.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('common/datatables/css/2.2.3.responsive.bootstrap4.min.css') }}">


@endsection



@section('content')

<section id="pagination">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">All Checpoint

                        <button class="btn gradient-nepal white big-shadow float-right" id="create_record"
                           >Add <i class="fa fa-pencil"
                                aria-hidden="true"></i>
                        </button>

                    </h4>

                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard table-responsive">
                        <table id="jsDatatable" class="table table-striped table-bordered text-center">
                            <thead>
                                <tr>

                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>


                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>




{{-- Modal --}}

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



             <div class="form-group">
                <label class="control-label" > Name : </label>
                 <input type="text" name="name" id="name" class="form-control" placeholder="User Name" />
               </div>


                <br />
                <div class="form-group text-center">
                <input type="hidden" name="action" id="action" value="Add" />
                <input type="hidden" name="hidden_id" id="hidden_id" />
                <input type="submit" name="action_button" id="action_button" class="btn btn-primary btn-block" value="Add" />
                </div>
            </form>
        </div>
      </div>
    </div>
</div>





@endsection



@section("page-js")


    {{-- DataTable --}}
    <script src="{{ asset('common/datatables/js/1.10.20.jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('common/datatables/js/1.10.20.dataTables.bootstrap4.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('common/datatables/js/2.2.3.dataTables.responsive.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('common/datatables/js/2.2.3.responsive.bootstrap4.min.js') }}" type="text/javascript"></script>

    <!-- Modal Show-->
    <script src="{{ asset('admin/app-assets/js/components-modal.min.js') }}" type="text/javascript" ></script>





    <script type="text/javascript">


        $(document).ready(function(){

            //All Data
            $('#jsDatatable').DataTable({
                language: {
                    processing: '<i class="fa fa-refresh fa-spin fa-3x fa-fw green"></i><span class="sr-only">Loading...</span> '},
                processing: true,
                serverSide: true,
                pagingType: "full_numbers",
                stateSave: true,
                order: [ [0, 'desc'] ],


                ajax: {
                    url: "\dashboard",
                },
                columns: [
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        "searchable": false
                    }
                ]
            });


            //Create New Record
            $('#create_record').click(function(){
                    $('.modal-title').text('Add Data');
                    $('#action_button').val('Add');
                    $('#action').val('Add');
                    $('#form_result').html('');

                    $('#id_number').val('');
                    $('#name').val('');
                    $('#department').val('');
                    $('#remarks').val('');

                    $('#formModal').modal('show');
            });

            //Form Submit
            $('#sample_form').on('submit', function(event){
                    event.preventDefault();
                    var action_url = '';

                    if($('#action').val() == 'Add')
                    {
                    action_url = "\store";
                    }

                    if($('#action').val() == 'Edit')
                    {
                    action_url = "\data-update";
                    }

                    $.ajax({
                        url: action_url,
                        method:"POST",
                        data: $(this).serialize(),
                        dataType:"json",

                        success:function(data)
                            {

                                var html = '';
                                if(data.errors)
                                    {
                                        html = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                                        for(var count = 0; count < data.errors.length; count++)
                                        {
                                            html += '<li class="text-light">' + data.errors[count] + '</li>';
                                        }
                                        html += '</div>';

                                        $('#form_result').html(html);
                                    }
                                if(data.success)
                                    {
                                        //console.log(data.success);

                                        $('#sample_form')[0].reset();
                                        $('#jsDatatable').DataTable().ajax.reload();
                                        $('#formModal').modal('hide');



                                        Toast.fire({
                                        icon: 'success',
                                        title: data.success,
                                        })
                                    }



                             },
                            error: function (xhr, status, errorThrown) {
                                //Here the status code can be retrieved like;
                                console.log(xhr.status);
                                //The message added to Response object in Controller can be retrieved as following.
                                console.log(xhr.responseText);
                            }
                    });
            });


            //Update Record data fetch
            $(document).on('click', '.edit', function(){

                //From Tbl Field
                var id = $(this).attr('id');

                //Validation Result
                $('#form_result').html('');

                //AJAX Request
                $.ajax({
                    url:"data-edit/"+id,
                    dataType:"json",
                    success:function(data)
                    {


                        $('#name').val(data.result.name);
                        $('#hidden_id').val(id);
                        //Set Modal Title
                        $('.modal-title').text('Edit Data');
                        //Set Action Btn Value
                        $('#action_button').val('Edit');
                        //Set Action Route Value
                        $('#action').val('Edit');
                        //Show Modal
                        $('#formModal').modal('show');
                    },
                    error: function (xhr, status, errorThrown) {
                        //Here the status code can be retrieved like;
                        console.log(xhr.status);
                        //The message added to Response object in Controller can be retrieved as following.
                        console.log(xhr.responseText);
                    }
                })
            });




                    //Make Change Status
                $(document).on('click', '.status', function(){
                    makeValue = $(this).attr('makeValue');
                    id = $(this).attr('id');
                    if(makeValue == 1){
                        conText = "This user will be Active!";
                        btnText =  'Yes, Active !';
                    }else{
                        conText = "This user will be Inactive!";
                        btnText =  'Yes, Inactive !';
                    }
                    Swal.fire({
                        title: 'Are you sure?',
                        text: conText,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: btnText
                        }).then((result) => {

                            if (result.value) {

                                $.ajax({
                                        url:"status/"+id+"/"+makeValue,
                                        method: 'get',
                                        success:function(data)
                                        {

                                            $('#jsDataTable').DataTable().ajax.reload(null, false);
                                            //Sweet alert
                                            Swal.fire({
                                                position: 'center',
                                                icon: 'success',
                                                title: 'Successfully, Status Changed',
                                                showConfirmButton: false,
                                                timer: 1500
                                            });

                                        },
                                        error: function (xhr, status, errorThrown) {
                                                //Here the status code can be retrieved like;
                                                console.log(xhr.status);
                                                //The message added to Response object in Controller can be retrieved as following.
                                                console.log(xhr.responseText);
                                            }
                                    });

                            }
                        });

            });


            //Define Delete ID
            var delete_id;
            //Delete
            $(document).on('click', '.delete', function(){
                 delete_id = $(this).attr('id');

                 Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {

                        if (result.value) {

                            $.ajax({
                                    url:"data-delete/"+delete_id,
                                    // beforeSend:function(){
                                    //     $('#ok_button').text('Deleting...');
                                    // },
                                    success:function(data)
                                    {
                                        if(data == 'ok'){
                                            $('#confirmModal').modal('hide');
                                            $('#jsDatatable').DataTable().ajax.reload();

                                            //Sweet alert
                                            Swal.fire({
                                                position: 'center',
                                                icon: 'success',
                                                title: 'Your file has been deleted',
                                                showConfirmButton: false,
                                                timer: 1500
                                            })
                                        }else{
                                            Swal.fire({
                                                position: 'center',
                                                icon: 'error',
                                                title: 'Somthing going wrong !!',
                                                showConfirmButton: false,
                                                timer: 1500
                                            })
                                        }



                                    },
                                    error: function (xhr, status, errorThrown) {
                                            //Here the status code can be retrieved like;
                                            console.log(xhr.status);
                                            //The message added to Response object in Controller can be retrieved as following.
                                            console.log(xhr.responseText);
                                        }
                                })


                        }
                    })


            });



        });

    </script>

@endsection
