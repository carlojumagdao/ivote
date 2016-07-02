@extends('master')
@section('title')
    {{"Party Settings"}}
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
        {{"Party Affiliation Settings"}}
    @stop  
    <!--start container-->
    <div class="col-md-12">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i> Something went wrong!</h4>
                {!! implode($part->strPartyName, $errors->all(
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
                <h3 class="box-title">Party Affiliation</h3>
            </div>
            <div class="box-body table-responsive no-padding">
                @foreach ($party as $part)
                 {!! Form::open( array(
                    'method' => 'post',
                    'id' => 'form-edit-setting',
                    'action' => 'partyController@update',
                    'enctype' => 'multipart/form-data',
                    'class' => 'col s12',
                    'files' => true
                ) ) !!}
                {!! Form::hidden
                    ('PartyId', $part->intPartyId, array(
                    'id' => 'ptid',
                    'name' => 'txtPartyId',
                    'required' => true,)) 
                !!} 
                <center>
                    <div class="col s12">
                        <div class="card-panel2 tooltipped" data-position="top" data-delay="50" data-tooltip="logo picture">
                            <img id="cand-pic" src="../assets/images/{{$part->txtPartyPic}}" width="180px" style="background-size: contain" /> 
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
                <div class="form-group col-md-12 ">
                    {!! Form::label( 'PartyName', 'Party Name:' ) !!}
                    {!! Form::text
                        ('PartyName', $part->strPartyName , array(
                        'id' => 'ptname',
                        'placeholder' => "Type the party name here",
                        'name' => 'txtPartyName',
                        'class' => 'form-control',
                        'required' => true,)) 
                    !!}  
                </div>
                <div class="form-group col-md-12 ">
                    {!! Form::label( 'PartyLeader', 'Party Leader:' ) !!}
                    {!! Form::text
                        ('PartyLeader', $part->strPartyLeader , array(
                        'id' => 'ptleader',
                        'placeholder' => "Type the party leader here",
                        'name' => 'txtPartyLeader',
                        'class' => 'form-control',)) 
                    !!}  
                </div>
                <div class="form-group col-md-12 ">
                    {!! Form::label( 'PartyColor', 'Party Color:' ) !!}
                    <div class="input-group my-colorpicker2">
                        {!! Form::text
                            ('PartyColor', $part->strPartyColor, array(
                            'id' => 'ptcolor',
                            'placeholder' => "Pick color of this party.",
                            'name' => 'txtPartyColor',
                            'class' => 'form-control',)) 
                        !!}  
                        <div class="input-group-addon">
                            <i></i>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="box-footer">
                <input type="submit" class="btn btn-primary" name="btnSubmit" value="Submit">
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