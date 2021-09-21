@extends('theme.master')

@section('body')

    <div class="row">
        <div class="col-xl-6 mx-auto">
            <div class="card-box mt-3">

                <h4 class="header-title mt-0 mb-3 text-center">{{__('portal.Enter Employee Details')}}</h4>

                <form action="#" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="pass1">{{__('portal.Business')}} *</label>

                        <select class="custom-select" name="business_id" required>
                            <option value="" selected>{{__('portal.Select')}}</option>
                            @foreach($businesses as $business)
                                <option {{old('business_id') == $business->id ? 'selected' : ''}} value="{{$business->id}}">{{$business->company_name}}</option>
                            @endforeach
                        </select>

                        @error('business_id')
                            <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('business_id') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="pass1">{{__('portal.Office')}} *</label>

                        <select class="custom-select" name="office_id" required>
                            <option value="" selected>{{__('portal.Select')}}</option>
                            @foreach($offices as $office)
                                <option {{old('office_id') == $office->id ? 'selected' : ''}} value="{{$office->id}}">{{$office->name}}</option>
                            @endforeach
                        </select>

                        @error('office_id')
                            <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('office_id') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="userName">{{__('portal.Name')}} *</label>
                        <input type="text" name="name" parsley-trigger="change" placeholder="{{__('portal.Enter employee name')}}" class="form-control @error('name') parsley-error @enderror" value="{{old('name')}}">

                        @error('name')
                            <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('name') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="userName">{{__('portal.Email')}} *</label>
                        <input type="email" name="email" parsley-trigger="change" placeholder="{{__('portal.Enter employee email')}}" class="form-control @error('email') parsley-error @enderror" id="userName" value="{{old('email')}}" required>

                        @error('email')
                            <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('email') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="userName">{{__('portal.Employee ID')}}</label>
                        <input type="text" name="employee_business_id" parsley-trigger="change" placeholder="{{__('portal.Enter Employee ID (if any)')}}" class="form-control @error('employee_business_id') parsley-error @enderror" value="{{old('employee_business_id')}}">

                        @error('employee_business_id')
                            <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('employee_business_id') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
                        @enderror
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
