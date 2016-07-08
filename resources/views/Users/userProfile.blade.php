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
        Hi <?php echo $userName?>
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
    <div class="col-md-12">
        <div class="box">
            <div class="box-body">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#profile" data-toggle="tab">Profile</a></li>
                            <li><a href="#editProfile" data-toggle="tab">Edit Profile</a></li>
                            <li><a href="#editPassword" data-toggle="tab">Edit Password</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="active tab-pane" id="profile">
                                <center>
                                    <img class="img-circle" src="{{ URL::asset('assets/images/'.$imgPath.'') }}" width="300" alt="User profile picture">
                                    </center>
                                    <h3 class="profile-username text-center"><?php echo $userName; ?></h3>
                                    <p class="text-muted text-center">Administrator</p>
                                    <ul class="list-group list-group-unbordered">
                                        <li class="list-group-item">
                                          <b>Email</b> <a class="pull-right"><?php echo $userEmail; ?></a>
                                        </li>
                                    </ul>
                                </center>
                            </div>
                            <div class="tab-pane" id="editPassword">
                                <div class="box-body table-responsive no-padding">
                                    {!! Form::open( array(
                                        'method' => 'post',
                                        'id' => 'form-add-setting',
                                        'action' => 'userController@updatePassword',
                                        'enctype' => 'multipart/form-data',
                                        'class' => 'col s12',
                                        'files' => true
                                    ) ) !!}
                                    <div class="form-group col-md-8 ">
                                        <label for="oldpassword">Current Password:</label>
                                        <input id = "oldpassword" name = "oldpassword" type="password" class="form-control" placeholder="Current Password">
                                    </div>
                                    <div class="form-group col-md-8 ">
                                        <label for="newpassword">New Password:</label>
                                        <input id = "newpassword" name = "newpassword" type="password" class="form-control" placeholder="Must be atleast 6 characters">
                                    </div>
                                    <div class="form-group col-md-8 ">
                                        <label for="confirmpassword">Confirm Password:</label>
                                        <input id = "confirmpassword" name = "confirmpassword"type="password" class="form-control" placeholder="Retype new password">
                                    </div>
                                    <div class="form-group col-md-8 ">
                                        <input type="submit" class="btn btn-primary btn-flat" name="btnSubmit" value="Update Password">
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                            <div class="tab-pane" id="editProfile">
                                <div class="box-body  no-padding">
                                    {!! Form::open( array(
                                        'method' => 'post',
                                        'id' => 'form-add-setting',
                                        'action' => 'userController@updateProfile',
                                        'enctype' => 'multipart/form-data',
                                        'class' => 'col s12',
                                        'files' => true
                                    ) ) !!}
                                    <center>
                                        <div class="col s12">
                                            <div class="card-panel2 tooltipped" data-position="top" data-delay="50" data-tooltip="logo picture">
                                                <img class="img-circle" id="user-pic" src="{{ URL::asset('assets/images/'.$imgPath.'') }}" width="300px" style="background-size: contain" /> 
                                            </div>
                                        </div>
                                        <div class="form-group col-md-8 ">
                                            <span class="btn btn-default btn-file">
                                            {!! Form::label( 'file', 'UploadPhoto' ) !!}
                                            {!! Form::file
                                                ('file', array(
                                                'id' => 'file',
                                                'name' => 'image',
                                                'class' => 'form-control btn btn-success btn-xs btn-flat',
                                                'style' => 'display:none',
                                                'onchange' => '$("#upload-file-info").html($(this).val());readURL(this)',
                                                )) 
                                            !!}
                                            </span>
                                        <span class='label label-info btn-flat' id="upload-file-info"></span>
                                        </div>
                                    </center>
                                    <div class="form-group col-md-8 ">
                                        <input type="submit" class="btn btn-primary btn-flat" name="btnSubmit" value="Update Profile">
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div> 
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