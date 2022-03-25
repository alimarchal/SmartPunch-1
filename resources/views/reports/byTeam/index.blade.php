@extends('theme.master')

@section('body')

    <div class="row mt-3">
        <div class="col-12">
            <div class="card-box">
                <h4 style="text-align: center;">{{__('portal.Attendance by my team')}}</h4>

                <table id="datatable" class="table table-bordered dt-responsive nowrap">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{__('portal.Name')}}</th>
                        <th>{{__('portal.Movement')}}</th>
{{--                        <th>{{__('portal.Time')}}</th>--}}
{{--                        <th>{{__('portal.Total hours')}} </th>--}}
                    </tr>
                    </thead>

                    <tbody>
                    @php $total_break_time = 0; $arr = array();@endphp
                        @foreach ($teams as $team)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>
                                    {{$team->name}}
                                    @if($team->child->count() > 0)
                                        <i class="fa fa-user-plus ml-2" style="color: deepskyblue"></i>
                                    @endif
                                </td>
                                <td>
                                    @foreach($team->punchTable as $punch)
                                        @if($punch->in_out_status == 1)
                                            <span style="color: greenyellow">{{__('portal.In')}} {{\Carbon\Carbon::parse($punch->time)->format('g:i A')}} |</span>
                                        @elseif($punch->in_out_status == 0)
                                            <span style="color: red">{{__('portal.Out')}} {{\Carbon\Carbon::parse($punch->time)->format('g:i A')}} |</span>
                                        @endif

                                    @endforeach
                                </td>

                                {{--<td>
                                    @php
                                        $total = null;
                                        for($i = 0; $i < count($team->punchTable); $i++){
                                            if ($i != 3){
                                            $after = \Carbon\Carbon::parse($team->punchTable[$i + 1]->time);
                                            $before = \Carbon\Carbon::parse($team->punchTable[$i]->time);

                                            $timeall = $after->diff($before);
                                            echo $timeall;
                                            $total += $timeall->h;
                                            }
                                        }
dd($timeall);

                                    @endphp
                                    @if(isset($total))
                                    {{ $total }}
                                        @endif
                                </td>--}}
                            </tr>
                        @endforeach
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
