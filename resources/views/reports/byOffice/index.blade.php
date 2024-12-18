@extends('theme.master')

@section('body')

    <div class="row justify-content-center mt-3">
        <div class="form-group text-center col-sm-3">
            <form action="{{route('byOfficeID')}}" method="GET">
{{--                @csrf--}}

                <label for="office">{{__('portal.Office')}}</label>
                <select class="custom-select" name="office_id" id="office" required>
                    <option value="" selected>{{__('portal.Select')}}</option>
                    @foreach($offices as $office)
                        <option @if(isset($sentOffice)) {{$sentOffice->id == $office->id ? 'selected' : ''}} @endif value="{{encrypt($office->id)}}">{{$office->name}}</option>
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
                {{--@if(!isset($sentOffice))
                    <h4 style="text-align: center;">{{__('portal.Attendance by office')}}</h4>
                @else
                    <h4 style="text-align: center;">{{$sentOffice->name . ' ' . __('portal.office attendance')}}</h4>
                @endif--}}
                <h4 style="text-align: center;">{{  __('portal.office attendance') .': ' .\Carbon\Carbon::now()->format('d-m-Y')}}</h4>

                <table id="datatable" class="table table-bordered dt-responsive nowrap">
                    <thead>
                    <tr>
                        <th>#</th>
{{--                        <th>{{__('portal.Name')}}</th>--}}
{{--                        <th>{{__('portal.Day start')}}</th>--}}
{{--                        <th>{{__('portal.Break start')}}</th>--}}
{{--                        <th>{{__('portal.Break end')}}</th>--}}
{{--                        <th>{{__('portal.Day end')}} </th>--}}
{{--                        <th>{{__('portal.Total hours')}} </th>--}}
                        <th>{{__('portal.Name')}}</th>
                        <th>{{__('portal.Details')}}</th>
                    </tr>
                    </thead>

                    <tbody>
                    @if(!is_null($attendances))

                        @foreach($attendances as $attendance)
                            @php $array = explode(',', $attendance->time); @endphp
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$attendance->name}}</td>
                                <td>
                                    @for($i = 0; $i < count($array); $i++)
                                        @if(substr($array[$i], 0, 1) == 1)
                                            <span style="color: lightgreen">{{substr_replace($array[$i], 'In at: ', 0, 2)}} {{'| '}}</span>
                                        @elseif(substr($array[$i], 0, 1) == 0)
                                            <span style="color: red"> {{substr_replace($array[$i], 'Out at: ', 0, 2)}} {{'| '}}</span>
                                        @endif
                                    @endfor
                                </td>
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
