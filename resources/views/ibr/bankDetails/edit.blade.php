@extends('ibr.layout.master')

@section('body')

    <div class="row">
        <div class="col-xl-6 mx-auto">
            <div class="card-box mt-3">

                <h4 class="header-title mt-0 mb-3 text-center">{{__('portal.Update Bank Details')}}</h4>

                <form action="{{route('ibr.bank-details')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="bank">{{__('portal.Bank Name')}} *</label>
                        <input id="bank" name="bank" class="form-control @error('bank') parsley-error @enderror" placeholder="{{__('portal.Enter bank name')}}" value="{{auth()->guard('ibr')->user()->bank}}" required>

                        @error('bank')
                        <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('bank') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="iban">{{__('portal.IBAN #')}} *</label>
                        <input id="iban" name="iban" class="form-control @error('iban') parsley-error @enderror" placeholder="{{__('portal.Enter IBAN number')}}" value="{{auth()->guard('ibr')->user()->iban}}" required>

                        @error('iban')
                        <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('iban') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="country_of_bank">{{__('register.Country of bank')}} *</label>
                        <select name="country_of_bank" id="country_of_bank" class="form-control @error('country_of_bank') parsley-error @enderror select2" data-placeholder="{{__('portal.Select')}}" required>
                            @foreach($countries as $country)
                                <option {{auth()->guard('ibr')->user()->country_of_bank == $country->name ? 'selected' : ''}} value="{{$country->id}}">{{$country->name}}</option>
                            @endforeach
                        </select>

                        @error('country_of_bank')
                        <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false"><li class="parsley-required">@foreach ($errors->get('country_of_bank') as $error) <li>{{ $error }}</li> @endforeach</li></ul>
                        @enderror
                    </div>

                    <div class="form-group mb-0 text-center">
                        <button class="btn btn-purple btn-block" onclick="return confirm('Are your sure?')" type="submit"> {{__('register.Update')}} </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function(e) {
            $('.select2').select2();
        });
    </script>
@endsection
