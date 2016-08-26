@extends('master')
@section('title')
    {{"Member"}}
@stop   
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/datatables/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/datatables/datatables-responsive/css/dataTables.responsive.css') }}">

    <style>

.red-tooltip + .tooltip > .tooltip-inner {font-size:20px;background-color: #f00;}

        /* Absolute Center Spinner */
.loading {
  position: fixed;
  z-index: 999;
  height: 2em;
  width: 2em;
  overflow: show;
  margin: auto;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
}

/* Transparent Overlay */
.loading:before {
  content: '';
  display: block;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0,0,0,0.3);
}

/* :not(:required) hides these rules from IE9 and below */
.loading:not(:required) {
  /* hide "loading..." text */
  font: 0/0 a;
  color: transparent;
  text-shadow: none;
  background-color: transparent;
  border: 0;
}

.loading:not(:required):after {
  content: '';
  display: block;
  font-size: 10px;
  width: 1em;
  height: 1em;
  margin-top: -0.5em;
  -webkit-animation: spinner 1500ms infinite linear;
  -moz-animation: spinner 1500ms infinite linear;
  -ms-animation: spinner 1500ms infinite linear;
  -o-animation: spinner 1500ms infinite linear;
  animation: spinner 1500ms infinite linear;
  border-radius: 0.5em;
  -webkit-box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.5) -1.5em 0 0 0, rgba(0, 0, 0, 0.5) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
  box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) -1.5em 0 0 0, rgba(0, 0, 0, 0.75) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
}

table.table.table-striped tr.highlight td{
  background-color: #ff3d3d;  
}

/* Animation */

@-webkit-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-moz-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-o-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
    </style>
@stop
@section('content')
<!-- START CONTENT -->
    @section('title-page')
        {{"Members"}}
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
        <div class="alert alert-success alert-dismissible emailSent hide">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Email Sent!</h4>
        </div>
    </div>
    <div class="col-md-12">
        <div class="alert alert-danger alert-dismissible emailFailed hide">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-ban"></i> Sending Failed!</h4>
        </div>
    </div>
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">List of all members</h3>
                <div class="box-tools pull-right">
                    <a href="{{ URL::to('/member/create') }}" class="btn btn-primary btn-xs" data-toggle="tooltip" title="Add New Member">
                    <i class="glyphicon glyphicon-plus"></i> Add New</a>
                    <button class="btn btn-xs btn-info sendall" data-toggle="tooltip" title="Send All Passcodes"><i class="glyphicon glyphicon-send"></i> Send All Passcode</button>
                </div>
            </div>
            
            <div class="box-body dataTable_wrapper">
                <div class="" style="margin-bottom:1%;">
                    <label class="checkbox-inline">
                    <input type="checkbox" id="show_deleted">
                    Show Deleted Members
                    </label>
                    <label class="checkbox-inline">
                    <input type="checkbox" id="show_meta">
                    Show Metadata
                    </label>
                </div>
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>Member Id</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Sent Passcode?</th>
                            <th>Date Created</th>
                            <th>Date Updated</th>
                            <th>Date Deleted</th>
                            <th style="display:none">Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($Members as $value)
                        @if($value->blMemDelete == 1)
                          <tr class="highlight">
                        @else
                          <tr>
                        @endif
                            <p class="hide passcode">{{$value->strMemPasscode}}</p>
                            <td class="id">{{$value->strMemberId}}</td>
                            <td class="name">{{$value->strMemFname.' '.$value->strMemLname}}</td>
                            <td class="email">{{$value->strMemEmail}}</td>
                            @if($value->blMemCodeSendStat == 1)
                                <td class="passcode">Yes  <button class="btn btn-default btn-circle btn-sm edit red-tooltip" data-placement="right" data-toggle="tooltip" title="{{$value->strMemPasscode}}" data-clipboard-text="{{$value->strMemPasscode}}"><i class="glyphicon glyphicon-qrcode"></i></button></td>  
                            @else
                                <td class="passcode">No  <button class="btn btn-default btn-circle btn-sm edit red-tooltip" data-placement="right" data-toggle="tooltip" title="{{$value->strMemPasscode}}" data-clipboard-text="{{$value->strMemPasscode}}"><i class="glyphicon glyphicon-qrcode"></i></button></td>  
                            @endif
                            
                            <?php
                                $datecreated =  $value->created_at;
                                $converteddatecreated = date('M j, Y h:i A',strtotime($datecreated));
                                $dateupdated = $value->updated_at;
                                $converteddateupdated = date('M j, Y h:i A',strtotime($dateupdated));   
                                $datedeleted = $value->deleted_at;
                                if ($value->blMemDelete ==1)
                                  {
                                    $converteddatedeleted = date('M j, Y h:i A',strtotime($datedeleted));
                                  }
                                else 
                                $converteddatedeleted = "null";   
                            ?>
                            
                            <td class="created">{{$converteddatecreated}}</td>
                            <td class="updated">{{$converteddateupdated}}</td>
                            <td class="deleted">{{$converteddatedeleted}}</td>
                            <td class="status" style="display:none">{{$value->blMemDelete}}</td>
                            <td>
                                @if($value->blMemDelete == 0)
                                <a href="member/view/{{$value->strMemberId}}" class="btn btn-primary btn-sm view" data-toggle="tooltip" title="View"><i class="fa fa-eye"></i></a>
                                <a href="member/edit/{{$value->strMemberId}}" class="btn btn-warning btn-sm edit" data-toggle="tooltip" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>
                                <a class="btn btn-info btn-sm send" data-toggle="tooltip" title="Send Passcode"><i class="glyphicon glyphicon-send"></i></a>
                                <button class="btn btn-danger btn-sm delMember" data-toggle="tooltip" title="Delete"><i class="glyphicon glyphicon-trash"></i></button>
                                @else
                                <button class="btn btn-info btn-sm revMember" data-toggle="tooltip" title="Restore"><i class="glyphicon glyphicon-refresh"></i></button>
                                @endif
                            </td>
                            <!-- <td>
                                <a href="member/view/{{$value->strMemberId}}" class="btn btn-primary btn-sm revert" data-toggle="tooltip" title="View"><i class="glyphicon glyphicon-refresh"></i></a>
                            </td> -->
                          </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Member Id</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Sent Passcode?</th>
                            <th>Date Created</th>
                            <th>Date Updated</th>
                            <th>Date Deleted</th>
                            <th style="display:none">Status</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="box-footer">
                
            </div>
            
        </div>
        
    </div>
