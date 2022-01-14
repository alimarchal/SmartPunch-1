@extends('theme.master')

@section('body')
    <div class="row mt-3">
        <div class="col-12">
            <div class="card-box">
                <h4 style="text-align: center;">{{__('portal.Schedule assigned')}}</h4>

                <table id="datatable" class="table table-bordered dt-responsive nowrap">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{__('portal.Name')}}</th>
                        <th>{{__('portal.Start Time')}}</th>
                        <th>{{__('portal.End Time')}}</th>
                        <th>{{__('portal.Break Start Time')}}</th>
                        <th>{{__('portal.Break End Time')}}</th>
                        <th>{{__('portal.Office assigned to')}}</th>
                    </tr>
                    </thead>

                    <tbody>
                    @if(isset($userSchedule))
                        <tr>
                            <td>1</td>
                            <td>{{$userSchedule->schedule->name}}</td>
                            <td>{{$userSchedule->schedule->start_time}}</td>
                            <td>{{$userSchedule->schedule->end_time}}</td>
                            <td>{{$userSchedule->schedule->break_start}}</td>
                            <td>{{$userSchedule->schedule->break_end}}</td>
                            <td>{{auth()->user()->office->name}}</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
