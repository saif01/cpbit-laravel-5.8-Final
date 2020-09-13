@extends('user.layout.corona-master')
@section('title', 'iTemp Users')

@section('page-css')
        {{-- CSS tbl exports --}}
        @include('user.layout.data-tbl.tbl-css')

@endsection




@section('content')

<section class="mt-3">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">All User</h4>

                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard table-responsive">
                        <table id="jsDatatable" class="table table-striped table-bordered text-center">

                            <thead>
                                <tr class="text-center">
                                    <th>Action</th>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Department</th>
                                    <th class="pb-2">Temperature</th>
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
@include('user.corona.modal-tem-input')




@endsection



@section("page-js")

    {{-- JS tbl exports --}}
    @include('user.layout.data-tbl.tbl-js')


    <script type="text/javascript">


        $(document).ready(function(){

            //All Data
            $('#jsDatatable').DataTable({
                language: {
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw text-success"></i><span class="sr-only">Loading...</span> '},
                processing: true,
                serverSide: true,
                pagingType: "full_numbers",
                stateSave: true,
                order: [ [0, 'desc'] ],


                ajax: {
                    url: "\all-user",
                },
                columns: [
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        "searchable": false
                    },
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
                        name: 'temperature',
                        orderable: false,
                        "searchable": false,
                        "class" : 'p-0',
                        "width": "50%",

                    },





                ]
            });


            $(document).on('click', '.create_record', function(){

                    $('.modal-title').text('Add Today Temperature Data');

                     //From Tbl Field
                     var id = $(this).attr('id');

                    $('#user_tbl_id').val(id);
                    $('#temp').val('');

                    $('#formModal').modal('show');

            });

            //Form Submit
            $('#sample_form').on('submit', function(event){
                    event.preventDefault();

                    $.ajax({
                        url:  "\store-temp",
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
                                            html += '<li>' + data.errors[count] + '</li>';
                                        }
                                        html += '</div>';

                                        $('#form_result').html(html);
                                    }
                                if(data.success)
                                    {
                                        //console.log(data.success);

                                        $('#sample_form')[0].reset();
                                        $('#jsDatatable').DataTable().ajax.reload(null, false);
                                        $('#formModal').modal('hide');



                                        //Sweet alert
                                        Swal.fire({
                                                position: 'center',
                                                icon: 'success',
                                                title: data.success,
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
                    });
            });







        });

    </script>

@endsection
