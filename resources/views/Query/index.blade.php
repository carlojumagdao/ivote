@extends('master')
@section('title')
    {{"Queries"}}
@stop   
@section('style')
@stop
@section('content')
<!-- START CONTENT -->
    @section('title-page')
        {{"Queries"}}
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
    <div class ="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Queries</h3>
            </div>
            
            <div class="box-footer">
                Footer
            </div>
        </div>   
    </div>

@stop 
