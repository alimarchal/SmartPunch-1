@extends('theme.master')

@section('body')

    <form action="{{route('message.toTeams')}}" method="POST">
        @csrf
        <h4 class="header-title mt-3 text-center">{{__('portal.Send Message')}}</h4>

        <div class="row">
            <div class="col-12">
                <div class="p-2">
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label" for="teamIDs">{{__('portal.List of teams')}}:</label>
                        <div class="col-md-10">
                            <select class="custom-select select2 select2-multiple" name="teamIDs[]" multiple="multiple" id="teamIDs">
                                @foreach($employees as $employee)
                                    <option value="{{$employee->parent_id}}"> {{ __('portal.Team') . '-' . $employee->parent_id }} </option>
                                @endforeach
                            </select>

                            @error('teamIDs')
                            <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('teamIDs') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="p-2">
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label" for="message">{{__('portal.Message')}}:</label>
                        <div class="col-md-10">
                            <textarea class="form-control @error('message') parsley-error @enderror" rows="5" name="message" placeholder="{{__('portal.Enter message')}}"></textarea>
                            @error('message')
                            <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('message') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group text-right mb-0 float-right">
            <button class="btn btn-primary waves-effect waves-light mr-1" type="submit">
                {{__('portal.Submit')}}
            </button>
        </div>
    </form>
    <br><br>

    @if($employees->count() > 0)
    <form action="{{ route('message.byTeams', encrypt($employee->parent_id))  }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="p-2">
                    <input type="hidden" id="team_id" name="team_id">
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label" for="teamID">{{__('portal.Select Team to see History')}}:</label>
                        <div class="col-md-2">
                            <select class="custom-select" name="teamID" id="teamID" required>
                                <option value="" selected> {{ __('portal.Select') }} </option>
                                @foreach($employees as $employee)
                                    <option value="{{$employee->parent_id}}"> {{ __('portal.Team') . '-' . $employee->parent_id }} </option>
                                @endforeach
                            </select>

                            @error('teamIDs')
                            <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('teamIDs') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
                            @enderror
                        </div>
                        <div class="form-group text-right mb-0">
                            <button href="" class="btn btn-purple waves-effect waves-light mr-1 text-white" type="submit"> {{__('portal.View Message History')}} </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @endif

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            @if(auth()->user()->rtl == 0)
            $('.select2').select2();
            @else
            $('.select2').select2({
                dir: "rtl"
            });
            @endif

            $('#teamID').click(function (e){
                e.preventDefault();
                $('#team_id').val($('#teamID').val());
            })
        });
    </script>
@endsection
