


<h1>Test Page</h1>

<form method="post" >

    @foreach ($data2 as $item)
    <input type="checkbox" name="tools[]" value="{{ $item->code }}"> {{ $item->name }}
    @endforeach

    
   
                        

</form>

{{-- //All Tools
        $toolsall = $request->tools;
        $tools = implode(",", $toolsall); --}}



<hr>

<table>

<thead>
    <tr>
        <th>User Name</th>
        <th>Code</th>
    </tr>
</thead>
<tbody>

@foreach ($allUser as $user)
    <tr>
    <td>{{ $user->name . $user->id }}</td>
    <td>

        @php
            foreach( $data  as $sms ){

                $id = $sms->user_id;

                if($user->id == $id ){
                    echo $id;
                    $smsCode = $sms->access;

                    $arrayData = explode(",", $smsCode);

                    foreach($arrayData as $arr  ){
                         

                         foreach( $data2 as $codeDat ){
                            $id = $codeDat->id;

                            if( $id == $arr){

                             echo   $codeDat->name;
                            }
                            
                         }


                    }

               


                }
            }
        @endphp



    </td>
    </tr>


@endforeach

</tbody>


</table>















{{-- <table class="table table-striped table-bordered file-export">
    <thead>
        <tr class="text-center">
            <th>Number</th>
            <th>Message</th> 
        </tr>
    </thead>
    <tbody>
        @foreach ($groupData as $value)
        <tr>
           
            <td>  {{ $value[0]->SMS_NO }} </td>

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

</table> --}}