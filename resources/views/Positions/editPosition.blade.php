@extends('master')
@section('title')
    {{"Edit Position"}}
@stop   
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/datatables/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/datatables/datatables-responsive/css/dataTables.responsive.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/colorpicker/bootstrap-colorpicker.min.css') }}">
    <style>
         .required:after{
        content: "*";
        color:red
        }
    </style>
@stop
@section('content')
<!-- START CONTENT -->
    @section('title-page')
        {{"Edit Position"}}
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
        <div class="callout callout-info">
            <p>Note: Position reference enable you to control voters.</p> <!-- edit this note -->
        </div>
    </div>
    <div class="col-md-5">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Position Reference</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <form action="{{ URL::to('/position/update') }}" method="POST" role="form" >
                    <?php echo "$editForm" ?>
            </div>
            <div class="box-footer">
                Footer
            </div>
        </div>
    </div> 
    <div class="col-md-7">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Position Form</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="form-group col-md-12 ">
                    {!! Form::label( 'PositionId', 'Position Id ',array(
                        'class' => 'required') ) !!}
                    {!! Form::text
                        ('PositionId', $strPositionId, array(
                        'readonly',
                        'id' => 'PositionId',
                        'name' => 'txtPositionId',
                        'class' => 'form-control',
                        'required' => true,)) 
                    !!}  
                </div>
                <div class="form-group col-md-12 ">
                    {!! Form::label( 'PositionName', 'Position Name ',array(
                        'class' => 'required') ) !!}
                    {!! Form::text
                        ('PositionName', $strPosName, array(
                        'id' => 'PositionName',
                        'placeholder' => "Type the position name here",
                        'name' => 'txtPositionName',
                        'class' => 'form-control',
                        'required' => true,)) 
                    !!}  
                </div>
                <div class="form-group col-md-12 ">
                    {!! Form::label( 'VoteLimit', 'Vote Limit ',array(
                        'class' => 'required') ) !!}
                    {!! Form::number
                        ('VoteLimit', $intVoteLimit, array(
                        'id' => 'VoteLimit',
                        'placeholder' => "Type the vote limit here",
                        'name' => 'txtVoteLimit',
                        'class' => 'form-control',)) 
                    !!}  
                </div>
                <div class="form-group col-md-12 ">
                    {!! Form::label( 'PosColor', 'Position Color:' ) !!}
                    <div class="input-group my-colorpicker2">
                        {!! Form::text
                            ('PosColor', $strPosColor, array(
                            'id' => 'PosColor',
                            'placeholder' => "Pick color of this position.",
                            'name' => 'txtPositionColor',
                            'class' => 'form-control',)) 
                        !!}  
                        <div class="input-group-addon">
                            <i></i>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <div class="checkbox col-md-12">
                        <input type="checkbox" name="delReference" class="" value="1">
                         Do you want to reset all position reference?
                    </div>
                </div>  
                <div class="form-group col-md-12 ">
                    <input type="submit" class="btn btn-primary" name="btnSubmit" value="Update">
                </div> 
                </form>
            </div>
            
            
        </div>
    </div> 
    <!-- Delete Form -->
    <div class="hide">
        <form method="POST" action="{{ URL::to('/member/delete') }}" id="delform">
            <input type="hidden" name="id" id="delmem">
        </form>
    </div>
@stop 
@section('script')
<script src="{{ URL::asset('assets/datatables/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/datatables/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js') }}"></script>
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip(); 
    });
    $(document).on("click", ".delMember", function(){
        var x = confirm("Are you sure you want to delete this record?");
        if (x){
            var id = $(this).parent().parent().find('.id').text();
            document.getElementById('delmem').value = id;
            document.getElementById('delform').submit();
        }
        else
            return false;
    });
</script>
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
                responsive: true
        });
    });
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