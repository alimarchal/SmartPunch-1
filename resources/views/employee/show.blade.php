@extends('theme.master')

@section('body')

    <div class="row justify-content-center mt-3">
        <div class="form-group text-center col-sm-3">
            <form action="{{route('employeeAttendanceShowByMonth', encrypt($employee->id))}}" method="GET">
                <label for="datepicker">{{__('portal.Select Month')}}</label>
                <div class="input-group">
                    @if(isset($date))
                        <input type="text" class="form-control" name="date" style="cursor: pointer" placeholder="M-yyyy" value="{{$date}}" id="datepicker" readonly>
                    @else
                        <input type="text" class="form-control" name="date" style="cursor: pointer" placeholder="M-yyyy" id="datepicker" readonly>
                    @endif
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="ti-calendar"></i></span>
                    </div>
                </div><!-- input-group -->
                <button class="btn btn-primary btn-rounded mt-2 waves-effect waves-light" type="submit">{{__('portal.Submit')}}</button>
            </form>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-xl-12 text-center">
            <div class="card-box">
                @if(isset($date))
                    <h4 class="header-title mt-0">{{ \Carbon\Carbon::parse($date)->monthName . ' ' . __('portal.Monthly attendance')}}</h4>
                @else
                    <h4 class="header-title mt-0">{{ \Carbon\Carbon::now()->monthName . ' ' . __('portal.Monthly attendance')}}</h4>
                @endif
                <div id="monthly-attendance-morris-bar" dir="ltr" style="height: 280px;" class="morris-chart"></div>
            </div>
        </div><!-- end col -->
    </div>

    <div class="row">
        <div class="col-xl-6 mx-auto">
            @can('update employee')
            <div class="form-group text-right mb-0 mt-2">
                <a href="{{route('employeeEdit', encrypt($employee->id))}}" class="btn btn-purple waves-effect waves-light mr-1 text-white"> {{__('portal.Updated employee details')}} </a>
            </div>
            @endcan
            <div class="card-box mt-3">

                <h4 class="header-title mt-0 mb-3 text-center">{{__('portal.Employee Details')}}</h4>

                <div class="form-group">
                    <label for="name">{{__('portal.Name')}}</label>
                    <input type="text" class="form-control" id="name" value="{{$employee->name}}" disabled>
                </div>

                <div class="form-group">
                    <label for="email">{{__('portal.Email')}}</label>
                    <input type="email" class="form-control" id="email" value="{{$employee->email}}" disabled>
                </div>

                @if(isset($employee->phone))
                    <div class="form-group">
                        <label for="phone">{{__('portal.Phone')}}</label>
                        <input type="tel" class="form-control" id="phone" value="{{$employee->phone}}" disabled>
                    </div>
                @endif

                @if(isset($employee->employee_business_id))
                    <div class="form-group">
                        <label for="employeeBusinessID">{{__('portal.Employee ID')}}</label>
                        <input type="text" class="form-control" id="employeeBusinessID" value="{{$employee->employee_business_id}}" disabled>
                    </div>
                @endif

                <div class="form-group">
                    <label for="status">{{__('portal.Status')}}</label>

                    <select class="custom-select" id="status" disabled>
                        <option>@if($employee->status == 1) {{__('portal.Active')}} @elseif($employee->active == 0) Suspended @endif </option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="officeName">{{__('portal.Office')}}</label>

                    <input class="form-control" id="officeName" disabled value="{{$employee->office->name}}">
                </div>

                <div class="form-group">
                    <label for="schedules">{{__('portal.Schedule assigned')}}</label>

                    <input class="form-control" id="schedules" disabled
                           @isset($userSchedule))
                           value="{{$userSchedule->schedule->name}}"
                           @endisset
                    >
                </div>

                <div class="form-group">
                    <label for="permissions">{{__('portal.Permissions')}}</label>

                    <textarea class="form-control" id="permissions" rows="4" disabled>@foreach($employee->getAllPermissions() as $permission){{ucfirst($permission->name)}} @if(!$loop->last), @endif @endforeach</textarea>
                </div>

                <div class="form-group">
                    <label for="attendanceType">{{__('portal.Attendance from')}}</label>

                    @if($employee->attendance_from == 0) {{-- Default 0 for APP and 1 for WEB --}}
                        <input class="form-control" id="attendanceType" disabled value="APP">
                    @else
                        <input class="form-control" id="attendanceType" disabled value="WEB">
                    @endif
                </div>

                <div class="form-group">
                    <label for="out_of_office">{{__('portal.Out of office attendance')}}</label>

                    @if($employee->out_of_office == 0) {{-- Default 0 for No and 1 for Yes --}}
                        <input class="form-control" id="out_of_office" disabled value="{{__('portal.No')}}">
                    @else
                        <input class="form-control" id="out_of_office" disabled value="{{__('portal.Yes')}}">
                    @endif
                </div>

            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <script>
        $("#datepicker").datepicker({
            format: 'M-yyyy',
            startView: "months",
            minViewMode: "months"
        });
    </script>

    <script>
        /* Bar chart for Direct Income */
        Morris.Bar({
            element: 'monthly-attendance-morris-bar',
            data: [
                    @foreach($data as $key => $value)
                        {
                        x: '{{$key}}',

                        Hrs: '{{\Carbon\Carbon::parse($value)->format('H:i:s')}}',
                        },
                    @endforeach
            ],
            xkey: 'x',
            ykeys: ['Hrs'],
            labels: ['Number of hours worked'],
        })
    </script>

@endsection

