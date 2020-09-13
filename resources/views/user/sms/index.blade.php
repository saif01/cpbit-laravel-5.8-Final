@extends('user.layout.sms-master')


@section('page-js')
    {{-- Deat Piker --}}
    @include('admin.layout.datePiker.datePiker')
    
@endsection


@section('content')


    
<section class="header9 cid-ruv4FB75N7 mbr-fullscreen mbr-parallax-background" id="header9-1">

    <div class="mbr-overlay" style="opacity: 0.6; background-color: rgb(118, 118, 118);"></div>

    <div class="container">

        <div>

        <form method="post" action="{{ route('user.sms.report') }}" >
              @csrf
                <div class="form-row text-center mbr-white">
                  <div class="form-group col-md-4">
                    <label for="inputCity">Report Generate Date</label>
                    <input type="text" class="form-control" id="datepicker" name="date"
                    placeholder="Enter Report Date ( DD/MM/YYYY )" required="required" >
                  </div>

                  <div class="form-group col-md-4">
                    <label for="inputState">Operation Name</label>
                    <select id="inputState" class="form-control" name="code" required="required" >
                      <option value="" selected>Choose Operation</option>
                        @foreach ($opprationData as $operation)
                          <option value="{{ $operation->code }}">{{ $operation->name }}</option>
                        @endforeach
                    </select>
                  </div>

                  <div class="form-group col-md-4">
                    <label for="inputState2">SMS Type</label>
                    <select id="inputState2" class="form-control" name="type" required="required">
                      <option value="" selected>Choose SMS Type</option>
                      <option value="invoice" >Sales Order</option>
                      <option value="recept" >Sales Payment</option>
                    </select>
                  </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Find Report</button>
                </div>
               
               
              </form>

        </div>


        
       
         
        {{-- <div class="media-container-column mbr-white col-lg-8 col-md-10">
            <h1 class="mbr-section-title align-left mbr-bold pb-3 mbr-fonts-style display-1">Boostrap menu</h1>
            
            <p class="mbr-text align-left pb-3 mbr-fonts-style display-5">
                Click any text to edit or style it. Select text to insert a link. Click blue "Gear" icon in the top right corner to hide/show buttons, text, title and change the block background. Click red "+" in the bottom right corner to add a new block. Use the top left menu to create new pages, sites and add themes.
            </p>
            <div class="mbr-section-btn align-left"><a class="btn btn-md btn-primary display-4" href="https://mobirise.co">LEARN MORE</a></div>
        </div> --}}
    </div>
    
    


    
</section>

@endsection

