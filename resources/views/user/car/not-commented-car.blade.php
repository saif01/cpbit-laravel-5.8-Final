@extends('user.layout.car-master')



@section('page-js')

<!-- Comment Data Put JS Functions -->
@include('user.car.modal-put-comment-functions')

@endsection

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
                    <h2>{{ session()->get('user.name') }}'s Not Commented Car</h2>
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

         @if ($errors->any())
            <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
              <p class="text-dark"><strong>Whoops!</strong> There were some problems with your input.</p>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @foreach ($allData as $row)
        <div class="row mb-3">
            <!-- Single Articles Start -->
            <div class="col-lg-12">
                <article class="single-article">
                    <div class="row">
                        <!-- Articles Thumbnail Start -->
                        <div class="col-lg-5">
                            <div class="article-thumb">
                                <a href="{{ route('user.car.details',[$row->carId]) }}"> <img src="{{ asset($row->image) }}" class="mx-auto d-block"
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
                                            <a href="">{{ $row->name }} --: {{ $row->number }}</a>
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

                                            <a href="javascript:void(0);" id="{{ $row->id }}" class="readmore-btn bookingComment">Comment</a>

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

<!-- Comment Data Put Modal -->
@include('user.car.modal-put-comment')

@endsection
