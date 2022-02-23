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
                                    <label for="name">{{__('register.Full Name')}}</label>
                                    <input type="text" name="name" autofocus id="name" placeholder="{{__('register.Enter your name')}}" value="{{old('name')}}" class="form-control @error('name') parsley-error @enderror" required>

                                    @error('name')
                                    <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('name') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email">{{__('register.Email address')}}</label>
                                    <input type="email" name="email" id="email" placeholder="{{__('register.Enter your email')}}" value="{{old('email')}}" class="form-control @error('email') parsley-error @enderror" required>

                                    @error('email')
                                    <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('email') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password">{{__('register.Password')}}</label>
                                    <input type="password" name="password" id="password" placeholder="{{__('register.Enter your password')}}" class="form-control @error('password') parsley-error @enderror" required>

                                    @error('password')
                                    <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required"> @foreach ($errors->get('password') as $error) <li>{{ $error }}</li> @endforeach </li></ul>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password">{{__('register.Confirm Password')}}</label>
                                    <input class="form-control" type="password" name="password_confirmation" id="password" placeholder="{{__('register.Confirm Password')}}" required>
                                </div>

                                <div class="form-group">
                                    <label for="dob">{{__('register.Date of birth')}}</label>
                                    <input id="dob" name="dob" type="date" value="1990-01-01" max="<?= date('Y-m-d'); ?>" class="form-control @error('dob') parsley-error @enderror">
                                    @error('dob')
                                    <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required"> @foreach ($errors->get('dob') as $error) <li>{{ $error }}</li> @endforeach </li></ul>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="gender">{{__('register.Gender')}}</label>
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
                                    <label for="country_of_business">{{__('register.Country of business')}}</label>
                                    <select name="country_of_business" id="country_of_business" class="custom-select countries @error('country_of_business') parsley-error @enderror" required>
                                        <option value="" selected>{{__('register.Select')}}</option>
                                        @foreach($countries as $country)
                                        <option {{(old('country_of_business') == 1 ? 'selected' : '')}} value="{{$country->country_id}}">{{$country->country_name}}</option>
                                        @endforeach
                                    </select>
                                    @error('country_of_business')
                                    <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required"> @foreach ($errors->get('country_of_business') as $error) <li>{{ $error }}</li> @endforeach </li></ul>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="country_of_bank">{{__('register.Country of bank')}}</label>
                                    <select name="country_of_bank" id="country_of_bank" class="custom-select countries @error('country_of_bank') parsley-error @enderror" required>
                                        <option value="" selected>{{__('register.Select')}}</option>
                                        @foreach($countries as $country)
                                        <option {{(old('country_of_bank') == 1 ? 'selected' : '')}} value="{{$country->country_id}}">{{$country->country_name}}</option>
                                        @endforeach
                                    </select>
                                    @error('country_of_bank')
                                    <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required"> @foreach ($errors->get('country_of_bank') as $error) <li>{{ $error }}</li> @endforeach </li></ul>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="bank">{{__('register.Bank')}}</label>
                                    <select name="bank" id="bank" class="custom-select @error('bank') parsley-error @enderror" required>
                                        <option value="" selected>{{__('register.Select')}}</option>
                                        <option {{(old('bank') == 1 ? 'selected' : '')}} value="1">Al Bank</option>
                                    </select>
                                    @error('bank')
                                    <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required"> @foreach ($errors->get('bank') as $error) <li>{{ $error }}</li> @endforeach </li></ul>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="iban">{{__('register.IBAN')}}</label>
                                    <input type="text" name="iban" id="iban" placeholder="{{__('register.Enter IBAN')}}" value="{{old('iban')}}" class="form-control @error('iban') parsley-error @enderror" required>
                                    @error('iban')
                                    <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required"> @foreach ($errors->get('iban') as $error) <li>{{ $error }}</li> @endforeach </li></ul>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="currency">{{__('register.Currency')}}</label>
                                    <select name="currency" id="currency" class="custom-select @error('currency') parsley-error @enderror" required>
                                        <option value="" selected>{{__('register.Select')}}</option>
                                        <option {{(old('currency') == 1 ? 'selected' : '')}} value="1">Dollar ($)</option>
                                    </select>
                                    @error('currency')
                                    <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required"> @foreach ($errors->get('currency') as $error) <li>{{ $error }}</li> @endforeach </li></ul>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="mobile_number">{{__('register.Mobile number')}}</label>
                                    <input type="text" name="mobile_number" id="mobile_number" placeholder="{{__('register.Enter mobile number')}}" value="{{old('mobile_number')}}" class="form-control @error('mobile_number') parsley-error @enderror" required>
                                    @error('mobile_number')
                                    <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required"> @foreach ($errors->get('mobile_number') as $error) <li>{{ $error }}</li> @endforeach </li></ul>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="checkbox-signup" name="terms" required>
                                        <label class="custom-control-label" for="checkbox-signup">{{__('register.I accept')}} <a href="{{route('terms.show')}}" target="_blank" class="text-blue">{{__('register.Terms and Conditions')}}</a></label>
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
            $('.countries').select2();
        });
        $(document).ready(function() {
            $('.countries').select2();
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
</script>

</body>
</html>
