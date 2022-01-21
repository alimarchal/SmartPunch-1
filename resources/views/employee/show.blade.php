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
                    <label for="userName">{{__('portal.Name')}}</label>
                    <input type="text" class="form-control" value="{{$employee->name}}" disabled>
                </div>

                <div class="form-group">
                    <label for="userName">{{__('portal.Email')}}</label>
                    <input type="email" class="form-control" value="{{$employee->email}}" disabled>
                </div>

                @if(isset($employee->phone))
                    <div class="form-group">
                        <label for="userName">{{__('portal.Phone')}}</label>
                        <input type="tel" class="form-control" value="{{$employee->phone}}" disabled>
                    </div>
                @endif

                @if(isset($employee->employee_business_id))
                    <div class="form-group">
                        <label for="userName">{{__('portal.Employee ID')}}</label>
                        <input type="text" class="form-control" value="{{$employee->employee_business_id}}" disabled>
                    </div>
                @endif

                <div class="form-group">
                    <label for="pass1">{{__('portal.Status')}}</label>

                    <select class="custom-select" disabled>
                        <option>@if($employee->status == 1) {{__('portal.Active')}} @elseif($employee->active == 0) Suspended @endif </option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="pass1">{{__('portal.Office')}}</label>

                    <input class="form-control" disabled value="{{$employee->office->name}}">
                </div>

                <div class="form-group">
                    <label for="pass1">{{__('portal.Schedule assigned')}}</label>

                    <input class="form-control" disabled
                           @isset($employee->userSchedules->schedule->name))
                           value="{{$employee->userSchedules->schedule->name}}"
                           @endisset
                    >
                </div>

                <div class="form-group">
                    <label for="pass1">{{__('portal.Permissions')}}</label>

                    <textarea class="form-control" rows="4" disabled>@foreach($employee->getAllPermissions() as $permission){{ucfirst($permission->name)}} @if(!$loop->last), @endif @endforeach</textarea>
                </div>
            </div>
        </div>
    </div>

@endsection

