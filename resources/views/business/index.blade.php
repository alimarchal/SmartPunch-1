@extends('theme.master')

@section('body')

    <div class="text-center mt-3">
        <a class="logo">
            @if(isset($business->company_logo))
                <img src="{{ Storage::url( $business->company_logo) }}" alt="{{auth()->user()->business->company_name}}" class="logo-light mx-auto" style="border-radius: 50%;" height="100" width="100">
            @else
                <img src="{{ url('no-image.png') }}" alt="No image" class="logo-light mx-auto" height="100" width="100">
            @endif
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
                <input type="text" class="form-control" maxlength="25" value="{{$business->country_name['name']}}" disabled/>
            </div>
        </div>

        <div class="col-md-3">
            <div class="p-2">
                <h5>{{__('portal.City Name')}}</h5>
                <input type="text" class="form-control" maxlength="25" @if(isset($business->city_name)) value="{{$business->city_name['name']}}" @endif disabled/>
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

        <div class="col-md-3" style="margin-left: auto">
            <div class="p-2 mt-sm-4">
                <a href="{{route('businessEdit', encrypt($business->id))}}" class="btn btn-purple waves-effect width-md waves-light">Edit</a>
            </div>
        </div>

    </div>

@endsection
