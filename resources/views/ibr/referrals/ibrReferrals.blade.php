@extends('ibr.layout.master')

@section('body')
    <div class="row mt-3">
        <div class="col-12">
            <div class="card-box">
                <h4 style="text-align: center;">{{__('portal.List of IBR referrals')}}</h4>

                <table id="datatable" class="table table-bordered dt-responsive nowrap">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{__('portal.Name')}}</th>
                        <th>{{__('portal.Email')}}</th>
                        <th>{{__('portal.Phone')}}</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($referrals as $referral)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$referral->name}}</td>
                            <td>{{$referral->email}}</td>
                            <td>{{$referral->mobile_number}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

