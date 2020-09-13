@extends('admin.layout.master')


@section('page-js')

<script src="{{ asset('admin/app-assets/vendors/js/chartist.min.js') }}" type="text/javascript"></script>
{{-- line chart widget --}}
<script src="{{ asset('admin/app-assets/custom/dashboard-widget.min.js') }}" type="text/javascript"></script>

@endsection

@section('content')
<!-- BEGIN : Main Content-->

        <div class="row">
            <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                <div class="card gradient-blackberry">
                    <div class="card-content">
                        <div class="card-body pt-2 pb-0">
                            <div class="media">
                                <div class="media-body white text-left">
                                    <h3 class="font-large-1 mb-0">{{ $TotalAdmin }}</h3>
                                    <span>Total Admin</span>
                                </div>
                                <div class="media-right white text-right">
                                    <i class="fa fa-grav font-large-1"></i>
                                </div>
                            </div>
                        </div>
                        <div id="Widget-line-chart" class="height-75 WidgetlineChart WidgetlineChartshadow mb-2">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                <div class="card gradient-ibiza-sunset">
                    <div class="card-content">
                        <div class="card-body pt-2 pb-0">
                            <div class="media">
                                <div class="media-body white text-left">
                                    <h3 class="font-large-1 mb-0">{{ $TotalUser }}</h3>
                                    <span>Total User</span>
                                </div>
                                <div class="media-right white text-right">
                                    <i class="fa fa-users font-large-1"></i>
                                </div>
                            </div>
                        </div>
                        <div id="Widget-line-chart1" class="height-75 WidgetlineChart WidgetlineChartshadow mb-2">
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                <div class="card gradient-green-tea">
                    <div class="card-content">
                        <div class="card-body pt-2 pb-0">
                            <div class="media">
                                <div class="media-body white text-left">
                                    <h3 class="font-large-1 mb-0">{{ $TotalRoom }}</h3>
                                    <span>Total Room</span>
                                </div>
                                <div class="media-right white text-right">
                                    <i class="fa fa-home font-large-1"></i>
                                </div>
                            </div>
                        </div>
                        <div id="Widget-line-chart2" class="height-75 WidgetlineChart WidgetlineChartshadow mb-2">
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                <div class="card gradient-pomegranate">
                    <div class="card-content">
                        <div class="card-body pt-2 pb-0">
                            <div class="media">
                                <div class="media-body white text-left">
                                    <h3 class="font-large-1 mb-0">{{ $TotalCar }}</h3>
                                    <span>Total Car</span>
                                </div>
                                <div class="media-right white text-right">
                                    <i class="fa fa-car font-large-1"></i>
                                </div>
                            </div>
                        </div>
                        <div id="Widget-line-chart3" class="height-75 WidgetlineChart WidgetlineChartshadow mb-2">
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="row">
            <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                <div class="card gradient-purple-bliss">
                    <div class="card-content">
                        <div class="card-body pt-2 pb-0">
                            <div class="media">
                                <div class="media-body white text-left">
                                    <h3 class="font-large-1 mb-0">{{ $totalComplainApp }}</h3>
                                    <span>Total App Complain</span>
                                </div>
                                <div class="media-right white text-right">
                                    <i class="fa fa-balance-scale font-large-1"></i>
                                </div>
                            </div>
                        </div>
                        <div id="Widget-line-chart4" class="height-75 WidgetlineChart WidgetlineChartshadow mb-2">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                <div class="card gradient-mint">
                    <div class="card-content">
                        <div class="card-body pt-2 pb-0">
                            <div class="media">
                                <div class="media-body white text-left">
                                    <h3 class="font-large-1 mb-0">{{ $PendingApp }}</h3>
                                    <span>Pending App. Comp.</span>
                                </div>
                                <div class="media-right white text-right">
                                    <i class="fa fa-laptop font-large-1"></i>
                                </div>
                            </div>
                        </div>
                        <div id="Widget-line-chart5" class="height-75 WidgetlineChart WidgetlineChartshadow mb-2">
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                <div class="card gradient-nepal">
                    <div class="card-content">
                        <div class="card-body pt-2 pb-0">
                            <div class="media">
                                <div class="media-body white text-left">
                                    <h3 class="font-large-1 mb-0">{{ $pandingHard }}</h3>
                                    <span>Pending Hard. Comp.</span>
                                </div>
                                <div class="media-right white text-right">
                                    <i class="ft-inbox font-large-1"></i>
                                </div>
                            </div>
                        </div>
                        <div id="Widget-line-chart6" class="height-75 WidgetlineChart WidgetlineChartshadow mb-2">
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                <div class="card gradient-crystal-clear">
                    <div class="card-content">
                        <div class="card-body pt-2 pb-0">
                            <div class="media">
                                <div class="media-body white text-left">
                                    <h3 class="font-large-1 mb-0">{{ $pandingDelivery }}</h3>
                                    <span>Pending Delivery</span>
                                </div>
                                <div class="media-right white text-right">
                                    <i class="icon-share-alt font-large-1"></i>
                                </div>
                            </div>
                        </div>
                        <div id="Widget-line-chart7" class="height-75 WidgetlineChart WidgetlineChartshadow mb-2">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Statistics cards Ends-->


<!-- END : End Main Content-->


@endsection



