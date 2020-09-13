@extends('admin.layout.it-connect-master')
{{-- Page CSS --}}
@section('page-css')
{{-- Data table css --}}
<link rel="stylesheet" type="text/css"
    href="{{ asset('admin/app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
@endsection
{{-- Page Js --}}
@section('page-js')
{{-- Data table js --}}
<script src="{{ asset('admin/app-assets/vendors/js/datatable/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('admin/app-assets/js/data-tables/datatable-basic.js') }}" type="text/javascript"></script>
<!-- Modal Show-->
<script src="{{ asset('admin/app-assets/js/components-modal.min.js') }}" type="text/javascript"></script>

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
                    <h4 class="card-title">Seles Order Reports
                        <a href="{{ route('it.connect.export.excel.sale.order',[ 'date'=>$date, 'opCode'=>$opCode, 'operationName'=>$operationName]) }}">
                            <button class="btn gradient-nepal white big-shadow float-right"
                               >Excel Export <i class="fa fa-file-excel-o" aria-hidden="true"></i></button>
                        </a>
                    </h4>

                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard table-responsive">
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
    </div>
</section>
<!--/ Alternative pagination table -->


@endsection
