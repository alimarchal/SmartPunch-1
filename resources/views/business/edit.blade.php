@extends('theme.master')

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
                        <label for="pass1">{{__('portal.Country Name')}} *</label>

                        <select class="custom-select" name="country_name">
                            <option value="" selected>{{__('portal.Select')}}</option>
                            <option {{$business->country_name == 1 ? 'selected' : ''}} value="1">Saudi Arabia</option>
                        </select>

                        @error('country_name')
                        <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('country_name') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="pass1">{{__('portal.City Name')}} *</label>

                        <select class="custom-select" name="city_name" required>
                            <option value="" selected>{{__('portal.Select')}}</option>
                            <option {{$business->city_name == 1 ? 'selected' : ''}} value="1">Riyadh</option>
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
