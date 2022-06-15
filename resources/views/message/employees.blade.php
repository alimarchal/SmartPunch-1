@extends('theme.master')

@section('body')

    <form action="{{route('message.toEmployee')}}" method="POST">
        @csrf
        <h4 class="header-title mt-3 text-center">{{__('portal.Send Message')}}</h4>
        {{--<div class="row justify-content-center mt-3">
            <div class="form-group text-center col-sm-3">
                <label for="employees">{{__('portal.List of employees')}}</label>
                <select class="custom-select select2 select2-multiple" name="employeeIDs[]" multiple="multiple" id="employees" >
                    @foreach($employees as $employee)
                        <option value="{{encrypt($employee->id)}}"> {{ $employee->name }} </option>
                    @endforeach
                </select>

                @error('employeeIDs')
                <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('employeeIDs') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
                @enderror

            </div>
        </div>--}}

        <div class="row">
            <div class="col-12">
                <div class="p-2">
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label" for="employees">{{__('portal.Select employees')}}:</label>
                        <div class="col-md-10">
                            <select class="custom-select select2 select2-multiple" name="employeeIDs[]" multiple="multiple" id="employees" required>
                                @foreach($employees as $employee)
                                    <option value="{{encrypt($employee->id)}}"> {{ $employee->name }} </option>
                                @endforeach
                            </select>

                            @error('employeeIDs')
                            <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('employeeIDs') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="p-2">
                    {{--<div class="form-group row">
                        <label class="col-md-2 col-form-label" for="simpleinput">Text</label>
                        <div class="col-md-10">
                            <input type="text" id="simpleinput" class="form-control" value="Some text value...">
                        </div>
                    </div>--}}
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label" for="message">{{__('portal.Message')}}:</label>
                        <div class="col-md-10">
                            <textarea class="form-control @error('message') parsley-error @enderror" rows="5" name="message" placeholder="{{__('portal.Enter message')}}" required></textarea>
                            @error('message')
                            <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('message') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group text-right mb-0 float-right">
            <button class="btn btn-primary waves-effect waves-light mr-1" type="submit">
                {{__('portal.Submit')}}
            </button>
        </div>
    </form>

    @if($messages)
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
                                    <td>@if(!is_null($message->read_at)) <span style="color: greenyellow">{{__('portal.Read')}}</span> @else <span style="color: red">{{__('portal.Unread')}}</span> @endif </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

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
