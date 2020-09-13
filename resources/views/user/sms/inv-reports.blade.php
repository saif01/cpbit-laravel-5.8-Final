@extends('user.layout.sms-master')

@section('page-css')
{{-- Data table css --}}
<link rel="stylesheet" type="text/css"
    href="{{ asset('admin/app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
@endsection

@section('page-js')

{{-- Data table js --}}
<script src="{{ asset('admin/app-assets/vendors/js/datatable/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('admin/app-assets/js/data-tables/datatable-basic.js') }}" type="text/javascript"></script>

<script>


$(document).ready(function(){
        
        $('#exportToExcel').click(function() {

         

          var exDate = "{{ $date }}";
          var exName = "{{ $operationName }}";
          var _token = "{{ csrf_token() }}";
         
          var exData = <?php echo json_encode($groupData); ?>;
         


          jQuery.ajax({
                url:"{{ route('test.dataaa') }}",
                type: 'POST',
                data: { _token:_token, exDate:exDate, exName: exName, exData:exData },

                success: function( data ){

                    const url = window.URL.createObjectURL(new Blob([data.data]));
                    const link = document.createElement('a');
                    link.setAttribute('download', 'file.pdf');
                    document.body.appendChild(link);
                    link.click();
                },
                error: function (xhr, b, c) {
                    console.log("xhr=" + xhr + " b=" + b + " c=" + c);
                }
            });

        

        });

      });
     


  </script>
    
@endsection


@section('content')

    
<section class="header9 cid-ruv4FB75N7 mbr-fullscreen mbr-parallax-background" id="header9-1">

    <div class="mbr-overlay" style="opacity: 0.6; background-color: rgb(118, 118, 118);"></div>

    <div class="container">

        
        <div class="bg-light mt-5">
            <h4> <span class="badge badge-pill badge-info mt-2 ml-2">Invoice SMS Information</span>
                <a href="{{ route('user.sms.export.excel.inv',[ 'date'=>$date, 'code'=>$code, 'operationName'=>$operationName]) }}">
                    <button class="btn btn-info float-right btn-sm"
                    >Excel Export <i class="fa fa-file-excel-o" aria-hidden="true"></i></button>
                </a>

            </h4>

            <div >
                <div class="table-responsive">
                    <table class="table table-striped table-bordered alt-pagination">
                        <thead>
                            <tr class="text-center">
                                <th>Vendor</th>
                                <th>Contact</th>
                                <th>Operation</th>
                                <th>Message</th> 
                            </tr>
                        </thead>
                        <tbody>
    
                           
                            @foreach ($groupData as $value)
                            <tr>
                                <td> {{ $value[0]->CV_NAME }} </td>
                                <td> {{ $value[0]->SMS_NO }} </td>
                                <td> {{ $value[0]->OPERATION_NAME }} </td>
                                
    
                                <td>
                                    @php
                                        $sum_tot_Price = 0; 
                                    @endphp
    
                                    @foreach ($value as $row2)
    
                                        @php
                                            $sum_tot_Price += $row2->AMOUNT
                                        @endphp
    
                                    @endforeach
    
                                    Thank you for CPB Product Order {{ $sum_tot_Price}} Tk. on {{ $value[0]->INVOICE_DATE }} <br>
    
                                    @foreach ($value as $row)
    
                                        CV.{{ $row->CV_CODE }} Inv.{{ $row->INVOICE_NO }} = {{ $row->AMOUNT }} Tk.,<br>
    
                                    @endforeach
    
                                    Thank you one more time.
                                </td>
    
    
                            </tr>
                            @endforeach
    
    
                        </tbody>
    
                    </table>
                </div>
            </div>

        </div>
   
     
    </div>
    
    


    
</section>

@endsection

