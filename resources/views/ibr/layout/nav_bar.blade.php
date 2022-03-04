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
                <a class="nav-link dropdown-toggle waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <i class="fe-bell noti-icon"></i>
                    <span class="badge badge-danger rounded-circle noti-icon-badge">9</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-lg">

                    <!-- item-->
                    <div class="dropdown-item noti-title">
                        <h5 class="m-0">
                            <span class="float-right">
                                <a href="" class="text-dark">
                                    <small>Clear All</small>
                                </a>
                            </span>Notification
                        </h5>
                    </div>

                    <div class="slimscroll noti-scroll">

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item active">
                            <div class="notify-icon">
                                <img src="{{url('Horizontal/dist/assets/images/users/user-1.jpg')}}" class="img-fluid rounded-circle" alt=""/></div>
                            <p class="notify-details">Cristina Pride</p>
                            <p class="text-muted mb-0 user-msg">
                                <small>Hi, How are you? What about our next meeting</small>
                            </p>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <div class="notify-icon bg-primary">
                                <i class="mdi mdi-comment-account-outline"></i>
                            </div>
                            <p class="notify-details">Caleb Flakelar commented on Admin
                                <small class="text-muted">1 min ago</small>
                            </p>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <div class="notify-icon">
                                <img src="{{url('Horizontal/dist/assets/images/users/user-4.jpg')}}" class="img-fluid rounded-circle" alt=""/></div>
                            <p class="notify-details">Karen Robinson</p>
                            <p class="text-muted mb-0 user-msg">
                                <small>Wow ! this admin looks good and awesome design</small>
                            </p>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <div class="notify-icon bg-warning">
                                <i class="mdi mdi-account-plus"></i>
                            </div>
                            <p class="notify-details">New user registered.
                                <small class="text-muted">5 hours ago</small>
                            </p>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <div class="notify-icon bg-info">
                                <i class="mdi mdi-comment-account-outline"></i>
                            </div>
                            <p class="notify-details">Caleb Flakelar commented on Admin
                                <small class="text-muted">4 days ago</small>
                            </p>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <div class="notify-icon bg-secondary">
                                <i class="mdi mdi-heart"></i>
                            </div>
                            <p class="notify-details">Carlos Crouch liked
                                <b>Admin</b>
                                <small class="text-muted">13 days ago</small>
                            </p>
                        </a>
                    </div>

                    <!-- All-->
                    <a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item notify-all">
                        View all
                        <i class="fi-arrow-right"></i>
                    </a>

                </div>
            </li>

            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <span class="pro-user-name ml-1">
                         {{ Auth::guard('ibr')->user()->name }} <i class="mdi mdi-chevron-down"></i>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                    <!-- item-->
                    <div class="dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Welcome !</h6>
                    </div>

                    <!-- item-->
                    <a href="{{route('ibr.userProfileEdit')}}" class="dropdown-item notify-item">
                        <i class="fe-user"></i>
                        <span>{{__('navBar.Profile')}}</span>
                    </a>

                    @can('view business')
                    <!-- item-->
                        <a href="{{route('businessIndex')}}" class="dropdown-item notify-item">
                            <i class="mdi mdi-briefcase"></i>
                            <span>{{__('navBar.Business')}}</span>
                        </a>
                    @endcan

                    <div class="dropdown-divider"></div>

                    <!-- item-->

                    <form method="POST" action="{{ route('ibr.logout') }}">
                        @csrf

                        <a href="{{ route('ibr.logout') }}"
                           onclick="event.preventDefault();
                                                this.closest('form').submit();" class="dropdown-item notify-item">
                            <i class="fe-log-out"></i>
                            <span>{{__('navBar.Logout')}}</span>
                        </a>
                    </form>

                </div>
            </li>

        </ul>

        <!-- LOGO -->
        <div class="logo-box">
            <a href="{{route('ibr.dashboard')}}" class="logo logo-light">
                <span class="logo-lg">
                    <img src="{{url('logo.png')}}" alt="" height="44">
                    <span class="ml-1 text-white">{{__('navBar.IBR')}}</span>
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

<div class="topbar-menu">
    <div class="container-fluid">
        <div id="navigation">
            <!-- Navigation Menu-->
            <ul class="navigation-menu">

                <li class="has-submenu">
                    <a href="{{route('ibr.dashboard')}}"><i class="mdi mdi-view-dashboard"></i>{{__('navBar.Dashboard')}}</a>
                </li>


                <li class="has-submenu">
                    <a href="javascript:void(0)"> <i class="mdi mdi-cash-multiple"></i>{{__('navBar.My earnings')}}
                        <div class="arrow-down"></div>
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="{{route('ibr.direct_earnings')}}"><i class="mdi mdi-cash"></i> {{__('navBar.Direct earnings')}}</a>
                        </li>
                        <li>
                            <a href="{{route('ibr.in_direct_earnings')}}"><i class="mdi mdi-cash"></i> {{__('navBar.Indirect earnings')}}</a>
                        </li>
                    </ul>
                </li>

                <li class="has-submenu">
                    <a href="{{route('ibr.business_referrals')}}"><i class="mdi mdi-briefcase"></i>{{__('navBar.My referred businesses')}}</a>
                </li>

                <li class="has-submenu">
                    <a href="{{route('ibr.ibr_referrals')}}"><i class="mdi mdi-account-multiple"></i>{{__('navBar.My referred IBRs')}}</a>
                </li>

            </ul>
            <!-- End navigation menu -->

            <div class="clearfix"></div>
        </div>
        <!-- end #navigation -->
    </div>
    <!-- end container -->
</div>
<!-- end navbar-custom -->
