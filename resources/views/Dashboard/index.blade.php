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
    
    <div class="col-md-3" >
        <div class="info-box">
            <span class="info-box-icon bg-green"><i class="glyphicon glyphicon-user"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Number of Position</span>
              <span class="info-box-number">{{$TotalPosition}}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>

    <div class="col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="glyphicon glyphicon-user"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Number of Candidate</span>
              <span class="info-box-number">{{$TotalCandidate}}</span>
            </div>
            <!--/.info-box-content-->
        </div>
        <!-- /.info-box-->
    </div> 

    <div class="col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-red"><i class="glyphicon glyphicon-user"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Number of Voter</span>
              <span class="info-box-number">{{$TotalVoter}}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    
    
@stop 
@section('script')



@stop