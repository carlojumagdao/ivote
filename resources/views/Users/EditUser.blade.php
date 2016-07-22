@extends('master')
@section('title')
    {{"User Edit"}}
@stop   
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/datatables/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/datatables/datatables-responsive/css/dataTables.responsive.css') }}">
@stop
@section('content')
<!-- START CONTENT -->
    @section('title-page')
        {{"Edit User"}}
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
        @if (Session::has('error'))
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i> Something went wrong!</h4>
                {{ Session::get('error') }}
            </div>
        @endif
    </div>

    <div class="col-md-8">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">User Information</h3>
            </div>
            <div class="box-body table-responsive no-padding">
                {!! Form::open( array(
                    'method' => 'post',
                    'id' => 'form-add-setting',
                    'action' => 'userController@updateUser',
                    'enctype' => 'multipart/form-data',
                    'class' => 'col s12',
                    'files' => true
                ) ) !!}
                <center>
                <br>
                    <div class="col s12">
                        <div class="card-panel2 tooltipped" data-position="top" data-delay="50" data-tooltip="logo picture">
                            <img class="img-circle" id="usr-pic" src="{{ URL::asset('assets/images/'.$img.'') }}" width="300px" style="background-size: contain" /> 
                        </div>
                    </div>
                </center>
                <div class="form-group col-md-8 ">
                    <span class="btn btn-default btn-file">
                    {!! Form::label( 'file', 'Change Photo' ) !!}
                    {!! Form::file
                        ('file', array(
                        'id' => 'file',
                        'name' => 'image',
                        'class' => 'form-control btn btn-success btn-xs',
                        'style' => 'display:none',
                        'onchange' => '$("#upload-file-info").html($(this).val());readURL(this)',
                        )) 
                    !!}
                    </span>
                    <span class='label label-info' id="upload-file-info"></span>
                </div>
                <div class="form-group col-md-12 ">
                    <label for="id">UserID:</label>
                    <input id = "id" name = "id" type="text" class="form-control" readonly value=<?php echo $id?>>
                </div>
                <div class="form-group col-md-12 ">
                    <label for="name">Name:</label>
                    <input id = "name" name = "name" type="text" class="form-control" value=<?php echo $name?>>
                </div>
                <div class="form-group col-md-12 ">
                    <label for="email">Email:</label>
                    <input id = "email" name = "email" type="email" class="form-control" value=<?php echo $email?>>
                </div>
                <div class="form-group col-md-12 ">
                    <input type="submit" class="btn btn-primary" name="btnSubmit" value="Update User">
                </div>
                        {!! Form::close() !!}
                </div>
            
        </div>
    </div> 

@stop 
@section('script')
<script src="{{ URL::asset('assets/datatables/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/datatables/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js') }}"></script>

<script> 
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
                reader.onload = function (e) {
                    $('#usr-pic')
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