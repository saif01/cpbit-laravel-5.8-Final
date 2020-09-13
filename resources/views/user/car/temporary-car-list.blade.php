@extends('user.layout.car-master')


@section('content')

@php
use \App\Http\Controllers\CheckStForCarpool;
$checkStatus = new CheckStForCarpool();
@endphp

<!--== Page Title Area Start ==-->
<section id="page-title-area" class="section-padding overlay">
    <div class="container">
        <div class="row">
            <!-- Page Title Start -->
            <div class="col-lg-12">
                <div class="section-title  text-center">
                    <h2>Our Temporary Car's..</h2>
                    <span class="title-line"><i class="fa fa-car"></i></span>
                </div>
            </div>
            <!-- Page Title End -->
        </div>
    </div>
</section>
<!--== Page Title Area End ==-->

<!--== Car List Area Start ==-->
<div id="blog-page-content" class="section-padding">
    <div class="container">
        <div class="row">

            @foreach ($allData as $data)
            @php
            // Driver Personal Leave
            $drverLeave = $checkStatus->CheckDriverLeave($data->carId, $data->driverId);
            // Car Maintance data
            $carMaintance = $checkStatus->CheckCarMaintance($data->carId, $data->driverId);
            // Police Reqisition data
            $carRequisition = $checkStatus->CheckCarRequisition($data->carId, $data->driverId);
            //Check current Time Car booked Or Not
            $currentTimeBooking = $checkStatus->CheckCurrentTimeBookingHaveOrNot($data->carId);
            //Check current Time Car booked Or Not
            $currentTimeDriverLeave = $checkStatus->CheckCurrentTimeDriverLeave($data->carId);
            //Check current Time Car Maintance
            $currentTimeCarMaintance = $checkStatus->CheckCurrentTimeCarMaintance($data->carId);
            //Check current Time Car booked Or Not
            $currentTimeCarRequisition = $checkStatus->CheckCurrentTimeCarRequisition($data->carId);
            @endphp

            <!-- Single Articles Start -->
            <div class="col-lg-12">
                <article class="single-article">
                    <div class="row">
                        <!-- Articles Thumbnail Start -->
                        <div class="col-lg-5">
                            <div class="article-thumb">
                                <a href="{{ route('user.car.details',[$data->carId]) }}"> <img src="{{ asset($data->image) }}"
                                        class="img-responsive car-pic" alt="Image" /></a>
                            </div>
                        </div>
                        <!-- Articles Thumbnail End -->

                        <!-- Articles Content Start -->
                        <div class="col-lg-5">
                            <div class="display-table">
                                <div class="display-table-cell">
                                    <div class="article-body">
                                        <div class="article-date">
                                            @if ($currentTimeBooking > 0)
                                            <span class="text-capitalize text-danger">Booked</span>
                                            @elseif( $currentTimeDriverLeave >0 || $currentTimeCarMaintance >0 ||
                                            $currentTimeCarRequisition >0 )
                                            <span class="text-capitalize text-danger">Busy</span>
                                            @else
                                            <span class="text-capitalize text-white">Free</span>
                                            @endif
                                        </div>
                                        <div class="text-center">
                                            <table class="table">
                                                {{-- Driver leave Status Check--}}
                                                @if ($drverLeave)
                                                <span class="bg-warning text-capitalize pl-1 pr-1 h6">Driver Leave :
                                                    {{ date("M j, Y", strtotime($drverLeave->start))  }} <b class="text-dark">To</b> {{ date("M j, Y", strtotime($drverLeave->end))  }}</span>

                                                {{-- Car Maintence Status Check--}}
                                                @elseif($carMaintance)
                                                <span
                                                    class="bg-info text-capitalize text-white pl-1 pr-1 h6">Maintenance
                                                    : {{ date("M j, Y", strtotime($carMaintance->start))  }}
                                                    <b class="text-dark">To</b> {{ date("M j, Y", strtotime($carMaintance->end)) }}</span>

                                                {{-- Car Requisition Status Check--}}
                                                @elseif($carRequisition)
                                                <span
                                                    class="bg-primary text-capitalize text-white pl-1 pr-1 h6">Requisition
                                                    : {{ date("M j, Y", strtotime($carRequisition->start)) }} <b class="text-dark">To</b> {{ date("M j, Y", strtotime($carRequisition->end)) }}</span>
                                                @endif

                                                <tr>
                                                    <th>Name :</th>
                                                    <td>{{ $data->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Car Number :</th>
                                                    <td>{{ $data->number }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Capacity :</th>
                                                    <td>{{ $data->capacity }}</td>
                                                </tr>
                                            </table>

                                            <a href="{{ route('temporary.car.booking',[$data->carId]) }}"
                                                class="readmore-btn">Book <i class="far fa-arrow-alt-circle-right"></i></a>

                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Articles Content End -->
                        <!--  Driver Section Start -->
                        <div class="col-lg-2">

                            <div class="article-thumb-s">
                                <a href="{{ route('driver.profile',$data->driverId) }}"> <img src="{{ asset($data->driverImage) }}"
                                        class="img-responsive mx-auto d-block" alt="Image" /> </a>

                                <p>{{ $data->driverName }}</p>
                                <p><i class="fas fa-mobile-alt"></i> <a href="tel:+88{{ $data->contact }}">
                                        {{ $data->contact }} </a></p>
                            </div>
                        </div>
                        <!--  Driver Section End -->


                    </div>
                </article>
            </div>
            <!-- Single Articles End -->
            @endforeach


        </div>

    </div>
</div>
<!--== Car List Area End ==-->

@endsection
