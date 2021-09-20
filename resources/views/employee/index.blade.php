@extends('theme.master')

@section('body')
    <div class="row mt-3">

        @foreach($employees as $employee)
            <div class="col-xl-3 col-md-6">
                <div class="card-box widget-user">
                    <div class="media">
                        <div class="avatar-lg mr-3">
                            <img src="{{ $employee->profile_photo_path }}" alt="{{$employee->name}}" class="img-fluid rounded-circle">
                        </div>
                        <div class="media-body overflow-hidden">
                            <h5 class="mt-0 mb-1">{{$employee->name}}</h5>
                            <p class="text-muted mb-2 font-13 text-truncate">{{$employee->email}}</p>
                            <small class="text-warning"><b>User</b></small>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
@endsection

