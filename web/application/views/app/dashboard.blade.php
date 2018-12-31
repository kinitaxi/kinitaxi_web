@include('app_gen.reloader')
@include('app_gen.sidebar')

<div class="main-panel">
    @include('app_gen.navbar')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="card">
                        <div class="content">
                            <div class="row">
                                <div class="col-xs-5">
                                    <div class="icon-big icon-warning text-center">
                                        <i class="ti-user"></i>
                                    </div>
                                </div>
                                <div class="col-xs-7">
                                    <div class="numbers">
                                        <p>Total Users</p>
                                        {{ $users_count }}
                                    </div>
                                </div>
                            </div>
                            <div class="footer">
                                <hr />
                                <div class="stats">
                                    <i class="ti-reload"></i> Updated now
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="card">
                        <div class="content">
                            <div class="row">
                                <div class="col-xs-5">
                                    <div class="icon-big icon-info text-center">
                                        <i class="ti-target"></i>
                                    </div>
                                </div>
                                <div class="col-xs-7">
                                    <div class="numbers">
                                        <p>Drivers</p>
                                        {{ $drivers_count }}
                                    </div>
                                </div>
                            </div>
                            <div class="footer">
                                <hr />
                                <div class="stats">
                                    <i class="ti-calendar"></i> Updated now
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="card">
                        <div class="content">
                            <div class="row">
                                <div class="col-xs-5">
                                    <div class="icon-big icon-danger text-center">
                                        <i class="ti-car"></i>
                                    </div>
                                </div>
                                <div class="col-xs-7">
                                    <div class="numbers">
                                        <p>Rides</p>
                                        {{ $rides_count }}
                                    </div>
                                </div>
                            </div>
                            <div class="footer">
                                <hr />
                                <div class="stats">
                                    <i class="ti-timer"></i> Updated now
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="card">
                        <div class="content">
                            <div class="row">
                                <div class="col-xs-5">
                                    <div class="icon-big icon-success text-center">
                                        <i class="ti-credit-card"></i>
                                    </div>
                                </div>
                                <div class="col-xs-7">
                                    <div class="numbers">
                                        <p>Payments</p>
                                        ₦{{ number_format($total_spent) }}
                                    </div>
                                </div>
                            </div>
                            <div class="footer">
                                <hr />
                                <div class="stats">
                                    <i class="ti-reload"></i> Updated now
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">Ride Ratio</h4>
                            <p class="category">Shows the ratio of completed rides compared to cancelled rides</p>
                        </div>
                        <div class="content">
                            <div id="chartPreferences" class="ct-chart ct-perfect-fourth" data-cancelled="{{ $cancelledRatio }}" data-completed="{{ $completedRatio }}"></div>

                            <div class="footer">
                                <div class="chart-legend">
                                    <i class="fa fa-circle text-success"></i> Completed Rides
                                    <i class="fa fa-circle text-muted"></i> Cancelled Rides
                                </div>
                                <hr>
                                <div class="stats">
                                    <i class="ti-timer"></i> Updated daily
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card ">
                        <div class="header">
                            <h4 class="title">Growth rate</h4>
                            <p class="category">Shows the rate of registration of users and drivers</p>
                        </div>
                        <div class="content">
                            <div id="chartActivity" class="ct-chart" data-users="{{ $growthData_u }}" data-drivers="{{ $growthData_d }}"></div>

                            <div class="footer">
                                <div class="chart-legend">
                                    <i class="fa fa-circle text-warning"></i> Users
                                    <i class="fa fa-circle text-info"></i> Drivers
                                </div>
                                <hr>
                                <div class="stats">
                                    <i class="ti-check"></i> Data chart updated in seconds
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        type = ['','info','success','warning','danger'];
        demo = {

            initChartist: function(){

                var lineChart = $('#chartActivity');

                var users = lineChart.data('users');
                var drivers = lineChart.data('drivers');

                var data = {
                    labels: ['6 days', '5 days', '4 days', '3 days', '2 days', '1 day', 'Today'],
                    series: [
                        drivers,users
                    ]
                };

                var options = {
                    seriesBarDistance: 10,
                    axisX: {
                        showGrid: true
                    },
                    height: "245px",
                    axisY: {
                        onlyInteger: true,
                        offset: 20
                    }
                };

                var responsiveOptions = [
                    ['screen and (max-width: 640px)', {
                        seriesBarDistance: 5,
                        axisX: {
                            labelInterpolationFnc: function (value) {
                                return value[0];
                            }
                        }
                    }]
                ];

                Chartist.Line('#chartActivity', data, options, responsiveOptions);

                ///////////////////////////////////////
                var dataPreferences = {
                    series: [
                        [25, 30, 20, 25]
                    ]
                };

                var optionsPreferences = {
                    donut: true,
                    donutWidth: 40,
                    startAngle: 0,
                    total: 100,
                    showLabel: false,
                    axisX: {
                        showGrid: false
                    }
                };

                Chartist.Pie('#chartPreferences', dataPreferences, optionsPreferences);

                var pieChart = $('#chartPreferences');

                var completed = pieChart.data('completed');
                var cancelled = pieChart.data('cancelled');

                Chartist.Pie('#chartPreferences', {
                    labels: [completed.toString() + '%','',cancelled.toString() + '%'],
                    series: [completed,0, cancelled]
                });
            }
        };

        $(document).ready(function(){

            demo.initChartist();

        });
    </script>

    @include('app_gen.footer')

</div>
