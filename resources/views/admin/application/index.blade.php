@extends('admin.layout.app-master')

@section('page-css')
<link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/chartist.min.css') }}">
@endsection

@section('page-js')

<script src="{{ asset('admin/app-assets/vendors/js/chart.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('admin/app-assets/vendors/js/chartist.min.js') }}" type="text/javascript"></script>
{{-- line chart widget --}}
<script src="{{ asset('admin/app-assets/custom/dashboard-widget.min.js') }}" type="text/javascript"></script>


<script>
    (function(){
        $(window).on("load", function () {
        var ctx = $("#simple-pie-chart");
        var chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        responsiveAnimationDuration: 500,
        };
        var chartData = {
        labels: [
        <?php foreach ($chartData as $level ){ echo '"' . $level->process . '"' . ','; } ?>
        ],
        datasets: [{
        label: "My First dataset",
        data: [
        <?php foreach ($chartData as $data ){ echo '"' . $data->total . '"' . ','; } ?>
        ],
        backgroundColor: ['#16D39A', '#FF7D4D', '#FF4558', '#795548', '#FF6D00', '#263238', '#FFAB00', '#388E3C', '#1DE9B6',
        '#536DFE', '#FF4081', '#868e96', '#FF4558', '#795548', '#FF6D00', '#263238', '#16D39A', '#FF7D4D', '#FF4558', '#795548',
        '#FF6D00', '#263238', '#FFAB00', '#388E3C', '#1DE9B6', '#536DFE'],
        }]
        };
        var config = {
        type: 'pie',
        options: chartOptions,
        data: chartData
        };
        var pieSimpleChart = new Chart(ctx, config);

        });
    })(jQuery);


</script>



@endsection

@section('content')
   <div class="row">
            <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                <div class="card gradient-blackberry">
                    <div class="card-content">
                        <div class="card-body pt-2 pb-0">
                            <div class="media">
                                <div class="media-body white text-left">
                                    <h3 class="font-large-1 mb-0">{{ $cmsUser }}</h3>
                                    <span>Total CMS User</span>
                                </div>
                                <div class="media-right white text-right">
                                    <i class="fa fa-users font-large-1"></i>
                                </div>
                            </div>
                        </div>
                        <div id="Widget-line-chart" class="height-75 WidgetlineChart WidgetlineChartshadow mb-2">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                <div class="card gradient-ibiza-sunset">
                    <div class="card-content">
                        <div class="card-body pt-2 pb-0">
                            <div class="media">
                                <div class="media-body white text-left">
                                    <h3 class="font-large-1 mb-0">{{ $totalComplain }}</h3>
                                    <span>Total Complains</span>
                                </div>
                                <div class="media-right white text-right">
                                    <i class="icon-notebook font-large-1"></i>
                                </div>
                            </div>
                        </div>
                        <div id="Widget-line-chart1" class="height-75 WidgetlineChart WidgetlineChartshadow mb-2">
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                <div class="card gradient-green-tea">
                    <div class="card-content">
                        <div class="card-body pt-2 pb-0">
                            <div class="media">
                                <div class="media-body white text-left">
                                    <h3 class="font-large-1 mb-0">{{ $notClosed }}</h3>
                                    <span>Pending Complains</span>
                                </div>
                                <div class="media-right white text-right">
                                    <i class="ft-inbox font-large-1"></i>
                                </div>
                            </div>
                        </div>
                        <div id="Widget-line-chart2" class="height-75 WidgetlineChart WidgetlineChartshadow mb-2">
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Pie Chart -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Complain Process Chart</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body chartjs">
                            <canvas id="simple-pie-chart" height="400"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
