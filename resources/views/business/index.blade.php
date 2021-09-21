@extends('theme.master')

@section('body')

    <div class="text-center mt-3">
        <a class="logo">
            <img src="{{ $business->company_logo }}" alt="{{$business->company_name}}" height="64" class="logo-light mx-auto">
        </a>
    </div>
    <div class="row mt-3">

        <div class="col-md-3">
            <div class="p-2">
                <h5>{{__('portal.Company Name')}} </h5>
                <input type="text" class="form-control" maxlength="25" value="{{$business->company_name}}" disabled/>
            </div>
        </div>

        <div class="col-md-3">
            <div class="p-2">
                <h5>{{{__('portal.Country Name')}}}</h5>
                <input type="text" class="form-control" maxlength="25" value="Saudi Arabia" disabled/>
            </div>
        </div>

        <div class="col-md-3">
            <div class="p-2">
                <h5>{{__('portal.City Name')}}</h5>
                <input type="text" class="form-control" maxlength="25" value="Riyadh" disabled/>
            </div>
        </div>

        <div class="col-md-3">
            <div class="p-2">
                <h5>{{__('portal.Country Code')}}</h5>
                <input type="text" class="form-control" maxlength="25" value="{{$business->country_code}}" disabled/>
            </div>
        </div>

        @if(isset($business->ibr))
            <div class="col-md-3">
                <div class="p-2">
                    <h5>{{__('portal.IBR')}}</h5>
                    <input type="text" class="form-control" maxlength="25" value="{{$business->ibr}}" disabled/>
                </div>
            </div>
        @endif

    </div>

@endsection
