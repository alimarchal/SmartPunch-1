@extends('theme.master')

@section('body')
    <div class="row mt-3">
        <div class="col-12">
            <div class="card-box">
                <h4 class="text-center">Team View</h4>
                @include('teamview.categoryTreeview')
            </div>
        </div>
    </div>
@endsection

