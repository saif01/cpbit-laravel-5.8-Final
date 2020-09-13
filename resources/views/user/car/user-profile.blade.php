@extends('user.layout.car-master')


@section('content')

<!--== Page Title Area Start ==-->
<section id="page-title-area" class="section-padding overlay">
    <div class="container">
        <div class="row">
            <!-- Page Title Start -->
            <div class="col-lg-12">
                <div class="section-title text-center">
                    <h2>{{ session()->get('user.name') }}'s Profile Info.</h2>
                    <span class="title-line"><i class="fa fa-car"></i></span>
                </div>
            </div>
            <!-- Page Title End -->
        </div>
    </div>
</section>
<!--== Page Title Area End ==-->

<section id="about-area" class="section-padding">
    <div class="container">
        <div class="row">

        </div>

        <div class="row">
            <!-- About Content Start -->
            <div class="col-lg-8 col-md-12">
                <div class="display-table">
                    <div class="display-table-cell">
                        <div class="about-content ">
                            <ul class="package-list">
                                <li>
                                    <h3>ID : {{ $allData->login }}</h3>
                                </li>
                                <li> Full Name : {{ $allData->login }} </li>
                                <li> Department : {{ $allData->department }} </li>
                                <li> Contract Number : {{ $allData->contact }} </li>
                                <li> Office ID : {{ $allData->office_id }} </li>
                                <li> Email ID : {{ $allData->email }} </li>
                                <li> Office ID : {{ $allData->office_id }} </li>
                                <li> Status :
                                    @if ($allData->status == 1)
                                        Active
                                    @else
                                        Deactive
                                    @endif
                                </li>
                                <li> Access :
                                    @if ($allData->car == 1)
                                    CarPool,
                                    @endif
                                    @if ($allData->room == 1)
                                    Room,
                                    @endif
                                    @if ($allData->law == 1)
                                    Legal,
                                    @endif
                                    @if ($allData->cms == 1)
                                    CMS
                                    @endif


                                </li>
                                <li> </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- About Content End -->

            <!-- About Video Start -->
            <div class="col-lg-4 col-md-12">
                <div class="about-image text-center mt-5">

                    <img src="{{ asset($allData->image) }}"
                        class="img-responsive img-thumbnail rounded" alt="Image" style=" border: 4px solid #ffd000;" />
                </div>
            </div>
            <!-- About Video End -->
        </div>

        <!-- About Fretutes Start -->
        <div class="about-feature-area">
            <div class="row">
                <!-- Single Fretutes Start -->
                <div class="col-lg-12">
                    <div class="about-feature-item active">
                        <i class="fa fa-car"></i>

                    </div>
                </div>
                <!-- Single Fretutes End -->

            </div>
        </div>
        <!-- About Fretutes End -->
    </div>
</section>

@endsection
