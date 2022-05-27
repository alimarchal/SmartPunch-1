@extends('theme.master')

@section('body')

    <div class="row">
        <div class="col-xl-6 mx-auto">
            <div class="card-box mt-3">

                <h4 class="header-title mt-0 mb-3 text-center">{{__('portal.Update Office Details')}}</h4>

                <form action="{{route('officeEdit', encrypt($office->id))}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="userName">{{__('portal.Name')}} *</label>
                        <input type="text" name="name" parsley-trigger="change" placeholder="{{__('portal.Enter name')}}" class="form-control @error('name') parsley-error @enderror" id="userName" value="{{$office->name}}" required>

                        @error('name')
                        <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('name') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="userName">{{__('portal.Email')}} *</label>
                        <input type="email" name="email" parsley-trigger="change" placeholder="{{__('portal.Enter email')}}" class="form-control @error('email') parsley-error @enderror" id="userName" value="{{$office->email}}" required>

                        @error('email')
                        <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('email') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="userName">{{__('portal.Address')}} *</label>
                        <textarea class="form-control @error('address') parsley-error @enderror" name="address" rows="3" maxlength="254" id="example-textarea" placeholder="{{__('portal.Enter address')}}" required>{{$office->address}}</textarea>

                        @error('address')
                        <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('address') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="city">{{__('portal.City Name')}} *</label>

                        <select class="custom-select" name="city" id="city" required>
                            <option value="" selected>{{__('portal.Select')}}</option>
                            @foreach($cities as $city)
                                <option {{$office->city == $city->name ? 'selected' : ''}} value="{{$city->name}}">{{$city->name}}</option>
                            @endforeach
                                <option {{$cities->doesntContain($office->city) ? 'selected' : ''}} value="other">{{__('portal.Other')}}</option>
                        </select>

                        @error('city')
                        <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('city') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
                        @enderror
                    </div>

                    <div class="form-group d-none" id="other-city">
                        <label for="other_city">{{__('portal.Other City')}} *</label> <br>
                        <input class="form-control" type="text" id="other_city" name="other_city" placeholder="{{__('portal.Enter city name')}}">

                        @error('other_city')
                        <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('other_city') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="userName">{{__('portal.Phone')}} *</label>
                        <input type="tel" name="phone" parsley-trigger="change" placeholder="{{__('portal.Enter phone')}}" class="form-control @error('phone') parsley-error @enderror" id="userName" value="{{$office->phone}}" required>

                        @error('phone')
                        <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('phone') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="inner_coordinates">{{__('portal.Inner coordinates')}}</label>
                        <textarea name="inner_coordinates" class="form-control" rows="3" id="inner_coordinates" placeholder="{{__('portal.Enter inner coordinates')}}">{{$office->inner_coordinates}}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="outer_coordinates">{{__('portal.Outer coordinates')}}</label>
                        <textarea name="outer_coordinates" class="form-control" rows="3" id="outer_coordinates" placeholder="{{__('portal.Enter outer coordinates')}}">{{$office->outer_coordinates}}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="schedules">{{__('portal.Schedule(s) List')}}</label>
                        <select name="schedules[]" class="select2 select2-multiple  @if(session()->has('assignedSchedules')) parsley-error @endif" multiple="multiple" data-placeholder="{{__('portal.Select')}}">
                            @foreach($schedules as $schedule)
                                <option
                                {{ ($office->officeSchedules->pluck('schedule_id')->contains($schedule->id)) ? 'selected' : '' }}
                                        value="{{$schedule->id}}">{{$schedule->name}}</option>
                            @endforeach
                        </select>
                        @if(session()->has('assignedSchedules'))
                        <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li> @foreach (session('assignedSchedules') as $assignedSchedule) {{ $assignedSchedule }} @if (!$loop->last) {{ ', ' }} @endif @endforeach {{' schedule(s) cannot be removed because user(s) are assigned.'}} </li> </ul>
                        @endif
                    </div>

                    <div class="form-group text-right mb-0">
                        <button class="btn btn-purple waves-effect waves-light mr-1" type="submit">
                            {{__('portal.Update')}}
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2();
            $('#city').select2();

            $('#city').change(function(){
                if($(this).val() == "other")
                {
                    $('#other-city').removeClass("d-none");
                }
                else
                {
                    $('#other-city').addClass("d-none");
                }

            });

{{--            var cities  = {!! $citiesJson->toJson() !!};--}}
            // if ($.inArray($('#city').val(), cities) != -1)
            if ($.inArray($('#city').val(), '{{$citiesJson}}') != -1)
            {
                $('#other-city').addClass("d-none");
            }
            else {
                $('#other-city').removeClass("d-none");
                $('#other_city').val('{{$office->city}}');
            }
        });
    </script>
@endsection
