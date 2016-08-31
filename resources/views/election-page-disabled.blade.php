@extends('master')
@section('title')
    {{"Disabled Page"}}
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
            <h3 style="padding-top:10%;"><i class="fa fa-warning text-yellow"></i> Oops! The Election is Ongoing</h3>
            <p>
                The page you requested is disabled.
                You cannot add or edit anywhere in the system while Election is Ongoing or contact your administrator.
            </p>
        </div>
    </div>
@stop 
@section('script')

@stop