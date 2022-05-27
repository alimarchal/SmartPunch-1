<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>{{config('app.name')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{url('logo.png')}}">

    {{-- select2 scripts start --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    {{-- select2 scripts end --}}

    <!-- Bootstrap Css -->
    <link href="{{url('Horizontal/dist/assets/css/bootstrap-dark.min.css')}}" id="bootstrap-stylesheet" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{url('Horizontal/dist/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{url('Horizontal/dist/assets/css/app-dark.min.css')}}" id="app-stylesheet" rel="stylesheet" type="text/css" />

    <style>
        .form-control:focus {
            border-color: dodgerblue !important;
        }
        .custom-select:focus {
            border-color: dodgerblue !important;
        }
    </style>

</head>

<body class="authentication-bg">

    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="text-center">
                        <a href="{{route('home')}}" class="logo">
                            <img src="{{url('logo.png')}}" alt="" height="100" class="logo-light mx-auto">
                        </a>
                        <p class="mt-2 mb-4 font-italic" style="font-size: 25px; color: #76ABDC;">{{__('register.SmartPunch')}}</p>
                    </div>

                    <div class="card">
                        <div class="card-body p-4">
                            <div class="text-center mb-4">
                                <h4 class="text-uppercase mt-0">{{__('register.Register')}}</h4>
                            </div>

                            <form method="POST" action="{{ route('ibr.register') }}">
                                @csrf

                                <div class="form-group">
                                    <label for="referred_no">{{__('register.Referral IBR number (If any) ')}}</label>
                                    <input type="text" name="referred_by" id="referred_no" placeholder="{{__('register.Enter reference IBR number')}}" value="{{old('referred_by')}}" class="form-control @error('referred_by') parsley-error @enderror">
                                    @error('referred_by')
                                    <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required"> @foreach ($errors->get('referred_by') as $error) <li>{{ $error }}</li> @endforeach </li></ul>
                                    @enderror
                                    <x-jet-label for="referred_no_response_found" id="referred_no_response" value="" class="mb-2" style="color: green"/>
                                    <x-jet-label for="referred_no_response_not_found" id="referred_no_response_not_found" value="" class="mb-2 text-danger" style="color: red"/>
                                </div>

                                <div class="form-group">
                                    <label for="name">{{__('register.Full Name')}} <span style="color: red">*</span> </label>
                                    <input type="text" name="name" autofocus id="name" placeholder="{{__('register.Enter your name')}}" value="{{old('name')}}" class="form-control @error('name') parsley-error @enderror" required>

                                    @error('name')
                                    <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('name') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email">{{__('register.Email address')}} <span style="color: red">*</span> </label>
                                    <input type="email" name="email" id="email" placeholder="{{__('register.Enter your email')}}" value="{{old('email')}}" class="form-control @error('email') parsley-error @enderror" required>

                                    @error('email')
                                    <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('email') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password">{{__('register.Password')}} <span style="color: red">*</span> </label>
                                    <div class="input-group mb-3">
                                        <input type="password" name="password" id="password" placeholder="{{__('register.Enter your password')}}" class="form-control @error('password') parsley-error @enderror" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text" onclick="password_show_hide();">
                                              <i class="fas fa-eye" id="show_eye"></i>
                                              <i class="fas fa-eye-slash d-none" id="hide_eye"></i>
                                            </span>
                                        </div>
                                    </div>

                                    @error('password')
                                    <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required"> @foreach ($errors->get('password') as $error) <li>{{ $error }}</li> @endforeach </li></ul>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password_confirmation">{{__('register.Confirm Password')}} <span style="color: red">*</span> </label>
                                    <div class="input-group mb-3">
                                        <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" placeholder="{{__('register.Confirm Password')}}" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text" onclick="confirm_password_show_hide();">
                                              <i class="fas fa-eye" id="confirm_show_eye"></i>
                                              <i class="fas fa-eye-slash d-none" id="confirm_hide_eye"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="dob">{{__('register.Date of birth')}} <span style="color: red">*</span> </label>
                                    <input id="dob" name="dob" type="date" value="1990-01-01" max="<?= date('Y-m-d'); ?>" class="form-control @error('dob') parsley-error @enderror">
                                    @error('dob')
                                    <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required"> @foreach ($errors->get('dob') as $error) <li>{{ $error }}</li> @endforeach </li></ul>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="gender">{{__('register.Gender')}} <span style="color: red">*</span> </label>
                                    <select name="gender" id="gender" class="custom-select @error('gender') parsley-error @enderror" required>
                                        <option value="" selected>{{__('register.Select')}}</option>
                                        <option {{(old('gender') == 1 ? 'selected' : '')}} value="1">Male</option>
                                        <option {{(old('gender') == 2 ? 'selected' : '')}} value="2">Female</option>
                                    </select>
                                    @error('gender')
                                    <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required"> @foreach ($errors->get('gender') as $error) <li>{{ $error }}</li> @endforeach </li></ul>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="country_of_business">{{__('register.Country of business')}} <span style="color: red">*</span> </label>
                                    <select name="country_of_business" id="country_of_business" class="custom-select countries @error('country_of_business') parsley-error @enderror" required>
                                        <option value="" selected>{{__('register.Select')}}</option>
                                        @foreach($countries as $country)
                                        <option value="{{$country->id}}">{{$country->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('country_of_business')
                                    <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required"> @foreach ($errors->get('country_of_business') as $error) <li>{{ $error }}</li> @endforeach </li></ul>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="city_of_business">{{__('register.City of business')}} <span style="color: red">*</span> </label>
                                    <select name="city_of_business" id="city_of_business" class="custom-select @error('city_of_business') parsley-error @enderror" disabled>
                                        <option value="" selected>{{__('register.Select')}}</option>
                                    </select>
                                    @error('city_of_business')
                                    <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required"> @foreach ($errors->get('city_of_business') as $error) <li>{{ $error }}</li> @endforeach </li></ul>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="country_of_bank">{{__('register.Country of bank')}} <span style="color: red">*</span> </label>
                                    <select name="country_of_bank" id="country_of_bank" class="custom-select countries_of_bank @error('country_of_bank') parsley-error @enderror" required>
                                        <option value="" selected>{{__('register.Select')}}</option>
                                        @foreach($countries as $country)
                                        <option {{(old('country_of_bank') == $country->id ? 'selected' : '')}} value="{{$country->id}}">{{$country->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('country_of_bank')
                                    <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required"> @foreach ($errors->get('country_of_bank') as $error) <li>{{ $error }}</li> @endforeach </li></ul>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="bank">{{__('register.Bank')}} <span style="color: red">*</span> </label>
                                    <input type="text" name="bank" id="bank" placeholder="{{__('register.Enter bank name')}}" value="{{old('bank')}}" class="form-control @error('bank') parsley-error @enderror" required>
                                    @error('bank')
                                    <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required"> @foreach ($errors->get('bank') as $error) <li>{{ $error }}</li> @endforeach </li></ul>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="iban">{{__('register.IBAN')}} <span style="color: red">*</span> </label>
                                    <input type="text" name="iban" id="iban" placeholder="{{__('register.Enter IBAN')}}" value="{{old('iban')}}" class="form-control @error('iban') parsley-error @enderror" required>
                                    @error('iban')
                                    <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required"> @foreach ($errors->get('iban') as $error) <li>{{ $error }}</li> @endforeach </li></ul>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="currency">{{__('register.Currency')}} <span style="color: red">*</span> </label>
                                    <select name="currency" id="currency" class="custom-select @error('currency') parsley-error @enderror" required>
                                        <option value="" selected>{{__('register.Select')}}</option>
                                        @foreach($currencies as $currency)
                                            <option {{(old('currency') == $currency->id ? 'selected' : '')}} value="{{ $currency->id }}">{{ $currency->value }}</option>
                                        @endforeach
                                    </select>
                                    @error('currency')
                                    <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required"> @foreach ($errors->get('currency') as $error) <li>{{ $error }}</li> @endforeach </li></ul>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="mobile_number">{{__('register.Mobile number')}} <span style="color: red">*</span> </label>
                                    <input type="text" name="mobile_number" id="mobile_number" placeholder="{{__('register.Enter mobile number')}}" value="{{old('mobile_number')}}" class="form-control @error('mobile_number') parsley-error @enderror" required>
                                    @error('mobile_number')
                                    <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required"> @foreach ($errors->get('mobile_number') as $error) <li>{{ $error }}</li> @endforeach </li></ul>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="checkbox-signup" name="terms" required>
                                        <label class="custom-control-label" for="checkbox-signup">{{__('register.I accept')}} <a href="{{route('terms.show')}}" target="_blank" class="text-blue">{{__('register.Terms and Conditions')}}</a> <span style="color: red">*</span> </label>
                                    </div>

                                    @error('terms')
                                    <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">{{__('register.Please read and accept terms of service and privacy policy.')}}</li></ul>
                                    @enderror
                                </div>

                                <div class="form-group mb-0 text-center">
                                    <button class="btn btn-primary btn-block" type="submit"> {{__('register.Sign Up')}} </button>
                                </div>

                            </form>

                        </div> <!-- end card-body -->
                    </div>


                    <!-- end card -->

                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p class="text-white">{{__('register.Already have account?')}} <a href="{{route('ibr.login')}}" class="text-dark ml-1"><b style="color: #2890f6">{{__('register.Sign In')}}</b></a></p>
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
    <script>
        $(document).ready(function() {
            $('.countries_of_bank').select2();
        });

        $("#country_of_business").select2().on("change", function () {
            let option = '';
            $('#city_of_business').prop('disabled', true);
            $.ajax({
                url: "{{route('ibr.search-cities')}}",
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: $('#country_of_business').val(),
                },
                success: function(result){
                    $('#city_of_business').prop('disabled', false);
                    $('#city_of_business').empty();
                    $('#city_of_business').append(' <option disabled selected value="">Select</option>');
                    result.cities.forEach(function (city, index) {
                        option = "<option value='" + city.id + "'>" + city.name + "</option>"
                        $('#city_of_business').append(option);
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

<!-- App js -->
<script src="{{url('Horizontal/dist/assets/js/app.min.js')}}"></script>

<script>
    $('#referred_no').on('keyup', function () {
        let $value = $(this).val();
        $.ajax({
            type: 'get',
            url: "{{ route('ibr.search_ibr') }}",
            data: {'referred_no': $value},
            success: function (response) {
                if (response.status === 0) {
                    $('#referred_no_response').empty();
                    $('#referred_no_response_not_found').html('Not record found');
                } else {
                    $('#referred_no_response_not_found').empty();
                    $('#referred_no_response').html('Reference Verified: ' + response.data);
                }
            }
        });
    })

    function password_show_hide() {
        var x = document.getElementById("password");
        var show_eye = document.getElementById("show_eye");
        var hide_eye = document.getElementById("hide_eye");
        hide_eye.classList.remove("d-none");
        if (x.type === "password") {
            x.type = "text";
            show_eye.style.display = "none";
            hide_eye.style.display = "block";
        } else {
            x.type = "password";
            show_eye.style.display = "block";
            hide_eye.style.display = "none";
        }
    }

    function confirm_password_show_hide() {
        var x = document.getElementById("password_confirmation");
        var show_eye = document.getElementById("confirm_show_eye");
        var hide_eye = document.getElementById("confirm_hide_eye");
        hide_eye.classList.remove("d-none");
        if (x.type === "password") {
            x.type = "text";
            show_eye.style.display = "none";
            hide_eye.style.display = "block";
        } else {
            x.type = "password";
            show_eye.style.display = "block";
            hide_eye.style.display = "none";
        }
    }

</script>

</body>
</html>
