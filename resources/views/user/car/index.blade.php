@extends('user.layout.car-master')

@section('page-css')
<!--=== Vegas Min CSS ===-->
<link href="{{ asset('user/assets/css/plugins/vegas.min.css') }}" rel="stylesheet">
<!-- Text Animated CSS -->
<link href="{{ asset('user/assets/coustom/animate.css') }}" rel="stylesheet">
@endsection

@section('page-js')
<!--=== Vegas Min Js ===-->
<script src="{{ asset('user/assets/js/plugins/vegas.min.js') }}"></script>
<script>
        $("#slideslow-bg").vegas({
            overlay: true,
            transition: 'fade',
            transitionDuration: 2000,
            delay: 4000,
            color: '#000',
            animation: 'random',
            animationDuration: 20000,
            slides: [{
                    src: "{{ asset('user/assets/img/slider-img/slider-img-1.jpg') }}"
                },
                {
                    src: "{{ asset('user/assets/img/slider-img/slider-img-2.jpg') }}"
                },
                {
                    src: "{{ asset('user/assets/img/slider-img/slider-img-3.jpg') }}"
                },
                {
                    src: "{{ asset('user/assets/img/slider-img/slider-img-4.jpg') }}"
                }
            ]
        });
</script>
@endsection

@section('content')
    <!--== SlideshowBg Area Start ==-->
    <section id="slideslow-bg" >
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="slideshowcontent">
                        <div class="display-table">
                            <div class="display-table-cell">
                                <a href="{{ route('regular.car.list') }}">
                                    <h1 class="animated infinite bounce delay-2s">BOOK A CAR!</h1>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--== SlideshowBg Area End ==-->
@endsection

