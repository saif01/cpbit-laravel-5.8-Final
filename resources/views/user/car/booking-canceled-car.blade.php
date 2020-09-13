@extends('user.layout.car-master')


@section('content')

@php
//Day Or houre Calculaate
function DayOrHoure($startTime, $endTime)
{
$ts1 = strtotime($startTime);
$ts2 = strtotime($endTime);
$seconds = abs($ts2 - $ts1); # difference will always be positive
$days = round($seconds / (60 * 60 * 24));
if ($days >= 1) {
return $days . " Days";
} else {
return round($seconds / (60 * 60)) . " Hours";
}
}
@endphp

<!--== Page Title Area Start ==-->
<section id="page-title-area" class="section-padding overlay">
    <div class="container">
        <div class="row">
            <!-- Page Title Start -->
            <div class="col-lg-12">
                <div class="section-title text-center">
                    <h2>{{ session()->get('user.name') }}'s Canceled Car</h2>
                    <span class="title-line"><i class="fa fa-car"></i></span>
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
                                <a href="{{ route('user.car.details',$row->id) }}"> <img src="{{ asset($row->image) }}" class="mx-auto d-block"
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
                                            <a href="{{ route('user.car.details',$row->id) }}">{{ $row->name }} --: {{ $row->number }}</a>
                                            <!-- Only show when comment complte -->
                                            <!-- Booked time calculate -->
                                            <span class="bookedInfo">Booked: {{ DayOrHoure( $row->start,$row->end ) }}
                                            </span>
                                        </h6>


                                        <ul class="car-info-list">
                                            <li> Destination :<b> {{ $row->destination }}</b></li>
                                        </ul>
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
                                            <span class="bg-danger text-white pr-1 pl-1 h4 text-capitalize">
                                                {{ date("j-F-Y, g:i A", strtotime($row->updated_at)) }}</span>
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
