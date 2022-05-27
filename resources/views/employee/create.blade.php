@extends('theme.master')

@section('body')

    <div class="row">
        <div class="col-xl-6 mx-auto">
            <div class="card-box mt-3">

                <h4 class="header-title mt-0 mb-3 text-center">{{__('portal.Enter Employee Details')}}</h4>

                <form action="{{route('employeeCreate')}}" method="POST" id="form" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="office_id">{{__('portal.Office')}} *</label>

                            <select class="custom-select" name="office_id" id="office" required>
                                <option value="" selected>{{__('portal.Select')}}</option>
                                @foreach($offices as $office)
                                    <option value="{{$office->id}}">{{$office->name}}</option>
                                @endforeach
                            </select>

                            @error('office_id')
                            <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('office_id') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
                            @enderror
                        </div>

                        <div class="form-group col-sm-12">
                            <label for="schedules">{{__('portal.Schedule(s) List')}}</label>

{{--                            <select name="schedules[]" class="select2 select2-multiple" id="schedules" multiple required>--}}
                            {{-- Uncomment uper for multiple schedule and comment below --}}
                            <select name="schedule" class="form-control" id="schedules" required>
                            </select>

                            @error('schedules')
                            <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('schedules') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="role_id">{{__('portal.Employee type')}} *</label>

                        <select class="custom-select" name="role_id" id="role_id" required>
                            <option value="" disabled selected>{{__('portal.Select')}}</option>
                            @foreach($roles as $role)
                                <option {{old('role_id') == $role->id ? 'selected' : ''}} value="{{$role->id}}">{{ucfirst($role->name)}}</option>
                            @endforeach
                        </select>

                        @error('role_id')
                            <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('role_id') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="permissions">{{__('portal.Permissions')}}</label>

                        <textarea class="form-control" rows="4" id="permissions" placeholder="{{__('portal.Permissions')}}" disabled></textarea>
                    </div>

                    <div class="form-group">
                        <label for="name">{{__('portal.Name')}} *</label>
                        <input type="text" name="name" parsley-trigger="change" placeholder="{{__('portal.Enter employee name')}}" class="form-control @error('name') parsley-error @enderror" value="{{old('name')}}" required>

                        @error('name')
                            <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('name') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">{{__('portal.Email')}} *</label>
                        <input type="email" name="email" parsley-trigger="change" placeholder="{{__('portal.Enter employee email')}}" class="form-control @error('email') parsley-error @enderror" id="userName" value="{{old('email')}}" required>

                        @error('email')
                            <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('email') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">{{__('portal.Password')}} *</label>
                        <input class="form-control @error('password') parsley-error @enderror" type="password" name="password" id="password" placeholder="{{__('portal.Enter password')}}" required>

                        @error('password')
                            <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required"> @foreach ($errors->get('password') as $error) <li>{{ $error }}</li> @endforeach </li></ul>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone">{{__('portal.Phone')}}</label>
                        <input type="tel" name="phone" parsley-trigger="change" placeholder="{{__('portal.Enter employee phone')}}" class="form-control @error('phone') parsley-error @enderror" id="phone" value="{{old('phone')}}">

                        @error('phone')
                        <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('phone') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="parent_id">{{__('portal.Immediate boss')}}</label>

                        <select id="parent_id" class="custom-select" name="parent_id">
                            <option value="">{{__('portal.Select')}}</option>
                            @foreach($employees as $employee)
                                <option value="{{$employee->id}}">{{$employee->name}}</option>
                            @endforeach
                        </select>

                        @error('parent_id')
                        <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('parent_id') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="employee_business_id">{{__('portal.Employee ID')}}</label>
                        <input type="text" id="employee_business_id" name="employee_business_id" parsley-trigger="change" placeholder="{{__('portal.Enter Employee ID (if any)')}}" class="form-control @error('employee_business_id') parsley-error @enderror" value="{{old('employee_business_id')}}">

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


@section('scripts')
    <link href="{{ url('select2/src/select2totree.css') }}" rel="stylesheet">
    <script src="{{ url('select2/src/select2totree.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2();
            $("#schedules").prop("disabled", true);
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

        $("#role_id").change(function (e) {
            let option = '';
            $('#permissions').prop('disabled', true);
            $.ajax({
                url: "{{route('permissionsSearch')}}",
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    role_id: $('#role_id').val(),
                },
                success: function(result){
                    $('#permissions').empty();
                    result.permissions.forEach(function (permissions) {
                        option = permissions + ', ' ;
                        $('#permissions').append(option);
                    });
                },
                error: function(){
                    console.log('error');
                }
            });
        });

        var mydata = [
            @include('employee.children', ['employees' => $employees])
        ];
        $(".children").select2ToTree({
            treeData: {
                dataArr: mydata
            },
            maximumSelectionLength: 1
        });
    </script>
@endsection
