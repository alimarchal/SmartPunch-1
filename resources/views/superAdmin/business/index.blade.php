@extends('superAdmin.layout.master')

@section('body')
    <div class="row mt-3">
        <div class="col-12">
            <div class="card-box">
                <h4 style="text-align: center;">{{__('portal.List of businesses')}}</h4>

                <table id="datatable" class="table table-bordered dt-responsive nowrap">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{__('portal.Company Name')}}</th>
                        <th>{{__('portal.Owner Email ID')}}</th>
                        <th>{{__('portal.Total Offices')}}</th>
                        <th>{{__('portal.Country Name')}}</th>
                        <th>{{__('portal.Country Code')}}</th>
                        <th>{{__('portal.City Name')}}</th>
                        <th>{{__('portal.Company Logo')}}</th>
                        @can('delete office')
                            <th>{{__('portal.Action')}} </th>
                        @endcan
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($businesses as $business)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$business->company_name}}</td>
                            <td>{{$business->user->email}}</td>
                            <td>
                                @if(count($business->offices) > 0)
                                    <a href="{{route('superAdmin.businessOffices', encrypt($business->id) )}}" style="color: limegreen;text-decoration: underline">{{count($business->offices)}}</a>
                                @else
                                    <span class="text-danger">{{count($business->offices)}}</span>
                                @endif
                            </td>
                            <td>{{$business->country_name}}</td>
                            <td>{{$business->country_code}}</td>
                            <td>{{$business->city_name}}</td>
                            <td><img src="{{$business->company_logo}}" alt="{{$business->company_name}}" height="24"> </td>
                            @can('delete office')
                                <td>
                                    <a href="javascript:void(0)"><i class="fa fa-pencil-alt text-primary"></i></a>
                                    <a href="javascript:void(0)" onclick="return confirm('Are you to delete this business?')"><i class="fa fa-trash-alt text-danger ml-2"></i></a>
                                </td>
                            @endcan
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

