@extends('theme.master')

@section('body')
    <div class="row mt-3">
        <div class="col-12">
            <div class="card-box">
                <h4 style="text-align: center;">{{__('portal.List of schedules')}}</h4>

                <table id="datatable" class="table table-bordered dt-responsive nowrap">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{__('portal.Name')}}</th>
                        <th>{{__('portal.Start Time')}}</th>
                        <th>{{__('portal.End Time')}}</th>
                        <th>{{__('portal.Break Start Time')}}</th>
                        <th>{{__('portal.Break End Time')}}</th>
                        <th>{{__('portal.Office(s) assigned')}}</th>
                        <th>{{__('portal.Status')}}</th>
                        @if(auth()->user()->hasRole('admin'))
                        <th>{{__('portal.Action')}}</th>
                        @endif
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($schedules as $schedule)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$schedule->name}}</td>
                            <td>{{$schedule->start_time}}</td>
                            <td>{{$schedule->end_time}}</td>
                            <td>{{$schedule->break_start}}</td>
                            <td>{{$schedule->break_end}}</td>
                            <td>
                                @foreach($schedule->officeSchedules as $officeSchedules)
                                    {{$officeSchedules->office->name}} @if(!$loop->last) , @endif
                                @endforeach
                            </td>
                            <td>
                                @if($schedule->status == __('portal.Approved'))
                                    <span style="color: limegreen">{{$schedule->status}}</span>
                                @else
                                    <span style="color: red">{{$schedule->status}}</span>
                                @endif
                            </td>
                            @if(auth()->user()->hasRole('admin'))
                            <td>
                                @if($schedule->status == __('portal.Pending'))
                                    <span class="btn btn-success btn-rounded waves-effect waves-light" onclick="status({{$schedule->id}})">{{__('portal.Approve')}}</span>
                                @else
                                    --
                                @endif
                            </td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
{{--    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>--}}
    <script>
        function status(id) {
            $.ajax({
                type: 'POST',
                url: "{{ route('scheduleApprove') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'id': id
                },
                success: function (response) {
                    if (response.status === 0) {
                        alert('Not Updated Try again later');
                    } else if (response.status === 1) {
                        alert('Updated Successfully!');
                        // $('#status').show().delay(5000).fadeOut();
                        location.reload();
                    }
                }
            });
        }
    </script>
    <script>
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
                    // 'copy',
                    // 'csv',
                    // 'excel',
                    // 'pdf',
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
