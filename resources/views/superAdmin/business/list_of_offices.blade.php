@extends('superAdmin.layout.master')

@section('body')
    <div class="row mt-3">
        <div class="col-12">
            <div class="form-group text-right mb-0">
                <a href="{{route('superAdmin.businesses')}}" class="btn btn-purple waves-effect waves-light mr-1 text-white"> {{__('portal.Businesses list')}} </a>
            </div>
            <div class="card-box mt-3">
                <h4 style="text-align: center;">{{__('portal.List of offices')}}</h4>
                <h4 style="text-align: center;">{{$offices[0]->business->company_name}}</h4>

                <table id="datatable" class="table table-bordered dt-responsive nowrap">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{__('portal.Office Name')}}</th>
                        <th>{{__('portal.Email')}}</th>
                        <th>{{__('portal.Total employees')}}</th>
                        <th>{{__('portal.City Name')}}</th>
                        <th>{{__('portal.Phone')}}</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($offices as $office)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$office->name}}</td>
                            <td>{{$office->email}}</td>
                            <td>
                                @if(count($office->employees) > 0)
                                    <a href="{{route('superAdmin.listOfBusinessOfficesEmployees', encrypt($office->id) )}}" style="color: limegreen;text-decoration: underline">{{count($office->employees)}}</a>
                                @else
                                    <span class="text-danger">{{count($office->employees)}}</span>
                                @endif
                            </td>
                            <td>{{$office->city}}</td>
                            <td>{{$office->phone}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

