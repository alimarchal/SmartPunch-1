@extends('theme.master')

@section('body')
    <div class="row mt-3">
        <div class="col-12">
            <div class="form-group text-right mb-0">
                <a href="{{route('officeIndex')}}" class="btn btn-purple waves-effect waves-light mr-1 text-white"> {{__('portal.Offices list')}} </a>
            </div>
            <div class="card-box mt-3">
                <h3 style="text-align: center;">{{__('portal.List of employees')}}</h3>
                <h4 style="text-align: center;">{{$office->name}}</h4>

                <table id="datatable" class="table table-bordered dt-responsive nowrap">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{__('portal.Name')}}</th>
                        <th>{{__('portal.Email')}}</th>
                        <th>{{__('portal.Employee ID')}}</th>
                        <th>{{__('portal.Role')}}</th>
                        <th>{{__('portal.Phone')}}</th>
                        <th>{{__('portal.Status')}}</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($office->employees as $employee)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$employee->name}}</td>
                            <td>{{$employee->email}}</td>
                            <td>{{$employee->employee_business_id}}</td>
                            @php $role = \Spatie\Permission\Models\Role::where('id', $employee->user_role)->pluck('name')->first(); @endphp
                            <td>{{ucfirst($role)}}</td>
                            <td>{{$employee->phone}}</td>
                            <td>
                                @if($employee->status == 1) <span style="color: limegreen">{{__('portal.Active')}}</span> @endif
                                @if($employee->status == 0) <span class="text-danger">{{__('portal.Suspended')}}</span> @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

