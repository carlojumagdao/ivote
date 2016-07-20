@extends('master')
@section('title')
    {{"Candidates"}}
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
        {{"Candidates"}}
    @stop  

    <div class ="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">List of all Candidates</h3>
            </div>
            <div class="box-body" style="padding:40px" >
                <center>
                    <img src='{{ URL::asset("assets/images/$logo") }}' style="max-width: 200px;">
                    <br>
                    <h3>{{$election}}</h3>
                    <h4>{{$org}}</h4>
                    <h5>{{$address}}</h5>
                </center>
                <ul class="users-list clearfix">
                    @foreach($partylist as $party)
                        <div class="col-md-12 row panel" style="border-left: 4px solid {{$party->strPartyColor}}; background-color:#eee">
                            <div class="col-md-12">
                                <h3>{{$party->strPartyName}}</h3>
                                @foreach($positions as $position)
                                    @foreach($candidates as $candidate)
                                        @if($candidate->strCandPosId == $position->strPositionId )
                                        @if($candidate->intCandParId == $party->intCandParId)
                                         <div class="col-md-2">
                                            <li>
                                                <center>
                                                    <img class="img-circle" height="150" width="150" id="cand-pic" src="../assets/images/{{$candidate->txtCandPic}}">
                                                    <a class="users-list-name">{{$candidate->strMemFname}} {{$candidate->strMemLname}}</a>
                                                    <span class="users-list-position">{{$position->strPosName}}</span>
                                                </center>
                                            </li>
                                        </div>
                                        @endif
                                        @endif
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </ul>
            </div>
            <div class="box-footer">
                Footer
            </div>
        </div>   
    </div>
@stop 
