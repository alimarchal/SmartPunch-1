@extends('theme.master')

@section('body')

    <div class="row">
        <div class="col-xl-6 mx-auto">
            <div class="text-center">
                <a class="logo">
                    <img src="{{ Storage::url( $business->company_logo ) }}" alt="{{$business->company_name}}"  class="logo-light mx-auto mt-2" style="border-radius: 50%;" height="100" width="100">
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
                                <option {{$business->country_name['name'] == $country->name ? 'selected' : ''}} value="{{$country->id}}">{{$country->name}}</option>
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
                            @php $cities = \App\Models\City::where('country_id', $business->country_name['id'])->get(); @endphp
                            @foreach($cities as $city)
                                <option {{$business->city_name['name'] == $city->name ? 'selected' : ''}} value="{{$city->id}}">{{$city->name}}</option>
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
                        <label for="ibr">{{__('portal.IBR')}}</label>
                        <input type="text" placeholder="{{__('register.Enter IBR (if any)')}}" class="form-control" id="ibr" value="{{$business->ibr}}" disabled>
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
