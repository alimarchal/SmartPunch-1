@extends('theme.master')
@section('body')

    <style>
        ul.tree, ul.tree ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }
        ul.tree ul {
            margin-left: 10px;
        }
        ul.tree li {
            margin: 0;
            padding: 0 7px;
            line-height: 20px;
            color: #369;
            font-weight: bold;
            border-left:2px solid rgb(100,100,100);

        }
        ul.tree li:last-child {
            border-left:none;
        }
        ul.tree li:before {
            position:relative;
            top:-0.3em;
            height:1em;
            width:12px;
            color:white;
            border-bottom:2px solid rgb(100,100,100);
            content:"";
            display:inline-block;
            left:-7px;
        }
        ul.tree li:last-child:before {
            border-left:2px solid rgb(100,100,100);
        }
    </style>
    <div class="row mt-3">
        <div class="col-12">
            <div class="card-box bg-white">
                <h4 class="text-center">Team View</h4>
                @include('teamview.categoryTreeview')



            </div>
        </div>
    </div>
@endsection

