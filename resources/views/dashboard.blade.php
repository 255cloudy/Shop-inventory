
@extends('layout.base')
@section('main-content')
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>KES {{ $sales_today }}</h3>
                    <p>Sales Today</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>KES {{ $sales_this_month }}<sup style="font-size: 20px"></sup></h3>

                    <p>Sales this Month</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $best_day }}</h3>

                    <p>Best Day of the Week(This Month)</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h4>Best Seller (This month): {{ $best_product }} </h4>
                    <p>Sales this month: KES {{ $best_product_sales }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Sales in cash</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                        <canvas id="barChartCash" style="min-height: 250px; height: 500px; max-height: 1000px; max-width: 100%; display: block; width: 360px;" width="360" height="250" class="chartjs-render-monitor"></canvas>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
{{--        </div>  <div class="col-lg-6">--}}
{{--            <div class="card card-success">--}}
{{--                <div class="card-header">--}}
{{--                    <h3 class="card-title">Sales pcs </h3>--}}

{{--                    <div class="card-tools">--}}
{{--                        <button type="button" class="btn btn-tool" data-card-widget="collapse">--}}
{{--                            <i class="fas fa-minus"></i>--}}
{{--                        </button>--}}
{{--                        <button type="button" class="btn btn-tool" data-card-widget="remove">--}}
{{--                            <i class="fas fa-times"></i>--}}
{{--                        </button>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="card-body">--}}
{{--                    <div class="chart"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>--}}
{{--                        <canvas id="barChartPcs" style="min-height: 250px; height: 500px; max-height: 1000px; max-width: 100%; display: block; width: 360px;" width="360" height="250" class="chartjs-render-monitor"></canvas>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <!-- /.card-body -->--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
    <!-- /.row -->
@endsection
@section("extra-js")
    <script>
        const barChartCanvasCash = $('#barChartCash').get(0).getContext('2d');
        const dataCash = new Array();
        const dataPcs = new Array();
        const jsonData = @json($sales_pcs);
        console.log(Object.values(@json($sales_pcs)));
        // const barChartCanvasPcs = $('#barChartPcs').get(0).getContext('2d');
        let barChartDataCash = {
            labels  : ['Jan', 'Feb', 'Mar', 'April', 'May', 'June', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [
                {
                    label               : 'Sales Cash %',
                    backgroundColor     : 'rgba(60,141,188,0.9)',
                    borderColor         : 'rgba(60,141,188,0.8)',
                    pointRadius          : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(60, 171, 108)',
                    pointHighlightFill  : '#fff',

                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data                : Object.values(@json($sales_cash),
                },
                {
                    label               : 'Sales Pcs %',
                    backgroundColor     : 'rgba(210, 214, 222, 1),
                    borderColor         : 'rgba(210, 214, 222, 1)',
                    pointRadius         : false,
                    pointColor          : 'rgba(210, 214, 222, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',
                    data                : Object.values(@json($sales_pcs))
                },

            ]
        }
        let barChartOptions = {
            responsive              : true,
            maintainAspectRatio     : false,
            datasetFill             : false
        }
        let chart = new Chart(barChartCanvasCash, {
            type: 'bar',
            data: barChartDataCash,
            options: barChartOptions
        })
        console.log(chart);
        {{--let barChartDataPcs = {--}}
        {{--    labels  : ['Jan', 'Feb', 'Mar', 'April', 'May', 'June', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],--}}
        {{--    datasets: [--}}
        {{--        {--}}
        {{--            label               : 'Sales Pcs %',--}}
        {{--            backgroundColor     : 'rgba(210, 214, 222, 1)',--}}
        {{--            borderColor         : 'rgba(210, 214, 222, 1)',--}}
        {{--            pointRadius         : false,--}}
        {{--            pointColor          : 'rgba(210, 214, 222, 1)',--}}
        {{--            pointStrokeColor    : '#c1c7d1',--}}
        {{--            pointHighlightFill  : '#fff',--}}
        {{--            pointHighlightStroke: 'rgba(220,220,220,1)',--}}
        {{--            data                : @json($sales_pcs)--}}
        {{--        },--}}
        {{--    ]--}}
        {{--}--}}
        {{--new Chart(barChartCanvasPcs, {--}}
        {{--    type: 'bar',--}}
        {{--    data: barChartDataPcs,--}}
        {{--    options: barChartOptions--}}
        {{--})--}}
    </script>
@endsection
