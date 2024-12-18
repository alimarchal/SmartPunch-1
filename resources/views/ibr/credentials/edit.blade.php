@extends('ibr.layout.master')

@section('body')

    <div class="row">
        <div class="col-xl-6 mx-auto">
            <div class="card-box mt-3">

                <h4 class="header-title mt-0 mb-3 text-center">{{__('portal.Update Profile Details')}}</h4>

                <form action="{{route('ibr.userProfileEdit')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="email">{{__('portal.IBR no')}}</label>
                        <input id="email" class="form-control" value="{{auth()->user()->ibr_no}}" disabled>
                    </div>

                    <div class="form-group">
                        <label for="email">{{__('portal.Email')}}</label>
                        <input id="email" class="form-control" value="{{auth()->user()->email}}" disabled>
                    </div>

                    <div class="form-group">
                        <label for="current_password">{{__('register.Current Password')}}</label>
                        <input id="current_password" type="password" name="current_password" placeholder="{{__('register.Enter your current password')}}" class="form-control @error('current_password') parsley-error @enderror" required>

                        @error('current_password')
                        <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false">
                            <li class="parsley-required"> @foreach ($errors->get('current_password') as $error) <li>{{ $error }}</li> @endforeach </li></ul>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">{{__('register.Password')}}</label>
                        <input class="form-control @error('password') parsley-error @enderror" type="password" name="password" id="password" placeholder="{{__('register.Enter your password')}}" required>

                        @error('password')
                        <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false">
                            <li class="parsley-required"> @foreach ($errors->get('password') as $error) <li>{{ $error }}</li> @endforeach </li></ul>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">{{__('register.Confirm Password')}}</label>
                        <input class="form-control" type="password" name="password_confirmation" id="password" placeholder="{{__('register.Confirm Password')}}" required>
                    </div>

                    <div class="form-group mb-0 text-center">
                        <button class="btn btn-purple btn-block" type="submit"> {{__('register.Update')}} </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection
