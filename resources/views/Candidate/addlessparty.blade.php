@extends('master')
@section('title')
    {{"Party Settings"}}
@stop   
@section('style')
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/colorpicker/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/select2/select2.min.css') }}">
    <style>
        .colorpicker {
            z-index: 9999 !important;
        }
    </style>
@stop
@section('content')
<!-- START CONTENT -->
    @section('title-page')
        {{" ADD Candidates"}}
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
    <div class="col-md-8">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Add New Candidate</h3>
            </div>
            <div class="box-body no-padding">
                {!! Form::open( array(
                    'method' => 'post',
                    'id' => 'form-add-setting',
                    'action' => 'candidateController@newCandidate',
                    'enctype' => 'multipart/form-data',
                    'class' => 'col s12',
                    'files' => true
                ) ) !!}
                <center>
                <div class="col s4">
                    <br>
                    <div class="card-panel2 tooltipped" data-position="top" data-delay="50" data-tooltip="logo picture">
                        <img id="cand-pic" src="../assets/images/Avatar.jpg" style="max-width:180px; background-size: contain" />
                        <center><h4>(2x2 picture only)</h2> </center>
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
                        'required' => true,)) 
                    !!}
                    </span>
                    <span class='label label-info' id="upload-file-info"></span>
                </div>
                 <div class="form-group col-md-12 ">
                     <div class="col-md-2 ">
                     {!! Form::label( 'member', 'Candidate Name:' ) !!}
                     </div>
                     <div class="col-md-10">
                     <select name="member" class="form-control select2" required>
                         <option></option>
                         @foreach($Members as $Member)
                         <option value='{{$Member->strMemberId}}'>{{$Member->strMemFname}} {{$Member->strMemLname}}</option>
                         @endforeach
                     </select>
                     </div>
                </div>
                <div class="form-group col-md-12 ">
                    <div class="col-md-2">
                     {!! Form::label( 'position', 'Position:' ) !!}
                    </div>
                    <div class="col-md-10">
                     <select name="position" class="form-control select2" required>
                         <option></option>
                         @foreach($Positions as $Position)
                         <option value='{{$Position->strPositionId}}'>{{$Position->strPosName}}</option>
                         @endforeach
                     </select>
                    </div>
                </div>
                <div class="form-group col-md-12 ">
                    <div class="col-md-2">
                   {!! Form::label( 'educback', 'Candidate Education Background:' ) !!}
                    </div>
                    <div class="col-md-10">
                        {!! Form::textarea
                            ('educback','' , array(
                            'id' => 'educback',
                            'placeholder' => "This will be use for the campaign page",
                            'name' => 'txtEducback',
                            'class' => 'form-control',
                            'required' => true,)) 
                        !!}  
                    </div> 
                </div>
                <div class="form-group col-md-12 ">
                    <div class="col-md-2">
                    {!! Form::label( 'info', 'Candidate Platform:' ) !!}
                    </div>
                    <div class="col-md-10">
                        {!! Form:: textarea
                            ('info','' , array(
                            'id' => 'info',
                            'placeholder' => "This will be use for the campaign page",
                            'name' => 'txtinfo',
                            'class' => 'form-control',
                            'required' => true,)) 
                        !!}
                    </div>  
                </div>
                <div class="form-group col-md-12 ">
                    <input type="submit" class="btn btn-primary" name="btnSubmit" value="Submit">
                </div>
                {!! Form::close() !!}
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
                    .width(180);
                    
                };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<script>
    $(document).on("click", ".delParty", function(){
        var x = confirm("Are you sure you want to delete this record?");
        if (x){
            var id = $(this).parent().parent().find('.id').text();
            document.getElementById('delparty').value = id;
            document.getElementById('delform').submit();
        }
        else
            return false;
    });
    $(document).on("click", ".editParty", function(){
            var id = $(this).parent().parent().find('.id').text();
            document.getElementById('editparty').value = id;
            document.getElementById('editform').submit();
        
    });
</script>
<script src="{{ URL::asset('assets/plugins/select2/select2.full.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/colorpicker/bootstrap-colorpicker.min.js') }}"></script>
<script>
    $(".select2").select2();
    //Colorpicker
    $(".my-colorpicker1").colorpicker();
    //color picker with addon
    $(".my-colorpicker2").colorpicker();

</script>

@stop