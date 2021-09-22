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
                            <h5 class="mt-0 mb-1">{{$employee->name}}
                                @if($employee->hasVerifiedEmail())
                                    <small style="color: limegreen"><b><i class="fa fa-check-circle"></i></b></small>
                                    <small class="float-right"><b><a href="{{route('employeeEdit', encrypt($employee->id))}}"><i class="fas fa-pencil-alt"></i></a></b></small>
                                @else
                                    <small class="text-danger"><b><i class="fa fa-times-circle"></i></b></small>
                                @endif
                            </h5>
                            <p class="text-muted mb-2 font-13 text-truncate">{{$employee->email}}</p>
                            @php $role = \Spatie\Permission\Models\Role::where('id', $employee->user_role)->pluck('name')->first(); @endphp

                            @if($role == 'admin') <small class="text-secondary"><b>{{ucfirst($role)}}</b></small><br> @endif
                            @if($role == 'manager') <small class="text-primary"><b>{{ucfirst($role)}}</b></small><br> @endif
                            @if($role == 'supervisor') <small><b>{{ucfirst($role)}}</b></small><br> @endif
                            @if($role == 'employee') <small class="text-pink"><b>{{ucfirst($role)}}</b></small><br> @endif

                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
@endsection

