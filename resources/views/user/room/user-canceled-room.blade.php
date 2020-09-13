@extends('user.layout.room-master')


@section('content')


<!--== Page Title Area Start ==-->
<section id="page-title-area" class="section-padding overlay">
    <div class="container">
        <div class="row">
            <!-- Page Title Start -->
            <div class="col-lg-12">
                <div class="section-title text-center">
                    <h2>{{ session()->get('user.name') }}'s Canceled Room</h2>
                    <span class="title-line"><i class="fa fa-home"></i></span>
                </div>
            </div>
            <!-- Page Title End -->
        </div>
    </div>
</section>
<!--== Page Title Area End ==-->

<!--== FAQ Area Start ==-->
<section id="faq-page-area" class="section-padding">
    <div class="container">

        @foreach ($allData as $row)
        <div class="row mb-3">
            <!-- Single Articles Start -->
            <div class="col-lg-12">
                <article class="single-article">
                    <div class="row">
                        <!-- Articles Thumbnail Start -->
                        <div class="col-lg-5">
                            <div class="article-thumb">
                                <a href="{{ route('user.room.details',$row->roomId) }}"> <img src="{{ asset($row->image) }}" class="mx-auto d-block"
                                        alt="Image" /></a>
                            </div>
                        </div>
                        <!-- Articles Thumbnail End -->

                        <!-- Articles Content Start -->
                        <div class="col-lg-7">
                            <div class="display-table">
                                <div class="display-table-cell">
                                    <div class="article-body">
                                        <h6>
                                            <a href="{{ route('user.room.details',$row->roomId) }}">{{ $row->name }}</a>
                                            <span class="bookedInfo">Booked: {{ $row->hours }} Hours
                                            </span>
                                        </h6>



                                        <ul class="car-info-list">
                                            <li>Purpose :<b> {{ $row->purpose }}</b></li>
                                        </ul>
                                        <ul class="car-info-list">
                                            <li>{{ date("j-F-Y, g:i A", strtotime($row->start)) }} <b>-- To -- </b>
                                                {{ date("j-F-Y, g:i A", strtotime($row->end)) }}
                                            </li>
                                        </ul>
                                        <div class="text-center">
                                            <span class="bg-danger text-white pr-1 pl-1 h4 mr-2">Canceled At :</span>
                                            <span class="bg-danger text-white pr-1 pl-1 h4 text-capitalize" > {{ date("j-F-Y, g:i A", strtotime($row->updated_at)) }}</span>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Articles Content End -->
                    </div>
                </article>
            </div>
            <!-- Single Articles End -->

        </div>
        @endforeach

    </div>
</section>
<!--== FAQ Area End ==-->



@endsection
