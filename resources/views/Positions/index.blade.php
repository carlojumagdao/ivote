@extends('master')
@section('title')
    {{"Positions"}}
@stop   
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/datatables/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/datatables/datatables-responsive/css/dataTables.responsive.css') }}">
    <style>
        table.table.table-striped tr.highlight td{
          background-color: #ffe4e4;  
        }
    </style>
@stop
@section('content')
<!-- START CONTENT -->
    @section('title-page')
        {{"Positions"}}
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
                <h3 class="box-title">List of all positions</h3>
                <div class="box-tools pull-right">
                    <a href="{{ URL::to('/position/create') }}" class="btn btn-success btn-xs">
                    <i class="glyphicon glyphicon-plus"></i> Add New</a>
                </div>
            </div>
            <div class="pull-right">
              <label class="checkbox-inline">
                <input type="checkbox" id="show_deleted">
                Show Deleted Position
              </label>
              <label class="checkbox-inline">
                <input type="checkbox" id="show_meta">
                Show Metadata
              </label>
            </div>
            <div class="box-body dataTable_wrapper">
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>Position Id</th>
                            <th>Position Name</th>
                            <th>Vote Limit</th>
                            <th>Date Created</th>
                            <th>Date Updated</th>
                            <th>Date Deleted</th>
                            <th style="display:none">Status</th>
                            @if($electionStatus == 0)<th>Action</th>@endif
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($Positions as $value)

                        @if($value->blPosDelete == 1)
                            <tr class="highlight">
                        @else
                            <tr>
                        @endif
                                <td class="id">{{$value->strPositionId}}</td>
                                <td class="name">{{$value->strPosName}}</td>
                                <td class="email">{{$value->intPosVoteLimit}}</td>
                                    <?php
                                        $datecreated =  $value->created_at;
                                        $converteddatecreated = date('M j, Y h:i A',strtotime($datecreated));
                                        $dateupdated = $value->updated_at;
                                        $converteddateupdated = date('M j, Y h:i A',strtotime($dateupdated));   
                                        $datedeleted = $value->deleted_at;
                                        if($value->blPosDelete==1)
                                        {
                                            $converteddatedeleted = date('M j, Y h:i A',strtotime($datedeleted));
                                        }
                                        else
                                            $converteddatedeleted = "null";
                                    ?>
                                <td class="created">{{$converteddatecreated}}</td>
                                <td class="updated">{{$converteddateupdated}}</td>
                                <td class="deleted">{{$converteddatedeleted}}</td>
                                <td class="status" style="display:none">{{$value->blPosDelete}}</td> 
                                @if($electionStatus == 0)
                                <td>
                                    @if($value->blPosDelete == 0)
                                    <a href="position/edit/{{$value->strPositionId}}" class="btn btn-warning btn-sm edit" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>
                                    <button class="btn btn-danger btn-sm delPosition" data-toggle="tooltip" title="Delete"><i class="glyphicon glyphicon-trash"></i></button>
                                    @else
                                    <button class="btn btn-info btn-sm revPosition" data-toggle="tooltip" title="Restore"><i class="glyphicon glyphicon-refresh"></i></button>
                                    @endif
                                </td>
                                @endif
                            </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Position Id</th>
                            <th>Position Name</th>
                            <th>Vote Limit</th>
                            <th>Date Created</th>
                            <th>Date Updated</th>
                            <th>Date Deleted</th>
                            <th style="display:none">Status</th>
                            @if($electionStatus == 0)<th>Action</th>@endif
                        </tr>
                    </tfoot>
                </table>
            </div>
            
        </div>
    </div> 
    <!-- Delete Form -->
    <div class="hide">
        <form method="POST" action="{{ URL::to('/position/delete') }}" id="delform">
            <input type="hidden" name="id" id="delpos">
        </form>
    </div>

    <div class="hide">
        <form method="POST" action="{{ URL::to('/position/revert') }}" id="revform">
            <input type="hidden" name="id" id="revpos">
    </div>
@stop 
@section('script')
<script src="{{ URL::asset('assets/datatables/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/datatables/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js') }}"></script>
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip(); 
    });
    $(document).on("click", ".delPosition", function(){
        var x = confirm("Are you sure you want to delete this record?");
        if (x){
            var id = $(this).parent().parent().find('.id').text();
            document.getElementById('delpos').value = id;
            document.getElementById('delform').submit();
        }
        else
            return false;
    });
    $(document).on("click", ".revPosition", function(){
        var x = confirm("Are you sure you want to revert this record?");
        if (x){
            var id = $(this).parent().parent().find('.id').text();
            document.getElementById('revpos').value = id;
            document.getElementById('revform').submit();
        }
        else
            return false;
    });
</script>
<script>
    $(document).ready(function () {
      responsive: true
      $('.status:contains(1)').parent().toggle();
      var table = $('#dataTables-example').DataTable({
        columnDefs: [
          {
            targets: [3, 4, 5],
            visible: false,
            searchable: false
          },
          {
            targets: [4],
            visible: false
          }
        ]
      });
      $('#show_meta').on('change', function () {
        if ($('#show_meta:checked').length > 0) {
          table.columns([0, 1, 2, 3, 4]).visible(true);
        } else {
          table.columns([3, 4, 5]).visible(false);
        }
      });

      $('#show_deleted').on('change', function () {
        if ($('#show_deleted:checked').length > 0) {
            $('.status:contains(1)').parent().toggle();
          table.columns([0, 1, 2, 5, 6, 7]).visible(true);
        } else {
          $('.status:contains(1)').parent().toggle();
          table.columns([3, 4, 5]).visible(false);
        }
        //$('.status:contains(0)').parent().toggle();
        table.draw();
      });
    });
</script>
@stop