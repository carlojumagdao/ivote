@extends('master')
@section('title')
    {{"User"}}
@stop   
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/datatables/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/datatables/datatables-responsive/css/dataTables.responsive.css') }}">
@stop
@section('content')
<!-- START CONTENT -->
    @section('title-page')
        {{"Add User"}}
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
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">User Form</h3>
            </div>
            <div class="box-body table-responsive no-padding">
                {!! Form::open( array(
                    'method' => 'post',
                    'id' => 'form-add-setting',
                    'action' => 'userController@add',
                    'enctype' => 'multipart/form-data',
                    'class' => 'col s12',
                    'files' => true
                ) ) !!}
                <center>
                    <div class="col s12">
                        <div class="card-panel2 tooltipped" data-position="top" data-delay="50" data-tooltip="logo picture">
                            <img id="user-pic" src="../assets/images/ivote.jpg" width="180px" style="background-size: contain;" /> 
                        </div>
                    </div>
                </center>
                <div class="form-group col-md-12 ">
                    <span class="btn btn-default btn-file">
                    {!! Form::label( 'file', 'File Path:' ) !!}
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
                <div class="box-body">
                    <div class="form-group col-md-12 ">
                        {!! Form::label( 'Name', 'Name:' ) !!}
                        {!! Form::text
                            ('Name', '', array(
                            'id' => 'Name',
                            'placeholder' => "Full Name",
                            'name' => 'name',
                            'class' => 'form-control',
                            'required' => true,)) 
                        !!}  
                    </div>
                    <div class="form-group col-md-12 ">
                        {!! Form::label( 'Email', 'Email:' ) !!}
                        {!! Form::email
                            ('Email', '', array(
                            'id' => 'Email',
                            'placeholder' => "Email",
                            'name' => 'email',
                            'class' => 'form-control',
                            'required' => true,)) 
                        !!}  
                    </div>
                    <div class="form-group col-md-12 ">
                        {!! Form::label( 'password', 'Password:' ) !!}
                        {!! Form::password
                            ('password', '', array(
                            'id' => 'password',
                            'maxlength' => 50,
                            'name' => 'password',
                            'required' => true,)) 
                        !!}
                    </div>
                        <input type="submit" class="btn btn-primary" name="btnSubmit" value="Submit">
                        {!! Form::close() !!}
                </div>
            <div class="box-footer">
                Footer
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
                    $('#user-pic')
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