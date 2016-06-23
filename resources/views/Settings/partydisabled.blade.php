@extends('master')
@section('title')
    {{"Party is Disabled Settings"}}
@stop   
@section('style')
    <style>
        .box{
            visibility: hidden;
        }
    </style>
@stop
@section('content')
<!-- START CONTENT -->
    @section('title-page')
        {{"&nbsp;"}}
    @stop  
    <div class="error-page">
        <h2 class="headline text-yellow"> 665</h2>
        <div class="error-content" style="margin-top:15%;">
            <h3 style="padding-top:10%;"><i class="fa fa-warning text-yellow"></i> Oops! Party affiliation is disabled</h3>
            <p>
                The page you requested is disabled.
                Meanwhile, you may <a href="{{ URL::to('/settings/general') }}">change this setting</a> or contact your administrator.
            </p>
        </div>
    </div>
@stop 
@section('script')

@stop