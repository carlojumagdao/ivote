@extends('master')
@section('title')
    {{"View Votes"}}
@stop   
@section('style')
<link href="{{ URL::asset('assets/css/style.css') }}" type="text/css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/datatables/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/datatables/datatables-responsive/css/dataTables.responsive.css') }}">
@stop
@section('content')
<!-- START CONTENT -->
    @section('title-page')
        {{"View Votes"}}
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
                <h3 class="box-title">Voting Details</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body dataTable_wrapper">
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>Candidate ID</th>
                            <th>Candidate Name</th>
                            <th>Position</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($votes as $value)
                        <tr>
                            
                            <td class="code">{{$value->strCandId}}</td>
                            <td class="id">{{$value->strMemLname}}, {{$value->strMemFname}} {{$value->strMemMname}}</td>
                            <td class="name">{{$value->strPosName}}</td>
                            
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Candidate ID</th>
                            <th>Candidate Name</th>
                            <th>Position</th>
                        </tr>
                    </tfoot>
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
                <h3 class="box-title">Voting Information</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class = "row">
                    <div class="col-md-6">
                        <p>Vote Reference:</p>
                    </div>
                    <div class="col-md-6">
                        <p style="color:#36A2EB;font-size:20px;font-weight:bold;">{{$voted[0]->strVHCode}}</p>
                    </div>
                </div>
                <div class = "row">
                    <div class="col-md-6">
                        <p>Date of Vote:</p>
                    </div>
                    <div class="col-md-6">
                        <?php
                            $dateofvote = $voted[0]->datVHVoted;
                            $convertedDOV = date('M j, Y h:i A',strtotime($dateofvote));
                        ?>
                        <p>{{$convertedDOV}}</p>
                    </div>
                    <div class="col-md-6">
                        <p>Device Used: </p>
                    </div>
                    <div class="col-md-6">
                        <p>
                        @if($voted[0]->intDevice == 1)
                            {{"Desktop"}}
                        @elseif($voted[0]->intDevice == 2)
                            {{"Tablet"}}
                        @elseif($voted[0]->intDevice == 3)
                            {{"Mobile"}}
                        @endif
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p>Browser: </p>
                    </div>
                    <div class="col-md-6">
                        <p>{{$voted[0]->strBrowser}}</p>
                    </div>
                    <div class="col-md-6">
                        <p>Operating System: </p>
                    </div>
                    <div class="col-md-6">
                        <p>{{$voted[0]->strOpSys}}</p>
                    </div>
                    <div class="col-md-6">
                        <p>Device Model: </p>
                    </div>
                    <div class="col-md-6">
                        <p>{{$voted[0]->strDevModel}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="box box-default collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">Member Information</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-plus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class = "row">
                    <div class="col-md-6">
                        <h4>Member ID:</h4>
                    </div>
                    <div class="col-md-6">
                        <h4>{{$voted[0]->strMemberId}}</h4>
                    </div>
                </div>
                <div class = "row">
                    <div class="col-md-6">
                        <h5>Member Name:</h5>
                    </div>
                    <div class="col-md-6">
                        <h5>{{$voted[0]->strMemLname}}, {{$voted[0]->strMemFname}} {{$voted[0]->strMemMname}} </h5>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    

@stop 

@section('script')
<script src="{{ URL::asset('assets/datatables/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/datatables/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
                responsive: false
        });
    });
</script>
@stop