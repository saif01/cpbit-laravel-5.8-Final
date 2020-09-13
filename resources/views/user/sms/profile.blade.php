@extends('user.layout.sms-master')


@section('content')


    
<section class="header9 cid-ruv4FB75N7 mbr-fullscreen mbr-parallax-background" id="header9-1">

    
    <div class="mbr-overlay" style="opacity: 0.6; background-color: rgb(118, 118, 118);"></div>

    <div class="container">

        <div class="row col-md-12">

            <div class="col-md-8 mbr-section-title">
                <ul class="list-group">
                    <li class="list-group-item mbr-fonts-style"> <h2>{{ session()->get('user.name') }}'s Profile Info.</h2></li>
                    <li class="list-group-item">ID: {{ session()->get('user.login') }}</li>
                    <li class="list-group-item"> Full Name : {{ session()->get('user.name') }} </li>
                    <li class="list-group-item"> Department : {{ session()->get('user.department') }} </li>
                    <li class="list-group-item"> Contract Number : {{ session()->get('user.contact') }} </li>
                    <li class="list-group-item"> Office ID : {{ session()->get('user.office_id') }} </li>
                    <li class="list-group-item"> Email ID : {{ session()->get('user.email') }} </li>
                  </ul>
            </div>
            <div class="col-md-4 text-center mt-4">
                
              <img src="{{ asset(session()->get('user.image')) }}"
              class="img-responsive img-thumbnail rounded" alt="Image" style=" border: 4px solid #1E90FF;" />
            </div>
        </div>
      

    </div>
    
    


    
</section>

@endsection

