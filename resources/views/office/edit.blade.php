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
                        <label for="pass1">{{__('portal.City Name')}} *</label>

                        <select class="custom-select" name="city" required>
                            <option value="" selected>{{__('portal.Select')}}</option>
                            <option {{$office->city == 1 ? 'selected' : ''}} value="1">Riyadh</option>
                        </select>

                        @error('city')
                        <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('city') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
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
                        <label for="passWord2">{{__('portal.Coordinates')}}</label>
                        <input type="text" name="coordinates" class="form-control" id="passWord2" value="{{$office->coordinates}}">
                    </div>

                    <div class="form-group">
                        <label for="schedules">{{__('portal.Schedule(s) List')}}</label>
                        <select name="schedules[]" class="select2 select2-multiple" multiple="multiple" data-placeholder="{{__('portal.Select')}}">
                            @foreach($schedules as $id => $schedule)
                                <option
                                {{ ($office->officeSchedules->pluck('schedule_id')->contains($id)) ? 'selected' : '' }}
                                        value="{{$schedule->id}}">{{$schedule->name}}</option>
                            @endforeach
                        </select>
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
        });
    </script>
@endsection
