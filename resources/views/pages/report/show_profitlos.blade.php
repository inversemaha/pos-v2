@extends('layouts.admin_layout')

@section('title', 'Show Profit Loss')
@section('content')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <h4 class="page-title">Profit Loss</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="#">View Profit Loss</a></li>
            </ol>

        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <div class="row">
                    <div class="col-12">
                        <div class="p-20">
                            <form class="form-inline" method="post" action="/report/profit/show"
                                  enctype="multipart/form-data" autocomplete="off">

                                <div class="form-group">
                                    <label class="col-form-label">From Date</label>

                                    <input type="text" class="form-control" name="from_date"
                                           placeholder="mm/dd/yyyy" id="datepicker-autoclose" required>
                                    <input type="hidden" class="form-control" name="_token"
                                           value="{{csrf_token()}}">

                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">To Date</label>

                                    <input type="text" class="form-control" name="to_date" placeholder="mm/dd/yyyy"
                                           id="datepicker" required>

                                </div>


                                <div class="form-group mb-0 justify-content-end">

                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Search
                                    </button>

                                </div>


                                <div class="form-group mb-0 justify-content-end row col-md-2">
                                    <div class="col-10">
                                        <a href="/daily/report/profit/loss/show"
                                           class="btn btn-success waves-effect waves-light">Daily Report</a>
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group mb-0 justify-content-end row col-md-2">
                                    <div class="col-10">
                                        <a href="/current-week/report/profit/loss/show"
                                           class="btn btn-primary waves-effect waves-light">Weekly Report</a>
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group mb-0 justify-content-end row col-md-2">
                                    <div class="col-10">
                                        <a href="/current-month/report/profit/loss/show"
                                           class="btn btn-default waves-effect waves-light">Monthly Report</a>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-xl-6 mx-auto">
            <div class="card-box">
                <h4 class="text-dark header-title m-t-0 m-b-30">Daily Sales</h4>
                <h4>Profit/ Loss: {{$total_sell-($total_expense+$total_purchase+$total_ingredient_purchase)}} Tk</h4>
                <hr>
                <div class="widget-chart text-center">
                    <div id="sparkline3"></div>
                    <ul class="list-inline m-t-15">
                        <li>
                            <h5 class="text-muted m-t-20">Sale</h5>
                            <h4 class="m-b-0">{{$total_sell}} Tk</h4>
                        </li>
                        <li>
                            <h5 class="text-muted m-t-20">Expense</h5>
                            <h4 class="m-b-0">{{$total_expense}} Tk</h4>
                        </li>
                        <li>
                            <h5 class="text-muted m-t-20">Purchase</h5>
                            <h4 class="m-b-0">{{$total_purchase}} Tk</h4>
                        </li>
                        <li>
                            <h5 class="text-muted m-t-20">Ingredient Purchase</h5>
                            <h4 class="m-b-0">{{$total_ingredient_purchase}} Tk</h4>
                        </li>

                    </ul>
                </div>
            </div>

        </div>

    </div>


    <script>

        $(document).ready(function () {

            var DrawSparkline = function () {
                $('#sparkline1').sparkline([0, 23, 43, 35, 44, 45, 56, 37, 40], {
                    type: 'line',
                    width: "100%",
                    height: '165',
                    chartRangeMax: 50,
                    lineColor: '#7e57c2',
                    fillColor: 'transparent',
                    highlightLineColor: 'rgba(0,0,0,.1)',
                    highlightSpotColor: 'rgba(0,0,0,.2)'
                });

                $('#sparkline1').sparkline([25, 23, 26, 24, 25, 32, 30, 24, 19], {
                    type: 'line',
                    width: "100%",
                    height: '165',
                    chartRangeMax: 40,
                    lineColor: '#34d3eb',
                    fillColor: 'transparent',
                    composite: true,
                    highlightLineColor: 'rgba(0,0,0,1)',
                    highlightSpotColor: 'rgba(0,0,0,1)'
                });

                $('#sparkline3').sparkline([3, 6, 7, 8, 6, 4, 7, 10, 12, 7, 4, 9, 12, 13, 11, 12], {
                    type: 'bar',
                    height: '165',
                    barWidth: '10',
                    barSpacing: '3',
                    barColor: '#34d3eb'
                });

                $('#sparkline3').sparkline([


                    {{($total_expense*100)/($grand_total)}},
                    {{($total_purchase*100)/($grand_total)}},
                    {{($total_sell*100)/($grand_total)}},
                    {{($total_ingredient_purchase*100)/($grand_total)}},

                ], {
                    type: 'pie',
                    width: '200',
                    height: '200',
                    sliceColors: ['#5D9CEC', '#FB6D9D', '#5FBEAA', '#F05050']
                });


            };

            DrawSparkline();

            var resizeChart;

            $(window).resize(function (e) {
                clearTimeout(resizeChart);
                resizeChart = setTimeout(function () {
                    DrawSparkline();
                }, 300);
            });
        });
    </script>

@endsection
