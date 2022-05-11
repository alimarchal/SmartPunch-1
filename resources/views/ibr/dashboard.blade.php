@extends('ibr.layout.master')

@section('custom_styles')
    <style>
        .highcharts-credits {
            visibility: hidden !important;
        }
    </style>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
@endsection

@section('body')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="page-title">Dashboard</h4>

            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <h3 class="text-center font-weight-bold mt-0 mb-3">Earn money by growing your business with SmartPunch</h3>
        </div>
    </div>

    {{-- Highcharts Start --}}

    {{--<div class="row">

        <div class="col-xl-6 col-md-6">
            <div id="my_earnings" style="border-radius: 5px;"></div>
        </div>

        <div class="col-xl-6 col-md-6">
            <div id="earning_trend" style="border-radius: 5px;"></div>
        </div>

    </div>

    <hr>

    <div class="raw">
        <div class="col-xl-6 col-md-6">
            <div id="my_clients" style="border-radius: 5px;"></div>
        </div>
    </div>


    <hr>--}}

    {{-- Highcharts Ends --}}

    {{-- Morris Charts Starts --}}
    <div class="row">
        <div class="col-xl-4">
            <div class="card-box">
                <div class="dropdown float-right">
                    {{--<a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-dots-vertical"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Action</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Another action</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Something else</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Separated link</a>
                    </div>--}}
                </div>

                <h4 class="header-title mt-0">My Earnings</h4>

                <div class="widget-chart text-center">
                    <div id="my-earnings-morris-donut" dir="ltr" style="height: 245px;" class="morris-chart"></div>
                    <ul class="list-inline chart-detail-list mb-0">
                        <li class="list-inline-item">
                            <h5 style="color: #5b69bc;"><i class="fa fa-circle mr-1"></i>Direct Income</h5>
                        </li>
                        <li class="list-inline-item">
                            <h5 style="color: #ff8acc;"><i class="fa fa-circle mr-1"></i>Indirect Income</h5>
                        </li>
                    </ul>
                </div>
            </div>
        </div><!-- end col -->

        <div class="col-xl-4">
            <div class="card-box">
                <div class="dropdown float-right">
                    <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-dots-vertical"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Action</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Another action</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Something else</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Separated link</a>
                    </div>
                </div>
                <h4 class="header-title mt-0">Earning trend (Direct Income) last 3 months</h4>
{{--                <div id="morris-bar-example" dir="ltr" style="height: 280px;" class="morris-chart"></div>--}}
                <div id="earning-trend-morris-bar" dir="ltr" style="height: 280px;" class="morris-chart"></div>
            </div>
        </div><!-- end col -->

        <div class="col-xl-4">
            <div class="card-box">
                <div class="dropdown float-right">
                    <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-dots-vertical"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Action</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Another action</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Something else</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Separated link</a>
                    </div>
                </div>
                <h4 class="header-title mt-0">Earning trend (Indirect Income) last 3 months</h4>
                {{--                <div id="morris-bar-example" dir="ltr" style="height: 280px;" class="morris-chart"></div>--}}
                <div id="indirect-earning-trend-morris-bar" dir="ltr" style="height: 280px;" class="morris-chart"></div>
            </div>
        </div><!-- end col -->

        {{-- Line chart commented --}}
        {{--<div class="col-xl-4">
            <div class="card-box">
                <div class="dropdown float-right">
                    <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-dots-vertical"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Action</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Another action</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Something else</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Separated link</a>
                    </div>
                </div>
                <h4 class="header-title mt-0">Total Revenue</h4>
                <div id="morris-line-example" dir="ltr" style="height: 280px;" class="morris-chart"></div>
            </div>
        </div><!-- end col -->--}}

    </div>
    {{-- Morris Charts Ends --}}

    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card-box widget-user">
                <div class="media">
                    <div class="avatar-lg mr-3">
                        <img src="{{url('Horizontal/dist/assets/images/users/user-3.jpg')}}" class="img-fluid rounded-circle" alt="user">
                    </div>
                    <div class="media-body overflow-hidden">
                        <h5 class="mt-0 mb-1">Chadengle</h5>
                        <p class="text-muted mb-2 font-13 text-truncate">coderthemes@gmail.com</p>
                        <small class="text-warning"><b>Admin</b></small>
                    </div>
                </div>
            </div>
        </div><!-- end col -->

        <div class="col-xl-3 col-md-6">
            <div class="card-box widget-user">
                <div class="media">
                    <div class="avatar-lg mr-3">
                        <img src="{{url('Horizontal/dist/assets/images/users/user-2.jpg')}}" class="img-fluid rounded-circle" alt="user">
                    </div>
                    <div class="media-body overflow-hidden">
                        <h5 class="mt-0 mb-1"> Michael Zenaty</h5>
                        <p class="text-muted mb-2 font-13 text-truncate">coderthemes@gmail.com</p>
                        <small class="text-pink"><b>Support Lead</b></small>
                    </div>
                </div>
            </div>
        </div><!-- end col -->

        <div class="col-xl-3 col-md-6">
            <div class="card-box widget-user">
                <div class="media">
                    <div class="avatar-lg mr-3">
                        <img src="{{url('Horizontal/dist/assets/images/users/user-1.jpg')}}" class="img-fluid rounded-circle" alt="user">
                    </div>
                    <div class="media-body overflow-hidden">
                        <h5 class="mt-0 mb-1">Stillnotdavid</h5>
                        <p class="text-muted mb-2 font-13 text-truncate">coderthemes@gmail.com</p>
                        <small class="text-success"><b>Designer</b></small>
                    </div>
                </div>
            </div>
        </div><!-- end col -->

        <div class="col-xl-3 col-md-6">
            <div class="card-box widget-user">
                <div class="media">
                    <div class="avatar-lg mr-3">
                        <img src="{{url('Horizontal/dist/assets/images/users/user-10.jpg')}}" class="img-fluid rounded-circle" alt="user">
                    </div>
                    <div class="media-body overflow-hidden">
                        <h5 class="mt-0 mb-1">Tomaslau</h5>
                        <p class="text-muted mb-2 font-13 text-truncate">coderthemes@gmail.com</p>
                        <small class="text-info"><b>Developer</b></small>
                    </div>
                </div>
            </div>
        </div><!-- end col -->

    </div>
    <div class="row">
        <div class="col-xl-4">
            <div class="card-box">
                <div class="dropdown float-right">
                    <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-dots-vertical"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Action</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Another action</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Something else</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Separated link</a>
                    </div>
                </div>

                <h4 class="header-title mb-3">Inbox</h4>

                <div class="inbox-widget">

                    <div class="inbox-item">
                        <a href="#">
                            <div class="inbox-item-img"><img src="{{url('Horizontal/dist/assets/images/users/user-1.jpg')}}" class="rounded-circle" alt=""></div>
                            <h5 class="inbox-item-author mt-0 mb-1">Chadengle</h5>
                            <p class="inbox-item-text">Hey! there I'm available...</p>
                            <p class="inbox-item-date">13:40 PM</p>
                        </a>
                    </div>

                    <div class="inbox-item">
                        <a href="#">
                            <div class="inbox-item-img"><img src="{{url('Horizontal/dist/assets/images/users/user-2.jpg')}}" class="rounded-circle" alt=""></div>
                            <h5 class="inbox-item-author mt-0 mb-1">Tomaslau</h5>
                            <p class="inbox-item-text">I've finished it! See you so...</p>
                            <p class="inbox-item-date">13:34 PM</p>
                        </a>
                    </div>

                    <div class="inbox-item">
                        <a href="#">
                            <div class="inbox-item-img"><img src="{{url('Horizontal/dist/assets/images/users/user-3.jpg')}}" class="rounded-circle" alt=""></div>
                            <h5 class="inbox-item-author mt-0 mb-1">Stillnotdavid</h5>
                            <p class="inbox-item-text">This theme is awesome!</p>
                            <p class="inbox-item-date">13:17 PM</p>
                        </a>
                    </div>

                    <div class="inbox-item">
                        <a href="#">
                            <div class="inbox-item-img"><img src="{{url('Horizontal/dist/assets/images/users/user-4.jpg')}}" class="rounded-circle" alt=""></div>
                            <h5 class="inbox-item-author mt-0 mb-1">Kurafire</h5>
                            <p class="inbox-item-text">Nice to meet you</p>
                            <p class="inbox-item-date">12:20 PM</p>
                        </a>
                    </div>

                    <div class="inbox-item">
                        <a href="#">
                            <div class="inbox-item-img"><img src="{{url('Horizontal/dist/assets/images/users/user-5.jpg')}}" class="rounded-circle" alt=""></div>
                            <h5 class="inbox-item-author mt-0 mb-1">Shahedk</h5>
                            <p class="inbox-item-text">Hey! there I'm available...</p>
                            <p class="inbox-item-date">10:15 AM</p>
                        </a>
                    </div>
                </div>
            </div>
        </div><!-- end col -->

        <div class="col-xl-8">
            <div class="card-box">
                <div class="dropdown float-right">
                    <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-dots-vertical"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Action</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Another action</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Something else</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Separated link</a>
                    </div>
                </div>

                <h4 class="header-title mt-0 mb-3">Latest Projects</h4>

                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Project Name</th>
                            <th>Start Date</th>
                            <th>Due Date</th>
                            <th>Status</th>
                            <th>Assign</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1</td>
                            <td>Adminto Admin v1</td>
                            <td>01/01/2017</td>
                            <td>26/04/2017</td>
                            <td><span class="badge badge-danger">Released</span></td>
                            <td>Coderthemes</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Adminto Frontend v1</td>
                            <td>01/01/2017</td>
                            <td>26/04/2017</td>
                            <td><span class="badge badge-success">Released</span></td>
                            <td>Adminto admin</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Adminto Admin v1.1</td>
                            <td>01/05/2017</td>
                            <td>10/05/2017</td>
                            <td><span class="badge badge-pink">Pending</span></td>
                            <td>Coderthemes</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Adminto Frontend v1.1</td>
                            <td>01/01/2017</td>
                            <td>31/05/2017</td>
                            <td><span class="badge badge-purple">Work in Progress</span>
                            </td>
                            <td>Adminto admin</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Adminto Admin v1.3</td>
                            <td>01/01/2017</td>
                            <td>31/05/2017</td>
                            <td><span class="badge badge-warning">Coming soon</span></td>
                            <td>Coderthemes</td>
                        </tr>

                        <tr>
                            <td>6</td>
                            <td>Adminto Admin v1.3</td>
                            <td>01/01/2017</td>
                            <td>31/05/2017</td>
                            <td><span class="badge badge-primary">Coming soon</span></td>
                            <td>Adminto admin</td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- end col -->

    </div>

