@extends('theme.master')

@section('body')
    <div class="row mt-3">

        @foreach($employees as $employee)
            <div class="col-xl-3 col-md-6">
                <div class="card-box widget-user">
                    <div class="media">
                        <div class="avatar-lg mr-3">
                            @if (!isset($employee->profile_photo_path))
                                <img src="{{ $employee->profile_photo_url }}" alt="user-image" class="rounded-circle">
                            @else
                                <a href="{{route('employeeShow', encrypt($employee->id))}}" class="text-white"><img src="{{ Storage::url( $employee->profile_photo_path ) }}" alt="{{$employee->name}}" class="img-fluid rounded-circle"></a>
                            @endif
                        </div>
                        <div class="media-body overflow-hidden">
                            <h5 class="mt-0 mb-1"> <a href="{{route('employeeShow', encrypt($employee->id))}}" class="text-white"> {{$employee->name}} </a>
                                @if($employee->hasVerifiedEmail())
                                    {{-- Verify icon --}}
                                    <small style="color: limegreen"><b><i class="fa fa-check-circle"></i></b></small>
                                    @if(auth()->user()->hasDirectPermission('delete employee'))
                                        {{-- Delete icon --}}
                                        {{-- Commented because to requiment change i.e user should not be deleted instead should be suspended --}}
                                        {{--                                        <small class="float-right mt-1"><b><a href="{{route('employeeDelete', encrypt($employee->id))}}" onclick="return confirm('Are you sure to delete?')"><i class="text-danger fa fa-trash-alt"></i></a></b></small>--}}
                                    @endif
                                    @if(auth()->user()->hasDirectPermission('update employee'))
                                        {{-- Edit icon --}}
                                        <small class="float-right mr-2 mt-1"><b><a href="{{route('employeeEdit', encrypt($employee->id))}}"><i class="fas fa-pencil-alt"></i></a></b></small>
                                    @endif
                                @else
                                    {{-- Verify icon --}}
                                    <small class="text-danger"><b><i class="fa fa-times-circle"></i></b></small>
                                    @if(auth()->user()->hasDirectPermission('delete employee'))
                                        {{-- Delete icon --}}
                                        {{-- Commented because to requiment change i.e user should not be deleted instead should be suspended --}}
                                        {{--                                        <small class="text-danger float-right mt-1"><b><a href="{{route('employeeDelete', encrypt($employee->id))}}" onclick="return confirm('Are you sure to delete?')"><i class="text-danger fa fa-trash-alt"></i></a></b></small>--}}
                                    @endif
                                @endif
                            </h5>
                            <p class="text-muted mb-2 font-13 text-truncate">{{$employee->email}}</p>
                            @php $role = \Spatie\Permission\Models\Role::where('id', $employee->user_role)->pluck('name')->first(); @endphp

                            @if($role == 'admin') <small><b> <a href="{{route('employeeShow', encrypt($employee->id))}}" class="text-secondary"> {{ucfirst($role)}} @if($employee->status == 0) <span class="badge badge-danger"> {{__('portal.Suspended')}}</span> @endif  </a></b></small><br> @endif
                            @if($role == 'manager') <small><b> <a href="{{route('employeeShow', encrypt($employee->id))}}" class="text-primary"> {{ucfirst($role)}} @if($employee->status == 0) <span class="badge badge-danger"> {{__('portal.Suspended')}}</span> @endif </a></b></small><br> @endif
                            @if($role == 'supervisor') <small><b> <a href="{{route('employeeShow', encrypt($employee->id))}}" style="color: #C46210"> {{ucfirst($role)}} @if($employee->status == 0) <span class="badge badge-danger"> {{__('portal.Suspended')}}</span> @endif  </a></b></small><br> @endif
                            @if($role == 'employee') <small><b> <a href="{{route('employeeShow', encrypt($employee->id))}}" class="text-pink"> {{ucfirst($role)}} @if($employee->status == 0) <span class="badge badge-danger"> ({{__('portal.Suspended')}}</span> @endif  </a></b></small><br> @endif

                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
@endsection

