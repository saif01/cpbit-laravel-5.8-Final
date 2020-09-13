@extends('user.layout.room-master')

@section('content')

<!--== Page Title Area Start ==-->
<section id="page-title-area" class="section-padding overlay">
    <div class="container">
        <div class="row">
            <!-- Page Title Start -->
            <div class="col-lg-12">
                <div class="section-title  text-center">
                    <h2>Our Meeting Rooms</h2>
                    <span class="title-line"><i class="fa fa-home"></i></span>
                </div>
            </div>
            <!-- Page Title End -->
        </div>
    </div>
</section>
<!--== Page Title Area End ==-->

<!--== Car List Area Start ==-->
<section id="car-list-area" class="section-padding">
    <div class="container">
        <div class="row">

            <!-- Car List Content Start -->
            <div class="col-lg-12">
                <div class="car-list-content">
                    <div class="row">

                        @foreach ($allData as $row)


                        <!-- Single Car Start -->
                        <div class="col-lg-6 col-md-6">
                            <div class="single-car-wrap">
                                <div class="car-list-thumb">
                                    <a href="{{ route('user.room.details',$row->id) }}">
                                        <img src="{{ asset($row->image) }}"
                                            class="img-responsive" style="height: 300px; width: 100%;" alt="Image"></a>
                                </div>

                                <div class="booking_st">


                                </div>
                                <div class="car-list-info without-bar text-center">
                                    <h2><a href="{{ route('user.room.details',$row->id) }}">{{ $row->name }}</a></h2>


                                    <ul class="car-info-list">
                                        <li>Room Capacity</li>
                                        <li> <b>{{ $row->capacity }}</b> Persons</li>
                                    </ul>

                                    <a href="{{ route('user.meeting.room.booking', $row->id) }}" class="rent-btn">Book It <i class="far fa-arrow-alt-circle-right"></i></a>
                                </div>
                            </div>
                        </div>


                @endforeach

                    </div>
                </div>

            </div>
            <!-- Car List Content End -->
        </div>
    </div>
</section>
<!--== Car List Area End ==-->

@endsection
