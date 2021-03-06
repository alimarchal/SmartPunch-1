@extends('theme.master')

@section('body')

    <div class="row">
        <div class="col-xl-6 mx-auto">
            <div class="card-box mt-3">

                <h4 class="header-title mt-0 mb-3 text-center">{{__('portal.Enter Employee Details')}}</h4>

                <form action="{{route('employeeEdit', encrypt($employee->id))}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="userName">{{__('portal.Name')}}</label>
                        <input type="text" class="form-control" value="{{$employee->name}}" disabled>
                    </div>

                    <div class="form-group">
                        <label for="userName">{{__('portal.Email')}}</label>
                        <input type="email" class="form-control" value="{{$employee->email}}" disabled>
                    </div>

                    @if(isset($employee->phone))
                        <div class="form-group">
                            <label for="userName">{{__('portal.Phone')}}</label>
                            <input type="tel" class="form-control" value="{{$employee->phone}}" disabled>
                        </div>
                    @endif

                    @if(isset($employee->employee_business_id))
                        <div class="form-group">
                            <label for="userName">{{__('portal.Employee ID')}}</label>
                            <input type="text" class="form-control" value="{{$employee->employee_business_id}}" disabled>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="pass1">{{__('portal.Status')}} *</label>

                        <select class="custom-select" name="status" required>
                            <option value="" disabled selected>{{__('portal.Select')}}</option>
                            <option {{$employee->status == 0 ? 'selected' : ''}} value="0">{{__('portal.Suspended')}}</option>
                            <option {{$employee->status == 1 ? 'selected' : ''}} value="1">{{__('portal.Active')}}</option>
                        </select>

                        @error('status')
                            <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('status') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="pass1">{{__('portal.Office')}} *</label>

                        <select class="custom-select" name="office_id" id="office" required>
                            <option value="" disabled selected>{{__('portal.Select')}}</option>
                            @foreach($offices as $office)
                                <option {{$employee->office_id == $office->id ? 'selected' : ''}} value="{{$office->id}}">{{ucfirst($office->name)}}</option>
                            @endforeach
                        </select>

                        @error('office_id')
                            <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('office_id') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="pass1">{{__('portal.Schedule(s) List')}} *</label>

                        <select class="custom-select" name="schedule_id" id="schedules" >
                            <option value="" disabled selected>{{__('portal.Select')}}</option>
                            @foreach($employee->office->officeSchedules as $officeSchedule)
                                <option {{$employeeSchedule->schedule_id == $officeSchedule->schedule->id ? 'selected' : ''}} value="{{$officeSchedule->schedule->id}}">{{ucfirst($officeSchedule->schedule->name)}}</option>
                            @endforeach
                        </select>

                        @error('schedule_id')
                            <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('schedule_id') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="pass1">{{__('portal.Permissions')}}</label>
                        <select class="custom-select js-example-basic-multiple" name="permissions[]" multiple data-placeholder="{{__('portal.Select')}}">
                            @foreach($permissions as $id => $permission)
                                <option {{ (in_array($id, old('permissions', [])) || $employee->getAllPermissions()->pluck('id')->contains($id)) ? 'selected' : '' }} value="{{$id}}">{{ucfirst($permission)}}</option>
                            @endforeach
                        </select>
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
            $('.js-example-basic-multiple').select2();
            $('#schedules').select2();
        });

        $("#office").change(function (e) {
            let option = '';
            $('#schedules').prop('disabled', true);
            $.ajax({
                url: "{{route('getSchedules')}}",
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    office_id: $('#office').val(),
                },
                success: function(result){
                    $('#schedules').prop('disabled', false);
                    $('#schedules').empty();
                    $('#schedules').select2({ placeholder: 'Select schedules' });
                    result.schedules.forEach(function (schedule) {
                        option = "<option value='" + schedule.id + "'>" + schedule.name + "</option>"
                        $('#schedules').append(option);
                    });
                },
                error: function(result){
                    console.log('error');
                }
            });
        });
    </script>
@endsection