@endsection


@section('scripts')


{{--    <script src="https://code.highcharts.com/modules/exporting.js"></script>--}}
{{--    <script src="https://code.highcharts.com/modules/export-data.js"></script>--}}
{{--    <script src="https://code.highcharts.com/modules/accessibility.js"></script>--}}

    <script>

        Morris.Donut({
            element: 'my-earnings-morris-donut',
            data: [
                {
                    label: "Direct Income",
                    value: {{ $ibr_direct_com->sum('total') }}
                },
                {
                    label: "Indirect Income",
                    value: {{ $ibr_in_direct_com->sum('total') }}
                }
            ],
            // labelColor: '#9CC4E4', // text color
            backgroundColor: '#333333', // border color
            colors: [
                '#5b69bc',
                '#ff8acc',
            ],
            formatter: function (y, data) { return '$' + y }
        });

        /* Bar chart for Direct Income */
        Morris.Bar({
            element: 'earning-trend-morris-bar',
            data: [
                {{--@for($i= 0; $i< $direct_indirect_commissions->count(); $i++)
                {
                    x: '{{$direct_indirect_commissions['months'][$i]}}',
                        @if(isset($direct_indirect_commissions['direct_commission'][$i]))
                            direct: '{{$direct_indirect_commissions['direct_commission'][$i]['total']}}',
                        @else
                            direct: '0',
                        @endif
                        @if(isset($direct_indirect_commissions['in_direct_commission'][$i]))
                            inDirect: '{{$direct_indirect_commissions['in_direct_commission'][$i]['total']}}'
                        @else
                            inDirect: '0'
                        @endif
                },
                @endfor--}}

                @for($i= 0; $i< $direct_indirect_commissions['direct_commission']->count(); $i++)
                {
                    x: '{{$direct_indirect_commissions['direct_commission'][$i]['month']}}',

                    direct: '{{$direct_indirect_commissions['direct_commission'][$i]['total']}}',
                },
                @endfor
            ],
            xkey: 'x',
            // ykeys: ['direct', 'inDirect'],
            ykeys: ['direct'],
            labels: ['Direct Income']
        })

        /* Bar chart for Indirect Income */
        Morris.Bar({
            element: 'indirect-earning-trend-morris-bar',
            data: [
                @for($i= 0; $i< $direct_indirect_commissions['in_direct_commission']->count(); $i++)
                    {
                        x: '{{$direct_indirect_commissions['in_direct_commission'][$i]['month']}}',

                        Indirect: '{{$direct_indirect_commissions['in_direct_commission'][$i]['total']}}',
                    },
                @endfor
            ],
            xkey: 'x',
            // ykeys: ['direct', 'inDirect'],
            ykeys: ['Indirect'],
            labels: ['Indirect Income'],
            barColors: function () {
                return '#228B22';
            },
        })

        Highcharts.chart('my_earnings', {
            chart: {
                backgroundColor: '#353D4A',
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'My Earnings',
                style: {
                    color: '#ffffff',
                }
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>'
                    }
                }
            },
            series: [{
                name: 'Total Percentage',
                colorByPoint: true,
                data: [
                    {
                        name: 'Direct: $ {{$ibr_direct_com->sum('total')}}',
                        y: {{$ibr_direct_com->sum('total')}},
                        selected: true
                    },


                    {
                        name: 'Indirect: ${{$ibr_in_direct_com->sum('total')}}',
                        y: {{$ibr_in_direct_com->sum('total')}},
                        sliced: true,
                        selected: true
                    },
                ]
            }]
        });


        // column chart


        Highcharts.chart('earning_trend', {
            chart: {
                backgroundColor: '#353D4A',
                type: 'column'
            },
            title: {
                text: 'Earning trend',
                style: {
                    color: '#ffffff',
                }
            },

            xAxis: {
                categories: [
                    @foreach($ibr_in_direct_com as $ibr) '{{$ibr->month_year}}', @endforeach
                ],
                crosshair: true,
                labels: {
                    style: {
                        color: '#ffffff'
                    }
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Earning ($)',
                    style: {
                        color: '#ffffff'
                    }
                },
                labels: {
                    style: {
                        color: '#ffffff'
                    }
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [
                {
                    name: 'Indirect',
                    data: [@foreach($ibr_in_direct_com as $ibr) {{$ibr->total}}, @endforeach]

                },
            ]
        });


        Highcharts.chart('my_clients', {
            chart: {
                backgroundColor: '#353D4A',
                type: 'spline',
            },
            title: {
                text: 'Monthly Businesses Registered',
                style: {
                    color: '#ffffff',
                }
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                labels: {
                    style: {
                        color: '#ffffff'
                    }
                }
            },
            yAxis: {
                title: {
                    text: 'Total',
                    style: {
                        color: '#ffffff',
                    }
                },
                labels: {
                    formatter: function () {
                        return this.value ;
                    },
                    style: {
                        color: '#ffffff'
                    }
                }
            },
            tooltip: {
                crosshairs: true,
                shared: true
            },
            plotOptions: {
                spline: {
                    marker: {
                        radius: 4,
                        lineColor: '#666666',
                        lineWidth: 1
                    }
                }
            },
            series: [  {
                name: 'Business Registered',
                marker: {
                    symbol: 'diamond'
                },
                data: [{
                    y: 3.9,

                }, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
            }]
        });


    </script>


@endsection
