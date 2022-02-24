<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <title>{{env('APP_NAME')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description"/>
    <meta content="Coderthemes" name="author"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{url('logo.png')}}">

    {{-- select2 scripts start --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    {{-- select2 scripts end --}}

    <!-- Bootstrap Css -->
    <link href="{{url('Horizontal/dist/assets/css/bootstrap-dark.min.css')}}" id="bootstrap-stylesheet" rel="stylesheet" type="text/css"/>
    <!-- Icons Css -->
    <link href="{{url('Horizontal/dist/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- App Css-->
    <link href="{{url('Horizontal/dist/assets/css/app-dark.min.css')}}" id="app-stylesheet" rel="stylesheet" type="text/css"/>

</head>

<body data-layout="horizontal" data-topbar="dark">

<!-- Begin page -->
<div id="wrapper">

    <!-- Navigation Bar-->
    <header id="topnav">
        <!-- Topbar Start -->
        <div class="navbar-custom">
            <div class="container-fluid">
                <ul class="list-unstyled topnav-menu float-right mb-0">

                    <li class="dropdown notification-list">
                        <!-- Mobile menu toggle-->
                        <a class="navbar-toggle nav-link">
                            <div class="lines">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </a>
                        <!-- End mobile menu toggle-->
                    </li>

                    <li class="dropdown notification-list">
                        <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <img src="{{ Auth::user()->profile_photo_url }}" alt="user-image" class="rounded-circle">
                            @endif
                            <span class="pro-user-name ml-1">
                                 {{ Auth::user()->name }} <i class="mdi mdi-chevron-down"></i>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-dropdown ">

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                this.closest('form').submit();" class="dropdown-item notify-item">
                                    <i class="fe-log-out"></i>
                                    <span>{{__('register.Logout')}}</span>
                                </a>
                            </form>

                        </div>
                    </li>

                </ul>

                <!-- LOGO -->
                <div class="logo-box">
                    <a class="logo logo-light">
                        <span class="logo-lg">
                            <img src="{{url('logo.png')}}" alt="" height="44">
                        </span>
                        <span class="logo-sm">
                    <img src="{{url('logo.png')}}" alt="" height="44">
                </span>
                    </a>
                </div>

                <div class="clearfix"></div>
            </div> <!-- end container-fluid-->
        </div>
        <!-- end Topbar -->

    </header>
    <!-- End Navigation Bar-->

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">

                <div class="row">
                    <div class="col-xl-6 mx-auto">
                        <div class="text-center">
                            <a class="logo">
                                <img src="{{url('logo.png')}}" alt="" height="64" class="logo-light mx-auto">
                            </a>
                            <p class="mt-2 mb-4 font-italic" style="font-size: 25px; color: #76ABDC;">{{__('register.SmartPunch')}}</p>
                        </div>
                        <div class="card-box mt-3">

                            <h4 class="header-title mt-0 mb-3 text-center">{{__('portal.Enter Business Details to proceed')}}</h4>

                            <form action="{{route('businessCreate')}}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label for="userName">{{__('portal.Company Name')}} *</label>
                                    <input type="text" name="company_name" parsley-trigger="change" placeholder="{{__('register.Enter company name')}}" class="form-control @error('company_name') parsley-error @enderror" id="userName" value="{{old('company_name')}}" required>

                                    @error('company_name')
                                        <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('company_name') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="country_name">{{__('portal.Country Name')}} *</label>

                                    <select class="custom-select" name="country_name" id="country_name">
                                        <option value="" selected>{{__('portal.Select')}}</option>
                                        @foreach($countries as $country)
                                            <option value="{{$country->id}}">{{$country->name}}</option>
                                        @endforeach
                                    </select>

                                    @error('country_name')
                                        <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('country_name') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="city_name">{{__('portal.City Name')}} *</label>

                                    <select class="custom-select" name="city_name" id="city_name">
                                        <option value="" selected>{{__('portal.Select')}}</option>
                                    </select>

                                    @error('city_name')
                                        <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('city_name') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="pass1">{{__('portal.Country Code')}} *</label>
                                    <input id="pass1" type="text" name="country_code" placeholder="{{__('register.Enter country code')}}" class="form-control @error('country_code') parsley-error @enderror" value="{{old('country_code')}}" required>

                                    @error('country_code')
                                        <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('country_code') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="logo">{{__('portal.Company Logo')}}</label>

                                    <input type="file" name="logo" class="form-control @error('logo') parsley-error @enderror" required>

                                    @error('logo')
                                        <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('logo') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="passWord2">{{__('portal.IBR')}}</label>
                                    <input type="text" name="ibr" placeholder="{{__('register.Enter IBR (if any)')}}" class="form-control" id="passWord2">
                                </div>

                                <div class="form-group text-right mb-0">
                                    <button class="btn btn-primary waves-effect waves-light mr-1" type="submit">
                                        {{__('portal.Submit')}}
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

            </div> <!-- container-fluid -->

        </div> <!-- content -->

        <!-- Footer Start -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <?php echo date("Y");?> &copy; <a class="text-blue">{{__('portal.SmartPunch')}}</a>
                    </div>
                    <div class="col-md-6">
                        <div class="text-md-right footer-links d-none d-sm-block">
                            <a href="javascript:void(0);">{{__('portal.About Us')}}</a>
                            <a href="javascript:void(0);">{{__('portal.Help')}}</a>
                            <a href="javascript:void(0);">{{__('portal.Contact Us')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->

    </div>

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->


</div>
<!-- END wrapper -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
<script>

    $(document).ready(function() {
        $('#city_name').select2();
    });

    $("#country_name").select2().on("change", function () {
        let option = '';
        $('#city_name').prop('disabled', true);
        $.ajax({
            url: "{{route('ibr.search-cities')}}",
            method: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                id: $('#country_name').val(),
            },
            success: function(result){
                $('#city_name').prop('disabled', false);
                $('#city_name').empty();
                $('#city_name').append(' <option disabled selected value="">Select</option>');
                result.cities.forEach(function (city, index) {
                    option = "<option value='" + city.id + "'>" + city.name + "</option>"
                    $('#city_name').append(option);
                });
            },
            error: function(result){
                console.log('error');
            }
        });
    });
</script>

<!-- Vendor js -->
<script src="{{url('Horizontal/dist/assets/js/vendor.min.js')}}"></script>

<!-- knob plugin -->
<script src="{{url('Horizontal/dist/assets/libs/jquery-knob/jquery.knob.min.js')}}"></script>

<!--Morris Chart-->
<script src="{{url('Horizontal/dist/assets/libs/morris-js/morris.min.js')}}"></script>
<script src="{{url('Horizontal/dist/assets/libs/raphael/raphael.min.js')}}"></script>

<!-- App js -->
<script src="{{url('Horizontal/dist/assets/js/app.min.js')}}"></script>

</body>
</html>
