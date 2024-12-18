@extends('theme.master')

@section('body')

    <div class="row mt-3">
        <div class="col-12">
            <div class="card-box">
                <h4 style="text-align: center;">{{__('portal.List of employees')}}</h4>

                <table id="datatable" class="table table-bordered dt-responsive nowrap">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{__('portal.Name')}}</th>
                        <th>{{__('portal.Email')}}</th>
                        <th>{{__('portal.Phone')}}</th>
                        <th>{{__('portal.Office assigned to')}}</th>
                        <th>{{__('portal.Schedule assigned')}}</th>
                        <th>{{__('portal.Action')}} </th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($employees as $employee)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$employee->name}}</td>
                            <td>{{$employee->email}}</td>
                            <td>{{$employee->phone}}</td>
                            <td>
                                @if(isset($employee->userOffice))
                                {{$employee->userOffice->office->name}}
                                @endif
                            </td>
                            <td>
                                @if(isset($employee->userSchedule))
                                    {{$employee->userSchedule->schedule->name}}
                                @endif
                            </td>
                            <td></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
