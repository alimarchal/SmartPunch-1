@extends('theme.master')

@section('body')
    <div class="row mt-3">
        <div class="col-12">
            <div class="card-box">
                <h4 style="text-align: center;">{{__('portal.List of offices')}}</h4>

                <table id="datatable" class="table table-bordered dt-responsive nowrap">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{__('portal.Name')}}</th>
                        <th>{{__('portal.Email')}}</th>
                        <th>{{__('portal.Address')}}</th>
                        <th>{{__('portal.City Name')}}</th>
                        <th>{{__('portal.Phone')}}</th>
                        @can('delete office')
                        <th>{{__('portal.Action')}} </th>
                        @endcan
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($offices as $office)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$office->name}}</td>
                            <td>{{$office->email}}</td>
                            <td>{{$office->address}}</td>
                            <td>{{$office->city}}</td>
                            <td>{{$office->phone}}</td>
                            @can('delete office')
                            <td>
                                <a href="{{route('officeEdit', encrypt($office->id))}}"><i class="fa fa-pencil-alt text-primary"></i></a>
                                <a href="{{route('officeDelete', encrypt($office->id))}}" onclick="return confirm('Are you to delete this office?')"><i class="fa fa-trash-alt text-danger ml-2"></i></a>
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