<!-- <diva class="fixed-action-btn" style="bottom: 105px; right: 24px;" hidden="hidden">
    <a class="btn-floating btn-large blue darken-2 small" hidden="hidden">
        <i class="mdi-navigation-expand-less "></i>
    </a>
</diva>
<?php
// require'scrolltop.php';
?> -->
    <!-- Delete Form -->
    <div class="hide">
        <form method="POST" action="{{ URL::to('/member/delete') }}" id="delform">
            <input type="hidden" name="id" id="delmem">
        </form>
    </div>

    <div class="hide">
        <form method="POST" action="{{ URL::to('/member/revert') }}" id="revform">
            <input type="hidden" name="id" id="revmem">
        </form>
    </div>

    <div class="loading hide">Loading&#8230;</div>
@stop 
@section('script')
<script src="{{ URL::asset('assets/datatables/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/datatables/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('assets/clipboard/clipboard.min.js') }}"></script>
 <script>
    var clipboard = new Clipboard('.btn');
    clipboard.on('success', function(e) {
        console.log(e);
    });
    clipboard.on('error', function(e) {
        console.log(e);
    });
</script>
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
    $(document).on("click", ".revMember", function(){
        var x = confirm("Are you sure you want to retrieve this record?");
        if (x){
            var id = $(this).parent().parent().find('.id').text();
            document.getElementById('revmem').value = id;
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
            targets: [4, 5, 6],
            visible: false,
            searchable: false
          },
          {
            targets: [5],
            visible: false
          }
        ]
      });
      $('#show_meta').on('change', function () {
        if ($('#show_meta:checked').length > 0) {
          table.columns([0, 1, 2, 3, 4, 5, 7]).visible(true);
        } else {
          table.columns([4, 5]).visible(false);
        }
      });

      $('#show_deleted').on('change', function () {
        if ($('#show_deleted:checked').length > 0) {
            $('.status:contains(1)').parent().toggle();
          table.columns([0, 1, 2, 6]).visible(true);
        } else {
          $('.status:contains(1)').parent().toggle();
          table.columns([4, 5, 6]).visible(false);
        }
        //$('.status:contains(0)').parent().toggle();
        table.draw();
      });
    });
</script>
<script>
    $(".send").click(function(){
        var id = $(this).parent().parent().find('.id').text();  
        $( ".loading" ).removeClass( "hide" );
       $.ajax({
            url: "{{ URL::to('member/email') }}",
            type:"POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                      return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: { id:id },
            success:function(data){
                $( ".loading" ).addClass( "hide" );
                $( ".emailSent" ).removeClass( "hide" ); 
                location.reload();
            },error:function(){ 
                $( ".loading" ).addClass( "hide" );
                $( ".emailFailed" ).removeClass( "hide" ); 
            }
        }); //end of ajax 
    });


</script>

<script>
    $(".sendall").click(function(){
        $('.id').each(function(){
            $( ".loading" ).removeClass( "hide" );
            $.ajax({
            url: "{{ URL::to('member/email') }}",
            type:"POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                      return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: { id: $(this).text() },
            success:function(data){
                $( ".loading" ).addClass( "hide" );
                $( ".emailSent" ).removeClass( "hide" ); 
                location.reload();
            },error:function(){ 
                $( ".loading" ).addClass( "hide" );
                $( ".emailFailed" ).removeClass( "hide" );  
                location.reload();
            }
            
            }); //end of ajax 
        });
    });


</script>


<!-- <script>
    var previousScroll = 0;

    $(window).scroll(function(){
       var currentScroll = $(this).scrollTop();
       if (currentScroll > previousScroll){
           $('diva').show();
       } else  {
          $('diva').hide();
       }
       previousScroll = currentScroll;
    });
</script>


<script>
        $("a").click(function () {
   //1 second of animation time
   //html works for FFX but not Chrome
   //body works for Chrome but not FFX
   //This strange selector seems to work universally
   $("html, body").animate({scrollTop: 0}, 400);
});
</script> -->


@stop
