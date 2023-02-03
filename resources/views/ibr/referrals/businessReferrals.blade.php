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

    <div class="row mt-3 justify-content-center">
{{--        <div class="col-xl-6 col-md-6 ">--}}
{{--            <div id="my_clients" style="border-radius: 5px;"></div>--}}
{{--        </div>--}}
        <div class="col-xl-6 col-md-6">
            <div class="card-box">
                <h4 class="header-title mt-0" style="text-align: center">My Clients</h4>
                <div id="revenue-chart" dir="ltr" style="height: 280px;" class="morris-chart"></div>
            </div>
        </div><!-- end col -->
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <div class="card-box">
                <h4 style="text-align: center;">{{__('portal.List of business referrals')}}</h4>

                <table id="datatable" class="table table-bordered dt-responsive nowrap">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{__('portal.Business Name')}}</th>
                        <th>{{__('portal.Email')}}</th>
                        <th>{{__('portal.Phone')}}</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($referrals as $referral)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$referral->company_name}}</td>
                            <td>@if(isset($referral->user->email)) {{$referral->user->email}} @endif </td>
                            <td>@if(isset($referral->user->phone)) {{$referral->user->phone}} @endif</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script>

        /*new Morris.Line({
            // ID of the element in which to draw the chart.
            element: 'revenue-charts',
            // Chart data records -- each entry in this array corresponds to a point on
            // the chart.
            data: [
                { year: '2008', value: 20 },
                { year: '2009', value: 10 },
                { year: '2010', value: 5 },
                { year: '2011', value: 5 },
                { year: '2012', value: 20 }
            ],
            // The name of the data record attribute that contains x-values.
            xkey: 'year',
            // A list of names of data record attributes that contain y-values.
            ykeys: ['value'],
            // Labels for the ykeys -- will be displayed when you hover over the
            // chart.
            labels: ['Value']
        });*/

        new Morris.Line({
            // ID of the element in which to draw the chart.
            element: 'revenue-chart',
            // Chart data records -- each entry in this array corresponds to a point on
            // the chart.
            data : [
                @foreach($data as $key => $value)
                    @if($key == 1) { month: 'Jan', businesses: '{{$value}}' }, @endif
                    @if($key == 2) { month: 'Feb', businesses: '{{$value}}' }, @endif
                    @if($key == 3) { month: 'Mar', businesses: '{{$value}}' }, @endif
                    @if($key == 4) { month: 'Apr', businesses: '{{$value}}' }, @endif
                    @if($key == 5) { month: 'May', businesses: '{{$value}}' }, @endif
                    @if($key == 6) { month: 'Jun', businesses: '{{$value}}' }, @endif
                    @if($key == 7) { month: 'Jul', businesses: '{{$value}}' }, @endif
                    @if($key == 8) { month: 'Aug', businesses: '{{$value}}' }, @endif
                    @if($key == 9) { month: 'Sep', businesses: '{{$value}}' }, @endif
                    @if($key == 10) { month: 'Oct', businesses: '{{$value}}' }, @endif
                    @if($key == 11) { month: 'Nov', businesses: '{{$value}}' }, @endif
                    @if($key == 12) { month: 'Dec', businesses: '{{$value}}' }, @endif
                    {{--{ month: '{{$key}}', businesses: '{{$value}}' },--}}
                @endforeach
            ],
            // The name of the data record attribute that contains x-values.
            xkey: 'month',
            parseTime: false,
            // A list of names of data record attributes that contain y-values.
            ykeys: ['businesses'],
            // yLabelFormat: function (y) { return y.toString() + 's'; },
            // Labels for the ykeys -- will be displayed when you hover over the
            // chart.
            labels: ['Businesses'],
            fillOpacity: 0.6,
            hideHover: 'auto',
            behaveLikeLine: true,
            resize: true,
            pointFillColors:['#ffffff'],
            pointStrokeColors: ['black'],
            lineColors: ['#3dbeee'],
        });

        /*Highcharts.chart('my_clients', {
            chart: {
                backgroundColor: '#353D4A',
                type: 'spline',
            },
            title: {
                text: 'Monthly Business Registered',
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
        });*/
    </script>
@endsection

