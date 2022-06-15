@extends('theme.master')

@section('body')

    <div class="row mt-5">
        <div class="col-12">
            <div class="card-box">
                <h4 style="text-align: center;">{{__('portal.Messages history')}}</h4>

                <table id="datatable" class="table table-bordered dt-responsive nowrap">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{__('portal.Message date')}}</th>
                        <th>{{__('portal.Message')}}</th>
                        <th>{{__('portal.Recipient')}}</th>
                        <th>{{__('portal.Team')}}</th>
                        <th>{{__('portal.Status')}}</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($messages as $message)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{\Carbon\Carbon::parse($message->created_at)->toDateTimeString()}}</td>
                            <td>{{ $message->message }}</td>
                            <td>{{ $message->userReceived->name }}</td>
                            <td> <a href="{{route('message.teamEmployeesView', str_replace('team-','',$message->team_id))}}"> {{ ucfirst($message->team_id) }} </a> </td>
                            <td>@if(!is_null($message->read_at)) <span style="color: greenyellow">{{__('portal.Read')}}</span> @else <span style="color: red">{{__('portal.Unread')}}</span> @endif </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
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

            @if(auth()->user()->rtl == 0)
            $('.select2').select2();
            @else
            $('.select2').select2({
                dir: "rtl"
            });
            @endif
        });
    </script>
@endsection
