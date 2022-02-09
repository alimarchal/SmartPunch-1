@extends('ibr.layout.master')

@section('body')
    <div class="row mt-3">
        <div class="col-12">
            <div class="card-box">
                <h4 style="text-align: center;">{{__('portal.List of business referrals')}}</h4>

                <table id="datatable" class="table table-bordered dt-responsive nowrap">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{__('portal.Business Name')}}</th>
                        <th>{{__('portal.Email')}}</th>
                        <th>{{__('portal.Phone')}}</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($referrals as $referral)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$referral->company_name}}</td>
                            <td>{{$referral->user->email}}</td>
                            <td>{{$referral->user->phone}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

