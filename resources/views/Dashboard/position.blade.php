@extends('master')
@section('title')
    {{"Positions"}}
@stop   
@section('style')
    <style>
        #content{
            padding: 30px;
            height: 0 auto;
            margin: 0 auto;
            display: flex;
            justify-content: center;
            resize: both;
            overflow: auto;
            flex-wrap: nowrap;
        }
    </style>
@stop
@section('content')
<!-- START CONTENT -->
    @section('title-page')
        {{"Positions"}}
    @stop  

    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h1 class="box-title">List of all Positions</h1>
            </div>
            <div class="box-body">
                <center>
                    <img src='{{ URL::asset("assets/images/$logo") }}' style="max-width: 200px;">
                    <br>
                    <h3>{{$election}}</h3>
                    <h4>{{$org}}</h4>
                    <h5>{{$address}}</h5>
                </center>
                <div id="content">
                    <div class="col-md-6" >
                        <ul class="list-group list-group-unbordered">
                            <h3 class="list-group-item-heading with-border">Position <a class="pull-right">Vote Limit</a></h3>
                            @foreach($Positions as $value)
                                <li class="list-group-item">
                                    <b>{{$value->strPosName}}</b>
                                    <a class="pull-right">{{$value->intPosVoteLimit}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                Footer
            </div>
        </div>
    <div>

@stop 
