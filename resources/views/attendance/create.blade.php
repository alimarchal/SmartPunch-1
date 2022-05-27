@extends('theme.master')

@section('body')

{{--    <div class="row">--}}
{{--        <div class="col-12">--}}
{{--            <h3 class="text-center font-weight-bold mt-3 mb-3">Earn money by growing your business with SmartPunch</h3>--}}
{{--        </div>--}}
{{--    </div>--}}

    <div class="row justify-content-center mt-3">
        <div class="form-group text-center col-sm-3">
            <form action="{{route('attendance.create')}}" id="verifyDocForm" method="POST">
                @csrf

                @if(!isset($attendances) || isset($attendances->last()->in_out_status) == 0)   {{-- 1 for in and 0 for out --}}
                    <input type="hidden" name="type" value="{{encrypt(1)}}">
                    <button class="btn btn-success btn-rounded mt-2 waves-effect waves-light" onclick="return confirm('Are you to sure?')" type="submit">
                        {{__('portal.Check In')}}
                    </button>
                @else
                    <input type="hidden" name="type" value="{{encrypt(0)}}">
                    <button class="btn btn-danger btn-rounded mt-2 waves-effect waves-light" onclick="return confirm('Are you to sure?')" type="submit">
                        {{__('portal.Check Out')}}
                    </button>
                @endif
            </form>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <div class="card-box">
                <h4 style="text-align: center;">{{__('portal.Today\'s Attendance')}}</h4>

                <table id="datatable" class="table table-bordered dt-responsive nowrap">
                    <thead>

                    <tr class="text-center" >
                        <th> # </th>
                        <th> {{__('portal.Time')}} </th>
                        <th> {{__('portal.Status')}} </th>
                    </tr>
                    </thead>

                    <tbody>

                    @foreach($attendances as $attendance)
                        <tr class="text-center">
                            <td> {{$loop->iteration}} </td>
                            <td>{{\Carbon\Carbon::parse($attendance->time)->format('g:i A')}} </td>
                            <td>
                                @if($attendance->in_out_status == 1)                {{-- 1 for in and 0 for out --}}
                                    <span style="color: limegreen"> {{__('portal.In')}} </span>
                                @else
                                    <span style="color: red"> {{__('portal.Out')}} </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
