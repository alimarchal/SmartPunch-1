@extends('theme.master')

@section('css')
    <link href="{{url('Horizontal/dist/assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.css')}}" rel="stylesheet">
@endsection

@section('body')

    <div class="row">
        <div class="col-xl-6 mx-auto">
            <div class="card-box mt-3">

                <h4 class="header-title mt-0 mb-3 text-center">{{__('portal.Enter Schedule Details')}}</h4>

                <form action="{{route('scheduleCreate')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="name">{{__('portal.Schedule Type')}} *</label>

                            <input type="text" name="name" class="form-control" value="{{old('name')}}" required>

                            @error('name')
                            <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('name') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
                            @enderror
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="offices">{{__('portal.Offices list')}}</label>
                            <select name="offices[]" class="select2 select2-multiple" multiple="multiple" data-placeholder="{{__('portal.Select')}}">
                                @foreach($offices as $office)
                                    <option value="{{$office->id}}">{{$office->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>{{__('portal.Start Time')}}</label>
                            <div class="input-group">
                                <input id="timepicker" type="text" name="start_time" value="{{old('start_time')}}" readonly class="form-control" required>
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
                                </div>
                            </div>
                            @error('start_time')
                            <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('start_time') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
                            @enderror
                        </div>

                        <div class="form-group col-sm-6">
                            <label>{{__('portal.End Time')}}</label>
                            <div class="input-group">
                                <input id="timepicker1" type="text" name="end_time" value="{{old('end_time')}}" readonly class="form-control" required>
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
                                </div>
                            </div>
                            @error('end_time')
                            <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('end_time') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>{{__('portal.Break Start Time')}}</label>
                            <div class="input-group">
                                <input id="timepicker2" type="text" name="break_start" value="{{old('break_start')}}" readonly class="form-control" required>
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
                                </div>
                            </div>
                            @error('break_start')
                            <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('break_start') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
                            @enderror
                        </div>
                        <div class="form-group col-sm-6">
                            <label>{{__('portal.Break End Time')}}</label>
                            <div class="input-group">
                                <input id="timepicker3" type="text" name="break_end" value="{{old('break_end')}}" readonly class="form-control" required>
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
                                </div>
                            </div>
                            @error('break_end')
                            <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('break_end') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group text-right mb-0">
                        <button class="btn btn-primary waves-effect waves-light mr-1" type="submit">
                            {{__('portal.Submit')}}
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{url('Horizontal/dist/assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.js')}}"></script>
    <script type="text/javascript">
        $('#timepicker').timepicker();
        $('#timepicker1').timepicker();
        $('#timepicker2').timepicker();
        $('#timepicker3').timepicker();
        $(document).ready(function() {
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
