@extends('ibr.layout.master')

@section('body')

    <div class="row mt-3 justify-content-center">

        <div class="col-xl-3 col-md-6">
            <div class="card-box text-center">
                <h4 class="header-title mt-0 mb-4">{{__('portal.Indirect earnings')}}</h4>

                <h2><i class="mdi mdi-arrow-decision"></i></h2>
                <div class="widget-chart-1">
                    <div class="widget-detail-1 text-center">
                        <h2 class="font-weight-normal pt-2 mb-1">$ {{ number_format($directEarnings->sum('amount')) }} </h2>
                    </div>
                </div>
            </div>

        </div>
        <!-- end col -->

        <div class="col-xl-3 col-md-6">
            <div class="card-box text-center">
                <h4 class="header-title mt-0 mb-4">{{__('portal.Direct earnings')}}</h4>

                <h2><i class="mdi mdi-arrow-down-bold"></i></h2>
                <div class="widget-chart-1">
                    <div class="widget-detail-1 text-center">
                        <h2 class="font-weight-normal pt-2 mb-1">$ {{ number_format($inDirectEarnings->sum('amount')) }} </h2>
                    </div>
                </div>
            </div>

        </div>
        <!-- end col -->

        <div class="col-xl-3 col-md-6">
            <div class="card-box text-center">
                <h4 class="header-title mt-0 mb-4">{{__('portal.Total earnings')}}</h4>

                <h2><i class="mdi mdi-cash-multiple"></i></h2>
                <div class="widget-chart-1">
                    <div class="widget-detail-1 text-center">
                        <h2 class="font-weight-normal pt-2 mb-1">$ {{ number_format($earnings->sum('amount')) }} </h2>
                    </div>
                </div>
            </div>

        </div>
        <!-- end col -->

    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <h4 style="text-align: center;">{{__('portal.List of direct earnings')}}</h4>

                <table id="datatable" class="table table-bordered dt-responsive nowrap">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{__('portal.Client name')}}</th>
                        <th>{{__('portal.Amount')}}</th>
                        <th>{{__('portal.Date')}}</th>
                        <th>{{__('portal.Status')}}</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($directEarnings as $directEarning)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$directEarning->transaction->business->company_name}}</td>
                            <td>{{$directEarning->amount}}</td>
                            <td>{{\Carbon\Carbon::parse($directEarning->created_at)->format('d/M/Y')}}</td>
                            <td>
                                @if($directEarning->status == 0)
                                    <span style="color: red">{{__('portal.Unpaid')}}</span>
                                @elseif($directEarning->status == 1)
                                    <span style="color: limegreen">{{__('portal.Paid')}}</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

