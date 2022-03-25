@extends('theme.master')

@section('body')

    <div class="row justify-content-center mt-3">
        <div class="form-group text-center col-sm-3">
            <form action="{{route('byEmployeeBusinessID')}}" method="POST">
                @csrf

                <label for="employee">{{__('portal.Employee business IDs')}}</label>
                <select class="custom-select select2" name="employee_id" id="employee" required>
                    <option value="" selected>{{__('portal.Select')}}</option>
                    @foreach($employees as $employee)
                        <option @if(isset($sentEmployee)) {{$sentEmployee->id == $employee->id ? 'selected' : ''}} @endif value="{{$employee->id}}">{{$employee->employee_business_id}}</option>
                    @endforeach
                </select>

                <button class="btn btn-primary btn-rounded mt-2 waves-effect waves-light" type="submit">{{__('portal.Submit')}}</button>
            </form>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <div class="card-box">
                {{-- $sentOffice used inorder to show which office was selected --}}
                @if(!isset($sentEmployee))
                    <h4 style="text-align: center;">{{__('portal.Attendance by employee business ID')}}</h4>
                @else
                    <h4 style="text-align: center;">{{$sentEmployee->name . ' ' . __('portal.attendance')}}</h4>
                @endif

                <table id="datatable" class="table table-bordered dt-responsive nowrap">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{__('portal.Name')}}</th>
                        <th>{{__('portal.Time')}}</th>
                        <th>{{__('portal.Movement')}}</th>
{{--                        <th>{{__('portal.Total hours')}} </th>--}}
                    </tr>
                    </thead>

                    <tbody>
                    @if(!is_null($reports))
                        @foreach ($reports as $report)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$report->user->name}}</td>
                            <td>{{\Carbon\Carbon::parse($report->time)->format('g:i A')}}</td>
                            <td>@if($report->in_out_status == 1) <span style="color: lightgreen">{{__('portal.In')}}</span> @elseif($report->in_out_status == 0) <span style="color: red">{{__('portal.Out')}}</span> @else {{__('portal.N/A')}} @endif</td>
{{--                            <td>total</td>--}}
                        </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <link href="{{ url('select2/src/select2totree.css') }}" rel="stylesheet">
    <script src="{{ url('select2/src/select2totree.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>

@endsection
