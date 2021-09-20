<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>SmartPunch | Confirm mail</title>
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
                    <a class="logo">
                        <img src="{{url('logo.png')}}" alt="" height="64" class="logo-light mx-auto">
                    </a>
                    <p class="mt-2 mb-4 font-italic" style="font-size: 25px; color: #76ABDC;">{{__('register.SmartPunch')}}</p>
                </div>

                <div class="card text-center">

                    <div class="card-body p-4">

                        <div class="mb-4">
                            <h4 class="text-uppercase mt-0">{{__('register.Confirm Email')}}</h4>
                        </div>
                        <img src="{{url('Horizontal/dist/assets/images/mail_confirm.png')}}" alt="img" width="86" class="mx-auto d-block" />

                        <p class="text-muted font-14 mt-2">{{__('register.Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.')}}</p>

                        @if (session('status') == 'verification-link-sent')
                            <div class="mb-2 font-medium text-sm" style="text-align: center;color: #0da156">
                                {{ __('register.A new verification link has been sent to the email address you provided during registration.') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button class="btn btn-block btn-blue waves-effect waves-light mt-3" type="submit">{{ __('register.Resend Verification Email') }}</button>
                        </form>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-lighten-dark waves-effect  width-md waves-inverse mt-3" type="submit">{{ __('register.Logout') }}</button>
                        </form>

                    </div> <!-- end card-body -->
                </div>
                <!-- end card -->

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
