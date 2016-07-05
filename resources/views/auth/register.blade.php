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
            <form method="POST" action="/auth/register">
            {!! csrf_field() !!}
            <div class="box-header with-border">
                <h3 class="box-title">User Form</h3>
            </div>
            <div class="box-body table-responsive no-padding">
                <center>
                    <div class="col s12">
                        <div class="card-panel2 tooltipped" data-position="top" data-delay="50" data-tooltip="logo picture">
                            <img id="user-pic" src="../assets/images/ivote.jpg" width="180px" style="background-size: contain" /> 
                        </div>
                    </div>
                </center>
                <div class="form-group col-md-12 ">
                    <span class="btn btn-default btn-file">
                    <label for="file">File Path:</label>
                    <input id="file" name="image" class="form-control btn btn-success btn-xs" style="display:none" onchange="$(&quot;#upload-file-info&quot;).html($(this).val());readURL(this)" type="file">
                    </span>
                    <span class='label label-info' id="upload-file-info"></span>
                </div>
                <div class="box-body">
                    <div class="form-group col-md-12 ">
                        <label for="Name">Name:</label>
                        <input id="Name" placeholder="Full Name" name="name" class="form-control" required="1" type="text" value="{{ old('name') }}">  
                    </div>
                    <div class="form-group col-md-12 ">
                        <label for="Email">Email:</label>
                        <input id="Email" placeholder="Email" name="email" class="form-control" required="1" type="email" value="{{ old('email') }}">  
                    </div>
                    <div class="form-group col-md-12 ">
                        <label for="password">Password:</label>
                        <input name="password" type="password" value="" id="password">
                    </div>
                    <div class="form-group col-md-12 ">
                        <label for="password">Confirm Password:</label>
                        <input name="password_confirmation" type="password" value="" id="password_confirm">
                    </div>
                        <input type="submit" class="btn btn-primary" name="btnRegister" value="Register">
                </div>
                </form>
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
@stop