{{--<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <x-jet-welcome />
            </div>
        </div>
    </div>
</x-app-layout>--}}

@extends('theme.master')
@section('body')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="page-title">Dashboard</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    {{--<div class="row">

        <div class="col-xl-3 col-md-6">
            <div class="card-box">
                <div class="dropdown float-right">
                    <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-dots-vertical"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Action</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Another action</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Something else</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Separated link</a>
                    </div>
                </div>

                <h4 class="header-title mt-0 mb-4">Total Revenue</h4>

                <div class="widget-chart-1">
                    <div class="widget-chart-box-1 float-left" dir="ltr">
                        <input data-plugin="knob" data-width="80" data-height="80" data-fgColor="#f05050 "
                               data-bgColor="#F9B9B9" value="58"
                               data-skin="tron" data-angleOffset="180" data-readOnly=true
                               data-thickness=".15"/>
                    </div>

                    <div class="widget-detail-1 text-right">
                        <h2 class="font-weight-normal pt-2 mb-1"> 256 </h2>
                        <p class="text-muted mb-1">Revenue today</p>
                    </div>
                </div>
            </div>

        </div><!-- end col -->

        <div class="col-xl-3 col-md-6">
            <div class="card-box">
                <div class="dropdown float-right">
                    <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-dots-vertical"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Action</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Another action</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Something else</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Separated link</a>
                    </div>
                </div>

                <h4 class="header-title mt-0 mb-3">Sales Analytics</h4>

                <div class="widget-box-2">
                    <div class="widget-detail-2 text-right">
                        <span class="badge badge-success badge-pill float-left mt-3">32% <i class="mdi mdi-trending-up"></i> </span>
                        <h2 class="font-weight-normal mb-1"> 8451 </h2>
                        <p class="text-muted mb-3">Revenue today</p>
                    </div>
                    <div class="progress progress-bar-alt-success progress-sm">
                        <div class="progress-bar bg-success" role="progressbar"
                             aria-valuenow="77" aria-valuemin="0" aria-valuemax="100"
                             style="width: 77%;">
                            <span class="sr-only">77% Complete</span>
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- end col -->

        <div class="col-xl-3 col-md-6">
            <div class="card-box">
                <div class="dropdown float-right">
                    <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-dots-vertical"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Action</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Another action</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Something else</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Separated link</a>
                    </div>
                </div>

                <h4 class="header-title mt-0 mb-4">Statistics</h4>

                <div class="widget-chart-1">
                    <div class="widget-chart-box-1 float-left" dir="ltr">
                        <input data-plugin="knob" data-width="80" data-height="80" data-fgColor="#ffbd4a"
                               data-bgColor="#FFE6BA" value="80"
                               data-skin="tron" data-angleOffset="180" data-readOnly=true
                               data-thickness=".15"/>
                    </div>
                    <div class="widget-detail-1 text-right">
                        <h2 class="font-weight-normal pt-2 mb-1"> 4569 </h2>
                        <p class="text-muted mb-1">Revenue today</p>
                    </div>
                </div>
            </div>

        </div><!-- end col -->

        <div class="col-xl-3 col-md-6">
            <div class="card-box">
                <div class="dropdown float-right">
                    <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-dots-vertical"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Action</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Another action</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Something else</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Separated link</a>
                    </div>
                </div>

                <h4 class="header-title mt-0 mb-3">Daily Sales</h4>

                <div class="widget-box-2">
                    <div class="widget-detail-2 text-right">
                        <span class="badge badge-pink badge-pill float-left mt-3">32% <i class="mdi mdi-trending-up"></i> </span>
                        <h2 class="font-weight-normal mb-1"> 158 </h2>
                        <p class="text-muted mb-3">Revenue today</p>
                    </div>
                    <div class="progress progress-bar-alt-pink progress-sm">
                        <div class="progress-bar bg-pink" role="progressbar"
                             aria-valuenow="77" aria-valuemin="0" aria-valuemax="100"
                             style="width: 77%;">
                            <span class="sr-only">77% Complete</span>
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- end col -->

    </div>--}}
    <!-- end row -->

    <div class="row">
        <div class="col-xl-4">
            <div class="card-box">

                <h4 class="header-title mt-0">{{__('portal.Attendance insight')}}</h4>

                <div class="widget-chart text-center">
                    <div id="total-users-present-donut" dir="ltr" style="height: 245px;" class="morris-chart"></div>
                    <ul class="list-inline chart-detail-list mb-0">
                        <li class="list-inline-item">
                            <h5 style="color: #ff8acc;"><i class="fa fa-circle mr-1"></i>{{__('portal.Absent employees')}}</h5>
                        </li>
                        <li class="list-inline-item">
                            <h5 style="color: #5b69bc;"><i class="fa fa-circle mr-1"></i>{{__('portal.Present employees')}}</h5>
                        </li>
                    </ul>
                </div>
            </div>
        </div><!-- end col -->

        <div class="col-xl-4">
            <div class="card-box">
                <div class="dropdown float-right">
                    <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-dots-vertical"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Action</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Another action</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Something else</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Separated link</a>
                    </div>
                </div>
                <h4 class="header-title mt-0">Statistics</h4>
                <div id="morris-bar-example" dir="ltr" style="height: 280px;" class="morris-chart"></div>
            </div>
        </div><!-- end col -->

        <div class="col-xl-4">
            <div class="card-box">
                <div class="dropdown float-right">
                    <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-dots-vertical"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Action</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Another action</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Something else</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Separated link</a>
                    </div>
                </div>
                <h4 class="header-title mt-0">Total Revenue</h4>
                <div id="morris-line-example" dir="ltr" style="height: 280px;" class="morris-chart"></div>
            </div>
        </div><!-- end col -->

    </div>
    <!-- end row -->


    @if(auth()->user()->hasDirectPermission('view employee'))
    <div class="row">
        @foreach($employees->take(4) as $employee)
        <div class="col-xl-3 col-md-6">
            <div class="card-box widget-user">
                <div class="media">
                    <div class="avatar-lg mr-3">
                        @if (!isset($employee->profile_photo_path))
                            <img src="{{ $employee->profile_photo_url }}" alt="user-image" class="rounded-circle">
                        @else
                            <a href="{{route('employeeShow', encrypt($employee->id))}}" class="text-white"><img src="{{ Storage::url( $employee->profile_photo_path ) }}" alt="{{$employee->name}}" class="img-fluid rounded-circle"></a>
                        @endif
                    </div>
                    <div class="media-body overflow-hidden">
                        <h5 class="mt-0 mb-1"> <a href="{{route('employeeShow', encrypt($employee->id))}}" class="text-white"> {{$employee->name}} </a>
                            @if($employee->hasVerifiedEmail())
                                {{-- Verify icon --}}
                                <small style="color: limegreen"><b><i class="fa fa-check-circle"></i></b></small>
                                @if(auth()->user()->hasDirectPermission('delete employee'))
                                    {{-- Delete icon --}}
                                    {{-- Commented because to requiment change i.e user should not be deleted instead should be suspended --}}
                                    {{--                                        <small class="float-right mt-1"><b><a href="{{route('employeeDelete', encrypt($employee->id))}}" onclick="return confirm('Are you sure to delete?')"><i class="text-danger fa fa-trash-alt"></i></a></b></small>--}}
                                @endif
                                @if(auth()->user()->hasDirectPermission('update employee'))
                                    {{-- Edit icon --}}
                                    <small class="float-right mr-2 mt-1"><b><a href="{{route('employeeEdit', encrypt($employee->id))}}"><i class="fas fa-pencil-alt"></i></a></b></small>
                                @endif
                            @else
                                {{-- Verify icon --}}
                                <small class="text-danger"><b><i class="fa fa-times-circle"></i></b></small>
                                @if(auth()->user()->hasDirectPermission('delete employee'))
                                    {{-- Delete icon --}}
                                    {{-- Commented because to requiment change i.e user should not be deleted instead should be suspended --}}
                                    {{--                                        <small class="text-danger float-right mt-1"><b><a href="{{route('employeeDelete', encrypt($employee->id))}}" onclick="return confirm('Are you sure to delete?')"><i class="text-danger fa fa-trash-alt"></i></a></b></small>--}}
                                @endif
                            @endif
                        </h5>
                        <p class="text-muted mb-2 font-13 text-truncate">{{$employee->email}}</p>
                        @php $role = \Spatie\Permission\Models\Role::where('id', $employee->user_role)->pluck('name')->first(); @endphp

                        @if($role == 'admin') <small><b> <a href="{{route('employeeShow', encrypt($employee->id))}}" class="text-secondary"> {{ucfirst($role)}} @if($employee->status == 0) <span class="badge badge-danger"> {{__('portal.Suspended')}}</span> @endif  </a></b></small><br> @endif
                        @if($role == 'manager') <small><b> <a href="{{route('employeeShow', encrypt($employee->id))}}" class="text-primary"> {{ucfirst($role)}} @if($employee->status == 0) <span class="badge badge-danger"> {{__('portal.Suspended')}}</span> @endif </a></b></small><br> @endif
                        @if($role == 'supervisor') <small><b> <a href="{{route('employeeShow', encrypt($employee->id))}}" style="color: #C46210"> {{ucfirst($role)}} @if($employee->status == 0) <span class="badge badge-danger"> {{__('portal.Suspended')}}</span> @endif  </a></b></small><br> @endif
                        @if($role == 'employee') <small><b> <a href="{{route('employeeShow', encrypt($employee->id))}}" class="text-pink"> {{ucfirst($role)}} @if($employee->status == 0) <span class="badge badge-danger"> ({{__('portal.Suspended')}}</span> @endif  </a></b></small><br> @endif

                    </div>
                </div>
            </div>
        </div>
            <!-- end col -->
        @endforeach

    </div>
    <!-- end row -->
    @endif

    @if($employees->count() > 4)
    <div class="row justify-content-end mr-1 mb-3">
        <a href="{{ route('employeeIndex')  }}"><span style="color: #adb5b2;" onMouseOver="this.style.color='#00bfff'" onMouseOut="this.style.color='#adb5b2'">View more</span></a>
    </div>
    @endif


    <div class="row">
        <div class="col-xl-4">
            <div class="card-box">
                <div class="dropdown float-right">
                    <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-dots-vertical"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Action</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Another action</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Something else</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Separated link</a>
                    </div>
                </div>

                <h4 class="header-title mb-3">Inbox</h4>

                <div class="inbox-widget">

                    <div class="inbox-item">
                        <a href="#">
                            <div class="inbox-item-img"><img src="assets/images/users/user-1.jpg" class="rounded-circle" alt=""></div>
                            <h5 class="inbox-item-author mt-0 mb-1">Chadengle</h5>
                            <p class="inbox-item-text">Hey! there I'm available...</p>
                            <p class="inbox-item-date">13:40 PM</p>
                        </a>
                    </div>

                    <div class="inbox-item">
                        <a href="#">
                            <div class="inbox-item-img"><img src="assets/images/users/user-2.jpg" class="rounded-circle" alt=""></div>
                            <h5 class="inbox-item-author mt-0 mb-1">Tomaslau</h5>
                            <p class="inbox-item-text">I've finished it! See you so...</p>
                            <p class="inbox-item-date">13:34 PM</p>
                        </a>
                    </div>

                    <div class="inbox-item">
                        <a href="#">
                            <div class="inbox-item-img"><img src="assets/images/users/user-3.jpg" class="rounded-circle" alt=""></div>
                            <h5 class="inbox-item-author mt-0 mb-1">Stillnotdavid</h5>
                            <p class="inbox-item-text">This theme is awesome!</p>
                            <p class="inbox-item-date">13:17 PM</p>
                        </a>
                    </div>

                    <div class="inbox-item">
                        <a href="#">
                            <div class="inbox-item-img"><img src="assets/images/users/user-4.jpg" class="rounded-circle" alt=""></div>
                            <h5 class="inbox-item-author mt-0 mb-1">Kurafire</h5>
                            <p class="inbox-item-text">Nice to meet you</p>
                            <p class="inbox-item-date">12:20 PM</p>
                        </a>
                    </div>

                    <div class="inbox-item">
                        <a href="#">
                            <div class="inbox-item-img"><img src="assets/images/users/user-5.jpg" class="rounded-circle" alt=""></div>
                            <h5 class="inbox-item-author mt-0 mb-1">Shahedk</h5>
                            <p class="inbox-item-text">Hey! there I'm available...</p>
                            <p class="inbox-item-date">10:15 AM</p>
                        </a>
                    </div>
                </div>
            </div>
        </div><!-- end col -->

        <div class="col-xl-8">
            <div class="card-box">
                <div class="dropdown float-right">
                    <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-dots-vertical"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Action</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Another action</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Something else</a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">Separated link</a>
                    </div>
                </div>

                <h4 class="header-title mt-0 mb-3">Latest Projects</h4>

                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Project Name</th>
                            <th>Start Date</th>
                            <th>Due Date</th>
                            <th>Status</th>
                            <th>Assign</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1</td>
                            <td>Adminto Admin v1</td>
                            <td>01/01/2017</td>
                            <td>26/04/2017</td>
                            <td><span class="badge badge-danger">Released</span></td>
                            <td>Coderthemes</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Adminto Frontend v1</td>
                            <td>01/01/2017</td>
                            <td>26/04/2017</td>
                            <td><span class="badge badge-success">Released</span></td>
                            <td>Adminto admin</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Adminto Admin v1.1</td>
                            <td>01/05/2017</td>
                            <td>10/05/2017</td>
                            <td><span class="badge badge-pink">Pending</span></td>
                            <td>Coderthemes</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Adminto Frontend v1.1</td>
                            <td>01/01/2017</td>
                            <td>31/05/2017</td>
                            <td><span class="badge badge-purple">Work in Progress</span>
                            </td>
                            <td>Adminto admin</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Adminto Admin v1.3</td>
                            <td>01/01/2017</td>
                            <td>31/05/2017</td>
                            <td><span class="badge badge-warning">Coming soon</span></td>
                            <td>Coderthemes</td>
                        </tr>

                        <tr>
                            <td>6</td>
                            <td>Adminto Admin v1.3</td>
                            <td>01/01/2017</td>
                            <td>31/05/2017</td>
                            <td><span class="badge badge-primary">Coming soon</span></td>
                            <td>Adminto admin</td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- end col -->

    </div>
    <!-- end row -->

@endsection

@section('scripts')

    <script>
        Morris.Donut({
            element: 'total-users-present-donut',
            data: [
                {
                    label: "Present employees",
                    value: {{ $presentEmployees->unique('user_id')->count() }}
                },
                {
                    label: "Absent employees",
                    value: {{ $absentEmployees->count() }}
                }
            ],
            // labelColor: '#9CC4E4', // text color
            backgroundColor: '#333333', // border color
            colors: [
                '#5b69bc',
                '#ff8acc',
            ],
            // formatter: function (y, data) { return '$' + y }
        });
    </script>

@endsection
