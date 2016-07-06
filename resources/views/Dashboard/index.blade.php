@extends('master')
@section('title')
    {{"Dashboard"}}
@stop   
@section('style')
@stop
@section('content')
<!-- START CONTENT -->
    @section('title-page')
        {{"Dashboard"}}
    @stop  
    <!--start container-->
    <div class="col-md-12">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i> Something went wrong!</h4>
                {!! implode('', $errors->all(
                    '<li>:message</li>'
                )) !!}
            </div>
        @endif
        @if (Session::has('message'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                {{ Session::get('message') }}
            </div>
        @endif
    </div>

    <div class="container">
        <div class="row" >
            <div class="col-md-2">
                <div class="col-md-4 panel" style="border-left:8px solid #2c8798; width:260px; height:100px">
                    <div class="panel-body">
                        <div class="info-box-number text-center" style="font-size:200%">{{$TotalPosition}}</div>
                        <div class="info-box-text text-center" style="font-size:130%">Position</div>
                    </div>
                </div>
            </div>

            <div class="col-md-2 col-sm-offset-1">
                <div class="col-md-4 panel" style="border-left:8px solid #b22222; width:260px; height:100px">
                    <div class="panel-body"> 
                        <div class="info-box-number text-center" style="font-size:200%">{{$TotalCandidate}}</div>
                        <div class="info-box-text text-center" style="font-size:130%">Candidate</div>
                    </div>
                </div>
            </div> 

            <div class="col-md-2 col-sm-offset-1">
                <div class="col-md-4 panel" style="border-left: 8px solid #006400; width:260px; height:100px">
                    <div class="panel-body">  
                        <div class="info-box-number text-center" style="font-size:200%">{{$TotalVoter}}</div>
                        <div class="info-box-text text-center" style="font-size:130%">Voter</div>
                    </div>
                </div>
            </div>
        </div>
    </div> 

    <div class="col-md-4">
        <div class="panel" style="width:560px; height:200px;">
            <div class="panel-heading" style="background-color:#DCE046"><i class="glyphicon glyphicon-calendar"></i>
                Putangina mag code
            </div>

            <div class="panel-body">
                <div>
                    <span></span>
                </div>
                <div class="progress">
                    <div>
                    </div>
                    <div class="progress-bar" role="progressbar" aria-valuenow="70"
                    aria-valuemin="0" aria-valuemax="100" style="width:70%; background-color:#B3B71B">
                        70%
                    </div>
                </div>
                <div class="progress">
                    <div>
                    </div>
                    <div class="progress-bar" role="progressbar" aria-valuenow="70"
                    aria-valuemin="0" aria-valuemax="100" style="width:80%; background-color:#B3B71B">
                        80%
                    </div>
                </div> 
                <div class="progress">
                    <div>
                    </div>
                    <div class="progress-bar" role="progressbar" aria-valuenow="70"
                    aria-valuemin="0" aria-valuemax="100" style="width:90%; background-color:#B3B71B">
                        90%
                    </div>
                </div>  
            </div>
        </div>
    </div>

    <div class="col-md-5 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading"><i class="glyphicon glyphicon-calendar"></i> Start Date</div>
            <div class="panel-body">September 26, 2016</div>    
        </div>  
    </div>

    <div class="col-md-5 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading"><i class="glyphicon glyphicon-calendar"></i> End Date</div>
            <div class="panel-body">September 27, 2016</div>  
        </div>  
    </div>

    
    
    
@stop 
@section('script')



@stop