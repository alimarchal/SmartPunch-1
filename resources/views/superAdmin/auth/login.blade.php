<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>{{config('app.name')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description"/>
    <meta content="Coderthemes" name="author"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{url('logo.png')}}">

    <!-- Bootstrap Css -->
    <link href="{{url('Horizontal/dist/assets/css/bootstrap-dark.min.css')}}" id="bootstrap-stylesheet" rel="stylesheet" type="text/css"/>
    <!-- Icons Css -->
    <link href="{{url('Horizontal/dist/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- App Css-->
    <link href="{{url('Horizontal/dist/assets/css/app-dark.min.css')}}" id="app-stylesheet" rel="stylesheet" type="text/css"/>
</head>

<body class="authentication-bg">

    <div class="account-pages mt-5 mb-5">
        <div class="container">

            <div class="row justify-content-center">

                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="text-center">
                        <a href="{{route('home')}}" class="logo mb-3">
                            <img src="{{url('logo.png')}}" alt="" height="64" class="logo-light mx-auto">
                        </a>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    <div class="card">

                        <div class="card-body p-4">

                            <div class="text-center mb-4">
                                <h4 class="text-uppercase mt-0">{{__('login.Sign In')}}</h4>
                            </div>

                            <form method="POST" action="{{ route('superAdmin.login') }}">
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="email">{{__('login.Email address')}}</label>
                                    <input class="form-control" type="email" name="email" id="email" value="{{old('email')}}" placeholder="{{__('login.Enter your email')}}" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="password">{{__('login.Password')}}</label>
                                    <input class="form-control" type="password" name="password" id="password" placeholder="{{__('login.Enter your password')}}" required>
                                </div>

                                <div class="form-group mb-0 text-center">
                                    <button class="btn btn-primary btn-block" type="submit">{{__('login.Log In')}}</button>
                                </div>

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
