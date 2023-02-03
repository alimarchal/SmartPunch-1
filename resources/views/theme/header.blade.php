<head>
    <meta charset="utf-8"/>
    <title>SmartPunch</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description"/>
    <meta content="Coderthemes" name="author"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <!-- App favicon -->
    @if(isset(auth()->user()->business->company_logo) && !is_null(auth()->user()->business->company_logo))
        <link rel="shortcut icon" href="{{ Storage::url( auth()->user()->business->company_logo) }}">
    @elseif(!isset(auth()->user()->business->company_logo) && is_null(auth()->user()->business->company_logo))
        <link rel="shortcut icon" href="{{url('no-image.png')}}">
    @else
        <link rel="shortcut icon" href="{{url('logo.png')}}">
    @endif

    <!-- Notification css (Toastr) -->
    <link href="{{url('Horizontal/dist/assets/libs/toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    {{-- Select2 --}}
    <link href="{{url('Horizontal/dist/assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- third party css -->
    <link href="{{url('Horizontal/dist/assets/libs/datatables/dataTables.bootstrap4.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('Horizontal/dist/assets/libs/datatables/responsive.bootstrap4.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('Horizontal/dist/assets/libs/datatables/buttons.bootstrap4.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('Horizontal/dist/assets/libs/datatables/select.bootstrap4.css')}}" rel="stylesheet" type="text/css" />
    <!-- third party css end -->

    <link href="{{url('Horizontal/dist/assets/libs/bootstrap-datepicker/bootstrap-datepicker.css')}}" rel="stylesheet">
    <!-- Bootstrap Css -->
    <link href="{{url('Horizontal/dist/assets/css/bootstrap-dark.min.css')}}" id="bootstrap-stylesheet" rel="stylesheet" type="text/css"/>
    <!-- Icons Css -->
    <link href="{{url('Horizontal/dist/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- App Css-->
    @if(auth()->user()->rtl == 0)
        <link href="{{url('Horizontal/dist/assets/css/app-dark.min.css')}}" id="app-stylesheet" rel="stylesheet" type="text/css"/>
    @else
        <link href="{{url('Horizontal/dist/assets/css/app-dark-rtl.min.css')}}" id="app-stylesheet" rel="stylesheet" type="text/css"/>
    @endif

    @yield('css')

</head>

