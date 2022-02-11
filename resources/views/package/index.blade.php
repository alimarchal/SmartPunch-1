@extends('theme.master')

@section('body')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-center">
                <h4 class="page-title">{{__('portal.Small and medium packages')}}</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-center">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <span class="nav-link active" data-toggle="tab" style="cursor: pointer" onclick="package_details(1)">{{__('portal.Monthly')}}</span>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link" data-toggle="tab" style="cursor: pointer" onclick="package_details(2)" >{{__('portal.Quarterly')}}</span>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link" data-toggle="tab" style="cursor: pointer" onclick="package_details(3)" >{{__('portal.6 months')}}</span>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link" data-toggle="tab" style="cursor: pointer" onclick="package_details(4)" >{{__('portal.Yearly')}}</span>
                    </li>
                </ul>

            </div>
        </div>
    </div>

    <div class="row mt-2 justify-content-center">
        <div class="col-lg-10">
            <div class="row">

                <!--Pricing Column-->
                @foreach($packages->take(4) as $package)
                <article class="pricing-column col-xl-3 col-md-6">
                    <div class="inner-box card-box">
                        <div class="plan-header p-3 text-center">
                            <h3 class="plan-title">{{$package->name}}</h3>
                            <h2 class="plan-price font-weight-normal price_monthly">${{number_format($package->monthly)}}</h2>
                            <h2 class="plan-price font-weight-normal price_quarterly" style="display: none">${{number_format($package->quarterly)}}</h2>
                            <h2 class="plan-price font-weight-normal price_half_year" style="display: none">${{number_format($package->half_year)}}</h2>
                            <h2 class="plan-price font-weight-normal price_yearly" style="display: none">${{number_format($package->yearly)}}</h2>
                            <div class="plan-duration duration_monthly">{{__('portal.Per Month')}}</div>
                            <div class="plan-duration duration_quarterly" style="display: none">{{__('portal.Quarterly')}}</div>
                            <div class="plan-duration duration_half_year" style="display: none">{{__('portal.6 months')}}</div>
                            <div class="plan-duration duration_yearly" style="display: none">{{__('portal.Yearly')}}</div>
                        </div>
                        <ul class="plan-stats list-unstyled text-center p-3 mb-0">
                            <li>{{$package->users}} {{__('portal.Users')}}</li>
                        </ul>

                        <div class="text-center">
                            <a href="javascript:void(0)" class="btn btn-bordered-success btn-rounded waves-effect waves-light">{{__('portal.Select')}}</a>
                        </div>
                    </div>
                </article>
                @endforeach

            </div><!-- end row -->

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-center">
                        <h4 class="page-title">{{__('portal.Packages above 100 users')}}</h4>
                    </div>
                </div>
            </div><!-- end row -->
            <div class="row">
                <!--Pricing Column-->
                @foreach($packages->sortByDesc('id')->take(4)->reverse() as $package)
                    <article class="pricing-column col-xl-3 col-md-6">
                        <div class="inner-box card-box">
                            <div class="plan-header p-3 text-center">
                                <h3 class="plan-title">{{$package->name}}</h3>
                                <h2 class="plan-price font-weight-normal price_monthly">${{number_format($package->monthly)}}</h2>
                                <h2 class="plan-price font-weight-normal price_quarterly" style="display: none">${{number_format($package->quarterly)}}</h2>
                                <h2 class="plan-price font-weight-normal price_half_year" style="display: none">${{number_format($package->half_year)}}</h2>
                                <h2 class="plan-price font-weight-normal price_yearly" style="display: none">${{number_format($package->yearly)}}</h2>
                                <div class="plan-duration duration_monthly">{{__('portal.Per Month')}}</div>
                                <div class="plan-duration duration_quarterly" style="display: none">{{__('portal.Quarterly')}}</div>
                                <div class="plan-duration duration_half_year" style="display: none">{{__('portal.6 months')}}</div>
                                <div class="plan-duration duration_yearly" style="display: none">{{__('portal.Yearly')}}</div>
                            </div>
                            <ul class="plan-stats list-unstyled text-center p-3 mb-0">
                                <li>{{$package->users}} {{__('portal.Users')}}</li>
                            </ul>

                            <div class="text-center">
                                <a href="javascript:void(0)" class="btn btn-bordered-success btn-rounded waves-effect waves-light">{{__('portal.Select')}}</a>
                            </div>
                        </div>
                    </article>
                @endforeach

            </div><!-- end row -->
        </div>
    </div>
    <!-- end row -->
@endsection

@section('scripts')
    <script>
        function package_details(id){
            /* 1 for monthly */
            if (id === 1){
                $('.price_quarterly').hide()
                $('.duration_quarterly').hide()
                $('.price_half_year').hide()
                $('.duration_half_year').hide()
                $('.price_yearly').hide()
                $('.duration_yearly').hide()

                $('.price_monthly').show()
                $('.duration_monthly').show()
            }
            /* 2 for quarterly */
            if (id === 2){
                $('.price_monthly').hide()
                $('.duration_monthly').hide()
                $('.price_half_year').hide()
                $('.duration_half_year').hide()
                $('.price_yearly').hide()
                $('.duration_yearly').hide()

                $('.price_quarterly').show()
                $('.duration_quarterly').show()
            }
            /* 3 for half year */
            if (id === 3){
                $('.price_monthly').hide()
                $('.duration_monthly').hide()
                $('.price_quarterly').hide()
                $('.duration_quarterly').hide()
                $('.price_yearly').hide()
                $('.duration_yearly').hide()

                $('.price_half_year').show()
                $('.duration_half_year').show()
            }
            /* 4 for yearly */
            if (id === 4){
                $('.price_monthly').hide()
                $('.duration_monthly').hide()
                $('.price_quarterly').hide()
                $('.duration_quarterly').hide()
                $('.price_half_year').hide()
                $('.duration_half_year').hide()

                $('.price_yearly').show()
                $('.duration_yearly').show()
            }
        }
    </script>
@endsection
