@extends('master')
@section('title')
    {{"User Profile"}}
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
        {{"User Profile"}}
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
    </div>
    <div class="col-md-8">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Profile</h3>
            </div>
            <div class="box-body box-profile">
                <center>
                <img class="img-responsive img-circle" src="{{ URL::asset('assets/images/'.$imgPath.'') }}" width="300" height="300" alt="User profile picture">
                </center>
                <h3 class="profile-username text-center"><?php echo $userName; ?></h3>
                <p class="text-muted text-center">Administrator</p>
                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                      <b>Email</b> <a class="pull-right"><?php echo $userEmail; ?></a>
                    </li>
                </ul>
                
                <a href="{{ URL::to('/user/edit') }}" class="btn btn-primary ">Edit Profile</a>
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
                    $('#cand-pic')
                    .attr('src', e.target.result)
                    .width(150)
                    .height(150);
                    
                };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<script> 
    function readURL(input) {
        alert("add");
        if (input.files && input.files[0]) {
            var reader = new FileReader();
                reader.onload = function (e) {
                    $('#cand-pic')
                    .attr('src', e.target.result)
                    .width(150)
                    .height(150);
                    
                };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<script src="{{ URL::asset('assets/plugins/select2/select2.full.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/colorpicker/bootstrap-colorpicker.min.js') }}"></script>
<script>
    //Colorpicker
    $(".my-colorpicker1").colorpicker();
    //color picker with addon
    $(".my-colorpicker2").colorpicker();

</script>

@stop