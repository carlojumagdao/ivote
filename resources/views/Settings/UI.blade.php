@extends('master')
@section('title')
    {{"UI Element Settings"}}
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
<!-- START CONTENT -->
    @section('title-page')
        {{"UI Element Settings"}}
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
    
    <div class="col-md-5">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">ADMIN UI Skin Themes</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <form action="{{ URL::to('/settings/UI/skin') }}" method="POST" role="form" >
                    <div class="row">
                        <div class="col-md-4">
                            <input type="radio" name="theme" value="skin-blue" checked>&nbsp&nbsp blue dark
                        </div>
                        <div class="col-md-1">
                            <i class="fa fa-eye btn btn-primary btn-xs"></i>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <input type="radio" name="theme" value="skin-blue-light">&nbsp&nbsp blue light
                        </div>
                        <div class="col-md-1">
                            <i class="fa fa-eye btn btn-primary btn-xs"></i>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <input type="radio" name="theme" value="skin-yellow">&nbsp&nbsp yellow dark
                        </div>
                        <div class="col-md-1">
                            <i class="fa fa-eye btn btn-warning btn-xs"></i>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <input type="radio" name="theme" value="skin-yellow-light">&nbsp&nbsp yellow light
                        </div>
                        <div class="col-md-1">
                            <i class="fa fa-eye btn btn-warning btn-xs"></i>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <input type="radio" name="theme" value="skin-green">&nbsp&nbsp green dark
                        </div>
                        <div class="col-md-1">
                            <i class="fa fa-eye btn btn-success btn-xs"></i>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <input type="radio" name="theme" value="skin-green-light">&nbsp&nbsp green light
                        </div>
                        <div class="col-md-1">
                            <i class="fa fa-eye btn btn-success btn-xs"></i>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <input type="radio" name="theme" value="skin-purple">&nbsp&nbsp purple dark
                        </div>
                        <div class="col-md-1">
                            <i class="fa fa-eye btn bg-purple btn-xs"></i>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <input type="radio" name="theme" value="skin-purple-light">&nbsp&nbsp purple light
                        </div>
                        <div class="col-md-1">
                            <i class="fa fa-eye btn bg-purple btn-xs"></i>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <input type="radio" name="theme" value="skin-red">&nbsp&nbsp red dark
                        </div>
                        <div class="col-md-1">
                            <i class="fa fa-eye btn btn-danger btn-xs"></i>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <input type="radio" name="theme" value="skin-red-light">&nbsp&nbsp red light
                        </div>
                        <div class="col-md-1">
                            <i class="fa fa-eye btn btn-danger btn-xs"></i>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <input type="radio" name="theme" value="skin-black">&nbsp&nbsp white dark
                        </div>
                        <div class="col-md-1">
                            <i class="fa fa-eye btn bg-black btn-xs"></i>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <input type="radio" name="theme" value="skin-black-light">&nbsp&nbsp white light
                        </div>
                        <div class="col-md-1">
                            <i class="fa fa-eye btn bg-black btn-xs"></i>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="form-group col-md-12 ">
                        <input type="submit" class="btn btn-primary" name="btnSubmit" value="Submit">
                    </div> 
                    
                </form>
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
                    $('#cand-pic1')
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