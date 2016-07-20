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
    <div class="col-md-12">
        <div class="col-lg-3 col-xs-6">
            <div class="panel" style="border-left:8px solid #2c8798;color:#2c8798;">
                <a href="{{ URL::to('dashboard/position') }}">
                    <div class="panel-body">
                        <div class="info-box-number text-center" style="font-size:70px;" > {{$TotalPosition}}</div>
                        <div class="info-box-text text-center" style="font-size:130%">Position</div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="panel" style="border-left:8px solid #006400;color:#006400;">
                <a href="{{ URL::to('dashboard/candidate') }}">
                    <div class="panel-body"> 
                        <div class="info-box-number text-center" style="font-size:70px">{{$TotalCandidate}}</div>
                        <div class="info-box-text text-center" style="font-size:130%">Candidate</div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="panel" style="border-left:8px solid #b22222;color:#b22222;">
                <a href="{{ URL::to('dashboard/voter') }}">
                    <div class="panel-body">  
                        <div class="info-box-number text-center" style="font-size:70px">{{$TotalVoter}}</div>
                        <div class="info-box-text text-center" style="font-size:130%">Voter</div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="panel" style="border-left:8px solid #605ca8;color:#605ca8;">
                <a href="{{ URL::to('dashboard/voted') }}">
                    <div class="panel-body">  
                        <div class="info-box-number text-center" style="font-size:70px">{{$TotalVoted}}</div>
                        <div class="info-box-text text-center" style="font-size:130%">Voted</div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-3 col-xs-6">
            <div class="panel panel-default">
                <div class="panel-heading"><i class="glyphicon glyphicon-calendar"></i> Start Date</div>
                <div class="panel-body">{{$start}}</div>    
            </div>  
        </div>
        <div class="col-md-3 col-xs-6">
            <div class="panel panel-default">
                <div class="panel-heading"><i class="glyphicon glyphicon-calendar"></i> End Date</div>
                <div class="panel-body">{{$end}}</div>  
            </div>  
        </div>
    </div> 

    

    
    
    
@stop 
@section('script')



@stop