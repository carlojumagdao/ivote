@extends('master')
@section('title')
    {{"Security Question Settings"}}
@stop   
@section('style')
    <!-- style -->
@stop
@section('content')
<!-- START CONTENT -->
    @section('title-page')
        {{"Security Question Settings"}}
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
                <h3 class="box-title">List of all Security Questions</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                <tr>
                    <th>#</th>
                    <th>Question</th>
                    <th>Action</th>
                </tr>
                @foreach($secQues as $value)
                    <tr>
                        <td class="hide id">{{$value->intSecQuesId}}</td>
                        <td>{{++$intCounter}}</td>
                        <td class="question">{{$value->strSecQuestion}}</td>
                        <td>
                            <button class="btn btn-warning btn-sm editQues" data-toggle="modal" title="Edit" data-target="#edit"><i class="glyphicon glyphicon-edit"></i></button>
                            <button class="btn btn-danger btn-sm delQues" data-toggle="tooltip" title="Delete"><i class="glyphicon glyphicon-trash"></i></button>
                        </td>
                    </tr>
                @endforeach
                </table>
            </div>
            <div class="box-footer">
                Footer
            </div>
        </div>
    </div> 
    <div class="col-md-4">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Add Security Questions</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                {!! Form::open( array(
                    'method' => 'post',
                    'id' => 'form-add-setting',
                    'action' => 'securityController@add',
                    'class' => 'col s12',
                ) ) !!}
                <div class="form-group col-md-12 ">
                    {!! Form::label( 'SecurityQuestion', 'Security Question:' ) !!}
                    {!! Form::text
                        ('SecurityQuestion', '', array(
                        'id' => 'SecurityQuestion',
                        'placeholder' => "Type your question here",
                        'name' => 'txtSecurityQuestion',
                        'class' => 'form-control',
                        'required' => true,)) 
                    !!}  
                </div>
                <div class="form-group col-md-6">
                    <input type="submit" name="btnGenSetSubmit" value="Save" class="btn btn-primary btn-block">
                </div>
                {!! Form::close() !!}
            </div>
            <div class="box-footer">
                Footer
            </div>
        </div>
    </div> 
    <!-- Modal -->
    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit Security Question</h4>
                </div>
            <div class="modal-body">
                {!! Form::open( array(
                    'method' => 'post',
                    'id' => 'form-add-setting',
                    'action' => 'securityController@update',
                    'class' => 'col s12',
                ) ) !!}
                <div class="form-group col-md-12 ">
                    {!! Form::label( 'sq', 'Security Question:' ) !!}
                    <input type="text" name="txtSecurityQuestion" id="sq" class="form-control">
                    {!! Form::hidden
                        ('sqid', '', array(
                        'id' => 'sqid',
                        'name' => 'txtSecurityQuestionId',
                        'required' => true,)) 
                    !!}  
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary" name="btnUpdate" value="Save changes">
                {!! Form::close() !!}
            </div>
            </div>
        </div>
    </div>
    <!-- Delete Form -->
    <div class="hide">
        <form method="POST" action="{{ URL::to('/settings/security/delete') }}" id="delform">
            <input type="hidden" name="id" id="delsq">
        </form>
    </div>
@stop 

@section('script')
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip(); 
    });
</script>
<script>
    $(document).on("click",".editQues", function(){
        var id = $(this).parent().parent().find('.id').text(); 
        var question = $(this).parent().parent().find('.question').text();
        document.getElementById('sqid').value = id;
        document.getElementById('sq').value = question;
    });

    $(document).on("click", ".delQues", function(){
        var x = confirm("Are you sure you want to delete this record?");
        if (x){
            var id = $(this).parent().parent().find('.id').text();
            document.getElementById('delsq').value = id;
            document.getElementById('delform').submit();
        }
        else
            return false;
    });
</script>
@stop