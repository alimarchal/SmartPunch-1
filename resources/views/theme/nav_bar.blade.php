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

            @php $locale = session()->get('locale'); @endphp
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    @switch($locale)
                        @case('ar')
                        <img src="{{asset('flags/ar.png')}}" width="30px" height="20x"> Arabic
                        @break
                        @case('ur')
                        <img src="{{asset('flags/ur.png')}}" width="30px" height="20x"> Urdu
                        @break
                        @case('ru')
                        <img src="{{asset('flags/ru.png')}}" width="30px" height="20x"> Russian
                        @break
                        @case('fr')
                        <img src="{{asset('flags/fr.png')}}" width="30px" height="20x"> French
                        @break
                        @case('es')
                        <img src="{{asset('flags/es.png')}}" width="30px" height="20x"> Spanish
                        @break
                        @case('de')
                        <img src="{{asset('flags/de.png')}}" width="30px" height="20x"> German
                        @break
                        @case('it')
                        <img src="{{asset('flags/it.png')}}" width="30px" height="20x"> Italian
                        @break
                        @case('ja')
                        <img src="{{asset('flags/ja.png')}}" width="30px" height="20x"> Japanese
                        @break
                        @case('ko')
                        <img src="{{asset('flags/ko.png')}}" width="30px" height="20x"> Korean
                        @break
                        @case('zh')
                        <img src="{{asset('flags/zh.png')}}" width="30px" height="20x"> Chinese
                        @break
                        @case('nl')
                        <img src="{{asset('flags/nl.png')}}" width="30px" height="20x"> Dutch
                        @break
                        @case('sw')
                        <img src="{{asset('flags/sw.png')}}" width="30px" height="20x"> Swahili
                        @break
                        @case('fil')
                        <img src="{{asset('flags/fil.png')}}" width="30px" height="20x"> Filipino
                        @break
                        @case('fa')
                        <img src="{{asset('flags/fa.png')}}" width="30px" height="20x"> Persian
                        @break
                        @case('tr')
                        <img src="{{asset('flags/tr.png')}}" width="30px" height="20x"> Turkish
                        @break
                        @default
                        <img src="{{asset('flags/us.png')}}" width="30px" height="20x"> English
                    @endswitch
                    <span class="caret"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{url('lang/en')}}"><img src="{{asset('flags/us.png')}}" width="30px" height="20x"> English</a>
{{--                    <a class="dropdown-item" href="{{url('lang/ar')}}"><img src="{{asset('flags/ar.png')}}" width="30px" height="20x"> Arabic</a>--}}
{{--                    <a class="dropdown-item" href="{{url('lang/ur')}}"><img src="{{asset('flags/ur.png')}}" width="30px" height="20x"> Urdu</a>--}}
                    <a class="dropdown-item" href="{{url('lang/fr')}}"><img src="{{asset('flags/ru.png')}}" width="30px" height="20x"> Russian</a>
                    <a class="dropdown-item" href="{{url('lang/fr')}}"><img src="{{asset('flags/fr.png')}}" width="30px" height="20x"> French</a>
                    <a class="dropdown-item" href="{{url('lang/es')}}"><img src="{{asset('flags/es.png')}}" width="30px" height="20x"> Spanish</a>
                    <a class="dropdown-item" href="{{url('lang/de')}}"><img src="{{asset('flags/de.png')}}" width="30px" height="20x"> German</a>
                    <a class="dropdown-item" href="{{url('lang/it')}}"><img src="{{asset('flags/it.png')}}" width="30px" height="20x"> Italian</a>
                    <a class="dropdown-item" href="{{url('lang/ja')}}"><img src="{{asset('flags/ja.png')}}" width="30px" height="20x"> Japanese</a>
                    <a class="dropdown-item" href="{{url('lang/ko')}}"><img src="{{asset('flags/ko.png')}}" width="30px" height="20x"> Korean</a>
                    <a class="dropdown-item" href="{{url('lang/zh')}}"><img src="{{asset('flags/zh.png')}}" width="30px" height="20x"> Chinese</a>
                    <a class="dropdown-item" href="{{url('lang/nl')}}"><img src="{{asset('flags/nl.png')}}" width="30px" height="20x"> Dutch</a>
                    <a class="dropdown-item" href="{{url('lang/sw')}}"><img src="{{asset('flags/sw.png')}}" width="30px" height="20x"> Swahili</a>
                    <a class="dropdown-item" href="{{url('lang/fil')}}"><img src="{{asset('flags/fil.png')}}" width="30px" height="20x"> Filipino</a>
{{--                    <a class="dropdown-item" href="{{url('lang/fa')}}"><img src="{{asset('flags/fa.png')}}" width="30px" height="20x"> Persian</a>--}}
                    <a class="dropdown-item" href="{{url('lang/tr')}}"><img src="{{asset('flags/tr.png')}}" width="30px" height="20x"> Turkish</a>
                </div>
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
                    @if (!isset(auth()->user()->profile_photo_path))
                        <img src="{{ Auth::user()->profile_photo_url }}" alt="user-image" class="rounded-circle">
                    @else
                        <img src="{{ Storage::url( auth()->user()->profile_photo_path ) }}" alt="{{ auth()->user()->name }}" class="rounded-circle">
                    @endif
                    <span class="pro-user-name ml-1">
                         {{ Auth::user()->name }} <i class="mdi mdi-chevron-down"></i>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                    <!-- item-->
                    <div class="dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Welcome !</h6>
                    </div>

                    <!-- item-->
                    <a href="{{route('userProfileEdit')}}" class="dropdown-item notify-item">
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

                    @hasrole('admin')
                    <!-- item-->
                        <a href="{{route('package.index')}}" class="dropdown-item notify-item">
                            <i class="mdi mdi-account-cash-outline"></i>
                            <span>{{__('navBar.Package')}}</span>
                        </a>
                    @endhasrole

                    <div class="dropdown-divider"></div>

                    <!-- item-->

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <a href="{{ route('logout') }}"
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
            <a href="{{route('dashboard')}}" class="logo logo-light">
                <span class="logo-lg">
                    @if(isset(auth()->user()->business->company_logo))
                        <img src="{{ Storage::url( auth()->user()->business->company_logo) }}" alt="{{auth()->user()->business->company_name}}" style="border-radius: 50%;" height="44" width="50">
                    @elseif(!isset(auth()->user()->business->company_logo) && is_null(auth()->user()->business->company_logo))
                        <img src="{{url('no-image.png')}}" alt="" height="44">
                    @else
                        <img src="{{url('logo.png')}}" alt="" height="44">
                    @endif
                    @php $role = \Spatie\Permission\Models\Role::where('id', auth()->user()->user_role)->pluck('name')->first(); @endphp
                    <span class="ml-1 text-white">{{ucfirst($role)}}</span>
                </span>
                <span class="logo-sm">
                    @if(isset(auth()->user()->business->company_logo))
                        <img src="{{ Storage::url( auth()->user()->business->company_logo) }}" alt="{{auth()->user()->business->company_name}}" style="border-radius: 50%;" height="44" width="50">
                    @else
                        <img src="{{url('logo.png')}}" alt="" height="44">
                    @endif
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
                    <a href="{{route('dashboard')}}"><i class="mdi mdi-view-dashboard"></i>{{__('navBar.Dashboard')}}</a>
                </li>

                @can('view office')
                    <li class="has-submenu">
                        <a href="javascript:void(0)"> <i class="fa fa-building"></i>{{__('navBar.Offices')}}
                            <div class="arrow-down"></div>
                        </a>
                        <ul class="submenu megamenu">
                            <li>
                                <ul>
                                    @can('create office')
                                        <li>
                                            <a href="{{route('officeCreate')}}"><i class="fa fa-plus-circle"></i> {{__('navBar.Add')}}</a>
                                        </li>
                                    @endcan
                                    <li>
                                        <a href="{{route('officeIndex')}}"><i class="fa fa-eye"></i> {{__('navBar.View')}}</a>
                                    </li>

                                </ul>
                            </li>
                        </ul>
                    </li>
                @endcan

                @can('view employee')
                    <li class="has-submenu">
                        <a href="javascript:void(0)"> <i class="mdi mdi-account-multiple"></i>{{__('navBar.Employees')}}
                            <div class="arrow-down"></div>
                        </a>
                        <ul class="submenu">
                            @can('create employee')
                                <li>
                                    <a href="{{route('employeeCreate')}}"><i class="fa fa-plus-circle"></i> {{__('navBar.Add')}}</a>
                                </li>
                            @endcan
                            <li>
                                <a href="{{route('employeeIndex')}}"><i class="fa fa-eye"></i> {{__('navBar.View')}}</a>
                            </li>
                        </ul>
                    </li>
                @endcan

                @can('view schedule')
                    <li class="has-submenu">
                        <a href="javascript:void(0)"> <i class="mdi mdi-calendar-clock"></i>{{__('navBar.Schedules')}}
                            <div class="arrow-down"></div>
                        </a>
                        <ul class="submenu">
                            @can('create schedule')
                                <li>
                                    <a href="{{route('scheduleCreate')}}"><i class="fa fa-plus-circle"></i> {{__('navBar.Add')}}</a>
                                </li>
                            @endcan

                            @if(!auth()->user()->hasRole('employee'))
                            <li>
                                <a href="{{route('scheduleIndex')}}"><i class="fa fa-eye"></i> {{__('navBar.View')}}</a>
                            </li>
                            @endif

                            @if(!auth()->user()->hasRole('admin'))
                                <li>
                                    <a href="{{route('scheduleShow')}}"><i class="fa fa-eye"></i> {{__('navBar.My schedule')}}</a>
                                </li>
                            @endif

                        </ul>
                    </li>
                @endcan

                @can('view reports')
                    <li class="has-submenu">
                        <a href="javascript:void(0)"><i class="mdi mdi-file-multiple"></i>{{__('navBar.Reports')}}
                            <div class="arrow-down"></div>
                        </a>

                        <ul class="submenu">
                            @can('view reports by office')
                                <li>
                                    <a href="{{route('byOffice')}}"><i class="fa fa-building"></i> {{__('navBar.By office')}}</a>
                                </li>
                            @endcan

                            @can('view reports by employee business ID')
                                <li>
                                    <a href="{{route('byEmployeeBusiness')}}"><i class="fa fa-key"></i> {{__('navBar.By employee business ID')}}</a>
                                </li>
                            @endcan

                            @can('view reports by my team')
                                <li>
                                    <a href="{{route('reportByTeam')}}"><i class="fa fa-user-friends"></i> {{__('navBar.By my team')}}</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan

            </ul>
            <!-- End navigation menu -->

            <div class="clearfix"></div>
        </div>
        <!-- end #navigation -->
    </div>
    <!-- end container -->
</div>
<!-- end navbar-custom -->
