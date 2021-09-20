{{--<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-jet-label for="name" value="{{ __('Name') }}" />
                <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-jet-label for="terms">
                        <div class="flex items-center">
                            <x-jet-checkbox name="terms" id="terms"/>

                            <div class="ml-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-jet-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-jet-button class="ml-4">
                    {{ __('Register') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>--}}

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

    <!-- Bootstrap Css -->
    <link href="{{url('Horizontal/dist/assets/css/bootstrap-dark.min.css')}}" id="bootstrap-stylesheet" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{url('Horizontal/dist/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{url('Horizontal/dist/assets/css/app-dark.min.css')}}" id="app-stylesheet" rel="stylesheet" type="text/css" />

</head>

<body class="authentication-bg">

<div class="account-pages mt-5 mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="text-center">
                    <a href="{{route('login')}}" class="logo">
                        <img src="{{url('logo.png')}}" alt="" height="64" class="logo-light mx-auto">
                    </a>
                    <p class="mt-2 mb-4 font-italic" style="font-size: 25px; color: #76ABDC;">{{__('register.SmartPunch')}}</p>
                </div>
                <div class="card">

                    <div class="card-body p-4">

                        <div class="text-center mb-4">
                            <h4 class="text-uppercase mt-0">{{__('register.Register')}}</h4>
                        </div>

                        <form method="POST" action="{{ route('register') }}">
                                @csrf
                            <div class="form-group">
                                <label for="fullname">{{__('register.Full Name')}}</label>
                                <input class="form-control @error('name') parsley-error @enderror" type="text" name="name" id="fullname" placeholder="{{__('register.Enter your name')}}" value="{{old('name')}}" required>

                                @error('name')
                                <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('name') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="emailaddress">{{__('register.Email address')}}</label>
                                <input class="form-control @error('email') parsley-error @enderror" type="email" name="email" id="emailaddress" placeholder="{{__('register.Enter your email')}}" value="{{old('email')}}" required>

                                @error('email')
                                <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('email') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password">{{__('register.Password')}}</label>
                                <input class="form-control @error('password') parsley-error @enderror" type="password" name="password" id="password" placeholder="{{__('register.Enter your password')}}" required>

                                @error('password')
                                <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false">
                                    <li class="parsley-required"> @foreach ($errors->get('password') as $error) <li>{{ $error }}</li> @endforeach </li></ul>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password">{{__('register.Confirm Password')}}</label>
                                <input class="form-control" type="password" name="password_confirmation" id="password" placeholder="{{__('register.Confirm Password')}}" required>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="checkbox-signup" name="terms" required>
                                    <label class="custom-control-label" for="checkbox-signup">{{__('register.I accept')}} <a href="{{route('terms.show')}}" target="_blank" class="text-dark">{{__('register.Terms and Conditions')}}</a></label>
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
                        <p class="text-white">{{__('register.Already have account?')}} <a href="{{route('login')}}" class="text-dark ml-1"><b style="color: #2890f6">{{__('register.Sign In')}}</b></a></p>
                    </div> <!-- end col -->
                </div>
                <!-- end row -->

            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- end page -->


<!-- Vendor js -->
<script src="{{url('Horizontal/dist/assets/js/vendor.min.js')}}"></script>

<!-- App js -->
<script src="{{url('Horizontal/dist/assets/js/app.min.js')}}"></script>

</body>
</html>

