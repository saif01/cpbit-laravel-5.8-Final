@extends('user.layout.room-master')

@section('page-css')
<!--=== Owl Carousel CSS ===-->
<link href="{{ asset('user/assets/css/plugins/owl.carousel.min.css') }}" rel="stylesheet">
@endsection

@section('page-js')
<!--=== Owl Caousel Min Js ===-->
<script src="{{ asset('user/assets/js/plugins/owl.carousel.min.js') }}"></script>

<script>
    $(".car-preview-crousel").owlCarousel({
loop: true,
items: 1,
autoplay: true,
autoplayHoverPause: true,
autoplayTimeout: 1000,
nav: false,
dots: true,
animateOut: 'fadeOut',
animateIn: 'fadeIn'
});
</script>

@endsection

@section('content')

<!--== Page Title Area Start ==-->
<section id="page-title-area" class="section-padding overlay">
    <div class="container">
        <div class="row">
            <!-- Page Title Start -->
            <div class="col-lg-12">
                <div class="section-title  text-center">
                    <h2>Room Details..</h2>
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
            <div class="col-lg-8">
                <div class="car-details-content">
                    <h2> {{ $allData->name }}</h2>
                    <div class="car-preview-crousel">

                        <div class="single-car-preview">
                            <img src="{{ asset( $allData->image ) }}" alt="Image" />
                        </div>
                        <div class="single-car-preview">
                            <img src="{{ asset( $allData->image2 ) }}" alt="Image" />
                        </div>
                        <div class="single-car-preview">
                            <img src="{{ asset( $allData->image3 ) }}" alt="Image" />
                        </div>

                    </div>
                    <div class="car-details-info">
                        <h4>Additional Info.</h4>
                        <p class="text-dark">{{ $allData->remarks }}.</p>
                    </div>
                </div>
            </div>
            <!-- Car List Content End -->

            <!-- Sidebar Area Start -->
            <div class="col-lg-4">
                <div class="sidebar-content-wrap m-t-50">
                    <!-- Single Sidebar Start -->
                    <div class="single-sidebar">
                        <h3>Room Update Information</h3>

                        <div class="sidebar-body">

                            <p><i class="fa fa-clock-o"></i>Reg. Date :
                                {{  date("F j, Y", strtotime($allData->created_at))  }} </p>
                            <p><i class="fa fa-clock-o"></i>Last Update:
                                {{  date("F j, Y", strtotime($allData->updated_at))  }} </p>
                        </div>
                    </div>
                    <!-- Single Sidebar End -->
                    <!-- Single Sidebar Start -->
                    <div class="single-sidebar">
                        <h3>Room Information</h3>

                        <div class="sidebar-body">

                            <table class="table table-bordered text-center">
                                <tr>
                                    <th>Aircondition</th>
                                    <td><i class="fa fa-check-circle"></i></td>
                                </tr>
                                <tr>
                                    <th>Projector</th>
                                    <td>@if ($allData->projector == 1)
                                        <i class="fa fa-check-circle"></i>
                                        @else
                                        No
                                    @endif
                                </td>
                                </tr>
                                <tr>
                                    <th>Capacity</th>
                                    <td>{{ $allData->capacity }}</td>
                                </tr>
                            </table>

                        </div>
                    </div>
                    <!-- Single Sidebar End -->

                </div>
            </div>
            <!-- Sidebar Area End -->


        </div>
    </div>
</section>
<!--== Car List Area End ==-->

@endsection
