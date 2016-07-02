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
                <h3 class="box-title">Party Affiliation</h3>
            </div>
            <div class="box-body table-responsive no-padding">
                @foreach ($party as $part)
                <form action="{{ URL::to('/settings/party/update') }}" method="post" enctype="multipart/form-data" class="col s12">
                    <input type="hidden" id="ptid" name="txtPartyId" value="{{$part->intPartyId}}" required >
                    <center>
                        <div class="col s12">
                            <div class="card-panel2 tooltipped" data-position="top" data-delay="50" data-tooltip="logo picture">
                                <img id="cand-pic" src="../../assets/images/{{$part->txtPartyPic}}" width="180px" style="background-size: contain" /> 
                            </div>
                        </div>
                    </center>
                    <div class="form-group col-md-12 ">
                        <span class="btn btn-default btn-file">
                            <label for="file">File Path:</label>
                            <input type="file" id="file" name="image" class="form-control btn btn-success btn-xs" style="display:none" onchange='$("#upload-file-info").html($(this).val());readURL(this)' required>
                        </span>
                        <span class='label label-info' id="upload-file-info">
                        </span>
                    </div>
                    <div class="form-group col-md-12 ">
                        <label for="PartyName">Party Name:</label>
                        <input type="text" placeholder="Type Party Name Here" id = 'PartyName' name = 'txtPartyName'
                        class='form-control' value="{{$part->strPartyName}}" required>
                    </div>
                    <div class="form-group col-md-12 ">
                        <label for="PartyLeader">Party Leader:</label>
                        <input type="text" placeholder="Type Party Leader Here" id = 'PartyLeader' name = 'txtPartyLeader'
                        class='form-control' value="{{$part->strPartyLeader}}" required>
                    </div>
                    <div class="form-group col-md-12 ">
                        
                        <label for="PartyColor">Party Color:</label>
                        <div class="input-group my-colorpicker2">
                            <input type="text" placeholder="Type Party Color Here" id = 'PartyLeader' name = 'txtPartyColor'
                                   class='form-control' value="{{$part->strPartyColor}}">
                            <div class="input-group-addon">
                                <i></i>
                            </div>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-primary right" name="btnSubmit" value="Submit">
                </form>
                @endforeach
            </div>
            <div class="box-footer">
                footer
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