@extends('theme.master')

@section('body')

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
            </div>
        </div>
    </div>

@endsection

