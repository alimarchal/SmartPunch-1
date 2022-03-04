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
        <div class="col-xl-6 col-md-6">
            <div id="my_clients" style="border-radius: 5px;"></div>
        </div>
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
                            <td>{{$referral->user->email}}</td>
                            <td>{{$referral->user->phone}}</td>
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
        Highcharts.chart('my_clients', {
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
        });
    </script>
@endsection

