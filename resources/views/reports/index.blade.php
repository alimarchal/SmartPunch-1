@extends('theme.master')

@section('body')



    <div class="row mt-3">
        <div class="col-12">
            <div class="card-box">
                <h4 style="text-align: center;">Attendance Report</h4>

                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Office</th>
                        <th>Employee Business ID</th>
                        <th>Time In</th>
                        <th>Time Out</th>
                        <th>Total Time</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($punch as $pun)
                        <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$pun->name}}</td>
                        <td>{{$pun->office_name}}</td>
                        <td>{{$pun->employee_business_id}}</td>
                        <td>{{$pun->time_in}}</td>
                        <td>{{$pun->time_out}}</td>
                        <td>
                            @php
                                $time_out = \Carbon\Carbon::parse($pun->time_out)->format('H:s');
                                $time_in = \Carbon\Carbon::parse($pun->time_in)->format('H:s');

                                $t1 = strtotime($time_out);
                                $t2 = strtotime($time_in);

                                ;
                            @endphp
                            {{ gmdate('H:i', $t1 - $t2) }}
                        </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>


            </div>
        </div>
    </div>



@endsection
