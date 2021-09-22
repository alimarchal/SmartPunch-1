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
                        <th>{{__('portal.Edit')}} </th>
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
                            <td><a href="{{route('officeEdit', encrypt($office->id))}}"><i class="fa fa-pencil-alt text-primary"></i></a> </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

