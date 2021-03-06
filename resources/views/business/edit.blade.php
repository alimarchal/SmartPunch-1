@extends('theme.master')

@section('header')
    {{-- select2 scripts start --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    {{-- select2 scripts end --}}
@endsection

@section('body')

    <div class="row">
        <div class="col-xl-6 mx-auto">
            <div class="text-center">
                <a class="logo">
                    <img src="{{ $business->company_logo }}" alt="{{$business->company_name}}" height="64" class="logo-light mx-auto">
                </a>
            </div>
            <div class="card-box mt-3">

                <h4 class="header-title mt-0 mb-3 text-center">{{__('portal.Update Business Details to proceed')}}</h4>

                <form action="{{route('businessEdit', encrypt($business->id))}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="userName">{{__('portal.Company Name')}} *</label>
                        <input type="text" name="company_name" parsley-trigger="change" placeholder="{{__('register.Enter company name')}}" class="form-control @error('company_name') parsley-error @enderror" id="userName" value="{{$business->company_name}}" required>

                        @error('company_name')
                        <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('company_name') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="country_name">{{__('portal.Country Name')}} *</label>

                        <select class="custom-select" name="country_name" id="country_name">
                            <option value="" selected>{{__('portal.Select')}}</option>
                            @foreach($countries as $country)
                                <option {{$business->country_name == $country->id ? 'selected' : ''}} value="{{$country->id}}">{{$country->name}}</option>
                            @endforeach
                        </select>

                        @error('country_name')
                        <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('country_name') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="city_name">{{__('portal.City Name')}} *</label>

                        <select class="custom-select" name="city_name" id="city_name" required>
                            <option value="" selected>{{__('portal.Select')}}</option>
                            @php $cities = \App\Models\City::where('country_id', $business->country_name)->get(); @endphp
                            @foreach($cities as $city)
                                <option {{$business->city_name == $city->id ? 'selected' : ''}} value="{{$city->id}}">{{$city->name}}</option>
                            @endforeach
                        </select>

                        @error('city_name')
                        <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('city_name') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="pass1">{{__('portal.Country Code')}} *</label>
                        <input id="pass1" type="text" name="country_code" placeholder="{{__('register.Enter country code')}}" class="form-control @error('country_code') parsley-error @enderror" value="{{$business->country_code}}" required>

                        @error('country_code')
                        <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('country_code') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="logo">{{__('portal.Company Logo')}}</label>

                        <input type="file" name="logo" class="form-control @error('logo') parsley-error @enderror">

                        @error('logo')
                        <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('logo') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="passWord2">{{__('portal.IBR')}}</label>
                        <input type="text" name="ibr" placeholder="{{__('register.Enter IBR (if any)')}}" class="form-control" id="passWord2" value="{{$business->ibr}}">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
    <script>

        $(document).ready(function() {
            $('#city_name').select2();
        });

        $("#country_name").select2().on("change", function () {
            let option = '';
            $('#city_name').prop('disabled', true);
            $.ajax({
                url: "{{route('ibr.search-cities')}}",
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: $('#country_name').val(),
                },
                success: function(result){
                    $('#city_name').prop('disabled', false);
                    $('#city_name').empty();
                    $('#city_name').append(' <option disabled selected value="">Select</option>');
                    result.cities.forEach(function (city, index) {
                        option = "<option value='" + city.id + "'>" + city.name + "</option>"
                        $('#city_name').append(option);
                    });
                },
                error: function(result){
                    console.log('error');
                }
            });
        });
    </script>
@endsection
