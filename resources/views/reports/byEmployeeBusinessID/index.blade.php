@extends('theme.master')

@section('body')

    <div class="row justify-content-center mt-3">
        <div class="form-group text-center col-sm-3">
            <form action="{{route('byEmployeeBusinessID')}}" method="GET">
{{--                @csrf--}}

                <label for="employee">{{__('portal.Employee business IDs')}}</label>
                <select class="custom-select select2" name="employee_id" id="employee" required>
                    <option value="" selected>{{__('portal.Select')}}</option>
                    @foreach($employees as $employee)
                        <option @if(isset($sentEmployee)) {{$sentEmployee->id == $employee->id ? 'selected' : ''}} @endif value="{{encrypt($employee->id)}}">{{$employee->employee_business_id}}</option>
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

                <h5 style="text-align: center;">{{__('portal.Date')}}: @if(isset($reports[0]->created_at))  {{ \Carbon\Carbon::parse($reports[0]->created_at)->format('Y-m-d') }} @else {{__('portal.N/A')}} @endif</h5>

                <table id="datatable" class="table table-bordered dt-responsive nowrap">
                    <thead>
                    {{--<tr>
                        <th>#</th>
                        <th>{{__('portal.Name')}}</th>
                        <th>{{__('portal.Time')}}</th>
                        <th>{{__('portal.Movement')}}</th>
--}}{{--                        <th>{{__('portal.Total hours')}} </th>--}}{{--
                    </tr>--}}

                    <tr class="text-center" >
                        <th> <span style="color: limegreen"> {{__('portal.In')}} </span> </th>
                        <th> <span style="color: red"> {{__('portal.Out')}} </span> </th>
                        <th> <span style="color: limegreen"> {{__('portal.In')}} </span> </th>
                        <th> <span style="color: red"> {{__('portal.Out')}} </span> </th>
{{--                        <th> {{__('portal.Date')}} </th>--}}
                        <th> <span> {{__('portal.Details')}} </span> </th>
                    </tr>
                    </thead>

                    <tbody>
                    @if(!is_null($reports))
                        {{--@foreach ($reports as $report)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$report->user->name}}</td>
                            <td>{{\Carbon\Carbon::parse($report->time)->format('g:i A')}}</td>
                            <td>@if($report->in_out_status == 1) <span style="color: lightgreen">{{__('portal.In')}}</span> @elseif($report->in_out_status == 0) <span style="color: red">{{__('portal.Out')}}</span> @else {{__('portal.N/A')}} @endif</td>
                            <td>total</td>
                        </tr>
                        @endforeach--}}

                        <tr class="text-center">
{{--                            @foreach ($reports->take(4) as $report)--}}
{{--                            <td>@if(isset($report->time)) {{\Carbon\Carbon::parse($report->time)->format('g:i A')}} @else {{__('portal.N/A')}} @endif </td>--}}
{{--                            @endforeach--}}
                            <td>@if(isset($reports[0]->time)) {{\Carbon\Carbon::parse($reports[0]->time)->format('g:i A')}} @else {{__('portal.N/A')}} @endif </td>
                            <td>@if(isset($reports[1]->time)) {{\Carbon\Carbon::parse($reports[1]->time)->format('g:i A')}} @else {{__('portal.N/A')}} @endif </td>
                            <td>@if(isset($reports[2]->time)) {{\Carbon\Carbon::parse($reports[2]->time)->format('g:i A')}} @else {{__('portal.N/A')}} @endif </td>
                            <td>@if(isset($reports[3]->time)) {{\Carbon\Carbon::parse($reports[count($reports) - 1]->time)->format('g:i A')}} @else {{__('portal.N/A')}} @endif </td>
{{--                            <td>@if(isset($reports[0]->created_at))  {{ \Carbon\Carbon::parse($reports[0]->created_at)->format('Y-m-d') }} @else {{__('portal.N/A')}} @endif </td>--}}
                            <td>
                                @if(isset($reports[0]->user_id))
                                    <a href="{{route('byEmployeeBusinessIDShow', $reports[0]->user_id)}}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                @else
                                    {{__('portal.N/A')}}
                                @endif
                            </td>
                        </tr>

                    @endif
                    </tbody>
                </table>
            </div>
            @php
                $totalTimeInMinutes = 0;
                if (count($reports) > 0){
                    if ($reports[count($reports) - 1]->in_out_status == 0){
                        for ($i = 0; $i < count($reports) - 1; $i++){
                            $start_time = \Carbon\Carbon::parse($reports[$i]->time);
                            $end_time = \Carbon\Carbon::parse($reports[$i+1]->time);

                            $diff1 = $start_time->diffInMinutes($end_time);
                            $totalTimeInMinutes += $diff1;
                            $i += 1;
                        }
                    }
                }
            @endphp
            <h5 style="text-align: end;">{{__('portal.Total hours') . ': ' . \Carbon\Carbon::parse($totalTimeInMinutes)->format('i:s') }} Hours</h5>
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

        <?php
        $countries = array (
            "en"=>"//cdn.datatables.net/plug-ins/1.10.16/i18n/English.json",
            "ar"=>"//cdn.datatables.net/plug-ins/1.10.16/i18n/Arabic.json",
            "ur"=>"//cdn.datatables.net/plug-ins/1.10.16/i18n/Urdu.json",
            "ru"=>"//cdn.datatables.net/plug-ins/1.10.16/i18n/Russian.json",
            "fr"=>"//cdn.datatables.net/plug-ins/1.10.16/i18n/French.json",
            "es"=>"//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json",
            "de" =>"//cdn.datatables.net/plug-ins/1.10.16/i18n/German.json",
            "it" =>"//cdn.datatables.net/plug-ins/1.10.16/i18n/Italian.json",
            "ja" =>"//cdn.datatables.net/plug-ins/1.10.16/i18n/Japanese.json",
            "ko" =>"//cdn.datatables.net/plug-ins/1.10.16/i18n/Korean.json",
            "zh" =>"//cdn.datatables.net/plug-ins/1.10.16/i18n/Chinese.json",
            "nl" =>"//cdn.datatables.net/plug-ins/1.10.16/i18n/Dutch.json",
            "sw" =>"//cdn.datatables.net/plug-ins/1.10.16/i18n/Swahili.json",
            "fil" =>"//cdn.datatables.net/plug-ins/1.10.16/i18n/Filipino.json",
            "fa" =>"//cdn.datatables.net/plug-ins/1.10.16/i18n/Persian.json",
            "tr"=>"//cdn.datatables.net/plug-ins/1.10.16/i18n/Turkish.json",
        );
        ?>

        var locale = '<?php echo $countries[session('locale')];?>';
        $(document).ready(function () {
            $('#datatable').dataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy',
                    'csv',
                    'excel',
                    'pdf',
                    // 'print'
                ],
                responsive: true,
                "oLanguage": {
                    "sUrl": locale
                }
            });
        });

    </script>

@endsection
