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
                        <th>{{__('portal.Total hours')}} </th>
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

                                <td>
                                    {{--@php
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
                                        @endif--}}
                                    @php
                                        $totalTimeInMinutes = 0;
                                        if (count($team->punchTable) > 0){
                                            if ($team->punchTable[count($team->punchTable) - 1]->in_out_status == 0){
                                                for ($i = 0; $i < count($team->punchTable) - 1; $i++){
                                                    $start_time = \Carbon\Carbon::parse($team->punchTable[$i]->time);
                                                    $end_time = \Carbon\Carbon::parse($team->punchTable[$i+1]->time);

                                                    $diff1 = $start_time->diffInMinutes($end_time);
                                                    $totalTimeInMinutes += $diff1;
                                                    $i += 1;
                                                }
                                            }
                                        }
                                    @endphp
                                    {{ \Carbon\Carbon::parse($totalTimeInMinutes)->format('i:s') }} Hours
                                </td>
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
