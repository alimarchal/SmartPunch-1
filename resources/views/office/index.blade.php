@extends('theme.master')

@section('body')
    <div class="row mt-3">
        <div class="col-12">
            <div class="card-box">
                <h4 style="text-align: center;">{{__('portal.List of offices')}}</h4>

                <table id="datatable" class="table table-bordered dt-responsive nowrap">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{__('portal.Name')}}</th>
                        <th>{{__('portal.Email')}}</th>
                        <th>{{__('portal.Address')}}</th>
                        <th>{{__('portal.City Name')}}</th>
                        <th>{{__('portal.Phone')}}</th>
                        <th>{{__('portal.Total employees')}}</th>
                        <th>{{__('portal.Schedule(s) assigned')}}</th>
                        @can('delete office')
                        <th>{{__('portal.Action')}} </th>
                        @endcan
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($offices as $office)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$office->name}}</td>
                            <td>{{$office->email}}</td>
                            <td>{{$office->address}}</td>
                            <td>{{$office->city}}</td>
                            <td>{{$office->phone}}</td>
                            <td>
                                @if(count($office->employees) > 0)
                                    <a href="{{route('listOfEmployees', encrypt($office->id) )}}" style="color: limegreen;text-decoration: underline">{{count($office->employees)}}</a>
                                @else
                                    <span class="text-danger">{{count($office->employees)}}</span>
                                @endif
                            </td>
                            <td>
                                @foreach($office->officeSchedules as $officeSchedule)
                                    {{$officeSchedule->schedule->name}} @if(!$loop->last) , @endif
                                @endforeach
                            </td>
                            @if(auth()->user()->hasDirectPermission('delete office'))
                            <td>
                                <a href="{{route('officeEdit', encrypt($office->id))}}"><i class="fa fa-pencil-alt text-primary"></i></a>
                                <a href="{{route('officeDelete', encrypt($office->id))}}" onclick="return confirm('Are you to delete this office?')"><i class="fa fa-trash-alt text-danger ml-2"></i></a>
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

