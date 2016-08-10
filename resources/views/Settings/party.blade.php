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
        .required:after{
        content: "*";
        color:red
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
                <h3 class="box-title">List of all Parties</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#add">
                    <i class="glyphicon glyphicon-plus"></i> Add New</button>
                </div>
            </div>
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                <tr>
                    <th>#</th>
                    <th>Party Name</th>
                    <th>Party Leader</th>
                    <th>Party Color</th>
                    <th>Action</th>
                </tr>
                @foreach($Party as $value)
                    <tr>
                        <td class="hide id">{{$value->intPartyId}}</td>
                        <td>{{++$intCounter}}</td>
                        <td class="name">{{$value->strPartyName}}</td>
                        <td class="leader">{{$value->strPartyLeader}}</td>
                        <td class="color">{{$value->strPartyColor}}</td>
                        <!-- if else to make the independent party not editable/deletable -->
                        @if($value->intPartyId == 1)
                            <td><button class="btn bg-purple btn-xs">Uneditable</button></td>    
                        @else
                            <td>
                                <button class="btn btn-warning btn-sm editParty" data-toggle="modal" title="Edit"><i class="glyphicon glyphicon-edit"></i></button>
                                <button class="btn btn-danger btn-sm delParty" data-toggle="tooltip" title="Delete"><i class="glyphicon glyphicon-trash"></i></button>
                            </td>
                        @endif
                    </tr>
                @endforeach
                </table>
            </div>
            
        </div>
    </div> 
    <!-- Modal | Add -->
    <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add Party</h4>
                </div>
            <div class="modal-body">
                {!! Form::open( array(
                    'method' => 'post',
                    'id' => 'form-add-setting',
                    'action' => 'partyController@add',
                    'class' => 'col s12',
                    'files' => true
                ) ) !!}
                <div class="form-group col-md-12 ">
                    {!! Form::label( 'PartyName', 'Party Name ',array(
                        'class' => 'required') ) !!}
                    {!! Form::text
                        ('PartyName', '', array(
                        'id' => 'PartyName',
                        'placeholder' => "Type the party name here",
                        'name' => 'txtPartyName',
                        'class' => 'form-control',
                        'required' => true,)) 
                    !!}  
                </div>
                <div class="form-group col-md-12 ">
                    {!! Form::label( 'PartyLeader', 'Party Leader ',array(
                        'class' => 'required') ) !!}
                    {!! Form::text
                        ('PartyLeader', '', array(
                        'id' => 'PartyLeader',
                        'placeholder' => "Type the party leader here",
                        'name' => 'txtPartyLeader',
                        'class' => 'form-control',)) 
                    !!}  
                </div>
                <div class="form-group col-md-12 ">
                    {!! Form::label( 'PartyColor', 'Party Color:' ) !!}
                    <div class="input-group my-colorpicker2">
                        {!! Form::text
                            ('PartyColor', '', array(
                            'id' => 'PartyColor',
                            'placeholder' => "Pick color of this party.",
                            'name' => 'txtPartyColor',
                            'class' => 'form-control',)) 
                        !!}  
                        <div class="input-group-addon">
                            <i></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary" name="btnSubmit" value="Submit">
                {!! Form::close() !!}
            </div>
            </div>
        </div>
    </div>
    <!-- Modal | Add -->

    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit Party</h4>
                </div>
            <div class="modal-body">
                -
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary" name="btnUpdate" value="Save changes">
                {!! Form::close() !!}
            </div>
            </div>
        </div>
    </div>
    <!-- Modal | Edit -->
    <!-- Delete Form -->
    <div class="hide">
        <form method="POST" action="{{ URL::to('/settings/party/delete') }}" id="delform">
            <input type="hidden" name="id" id="delparty">
        </form>
    </div>
    <!-- Delete Form -->
    <!-- Edit Form -->
    <div class="hide">
        <form method="POST" action="{{ URL::to('/settings/party/') }}" id="editform">
            <input type="hidden" name="id" id="editparty">
        </form>
    </div>
    <!-- Edit Form -->
@stop 
@section('script')
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip(); 
    });
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
    //Colorpicker
    $(".my-colorpicker1").colorpicker();
    //color picker with addon
    $(".my-colorpicker2").colorpicker();

</script>

@stop