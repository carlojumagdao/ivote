@extends('master')
@section('title')
    {{"User Information"}}
@stop   
@section('style')
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/colorpicker/bootstrap-colorpicker.min.css') }}">
    <style>
        .colorpicker {
            z-index: 9999 !important;
        }
    </style>
@stop
@section('content')

<?php 
  $userName = session('name');
  $userEmail = session('email');
  $imgPath = session('picname');
?>

<!-- START CONTENT -->
    @section('title-page')
        {{"User Information"}}
    @stop  
    <!--start container-->
    <div class="col-md-12">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i> Something went wrong!</h4>
                {!! implode($errors->all(
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
        @if (Session::has('error'))
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i> Something went wrong!</h4>
                {{ Session::get('error') }}
            </div>
        @endif        
    </div>
    <div class="col-md-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">User Information</h3>
            </div>
            <div class="box-body box-profile">
                <center>
                    <img class="img-circle" src="{{ URL::asset('assets/images/'.$img.'') }}" width="300" alt="User profile picture">
                </center>
                <ul class="list-group list-group-unbordered" style=" padding:40px">
                    <li class="list-group-item">
                        <b>Name</b> <a class="pull-right"><?php echo $name; ?></a>
                    </li>
                    <li class="list-group-item">
                        <b>Email</b> <a class="pull-right"><?php echo $email; ?></a>
                    </li>
                </ul>
            </div>
            <div class="box-footer">
                Footer
            </div>
        </div>
    </div>
    
@stop 
@section('script')
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip(); 
    });
</script>
<script> 
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
                reader.onload = function (e) {
                    $('#user-pic')
                    .attr('src', e.target.result);
                };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<script src="{{ URL::asset('assets/plugins/select2/select2.full.min.js') }}"></script>

@stop