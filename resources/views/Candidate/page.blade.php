<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="csrf_token" content="{{ csrf_token() }}" />
  <title>@yield('title', 'iVote++ | Home')</title>
  @yield('style')
  <link rel="stylesheet" href="{{ URL::asset('assets/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('assets/bootstrap/css/font-awesome.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('assets/bootstrap/css/ionicons.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/iCheck/all.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('assets/dist/css/AdminLTE.min.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('assets/dist/css/skins/_all-skins.min.css') }}">
</head>
<style>
    body{
      background-image: url("{{ URL::asset('../assets/images/7.jpg') }}");
      background-repeat: no-repeat;
      background-size: cover;
      background-attachment: fixed;
      }
      /*footer {
      width:100%;
      height:100px;
      position:absolute;
      bottom:0;
      left:0;
    }*/
      
    
</style>
<body >
    <div style="padding: 20px">
    <h3></h3>
    <div class="row">
        <div class="col-md-2">
            <div class="card-panel2 tooltipped" data-position="top" data-delay="50" data-tooltip="logo picture">
                <img id="cand-pic" src="../assets/images/ivote7.jpg" width="200px" height="174px" style="background-size: contain;opacity:2px" /> 
            </div>
        </div>
        <div class="col-md-9 panel" style="border-left: 4px solid CornflowerBlue ; background-color:rgba(248, 248, 248, 0.71);width:1048px">
            <div class="panel-body">
                @foreach($election as $setting)
                <h2 style="font-family:helvetica;text-align:left;text-transform: capitalize;letter-spacing:1px">{{$setting->strHeader}}</h2>
                
                <h4 style="font-family:segoe ui;text-align:left;margin-top:10px;">{{$setting->strSetElecName}}</h5>
                <h5 style="font-family:segoe ui;text-align:left;letter-spacing:1px;text-transform: capitalize;">{{$setting->strSetElecDesc}}</h5>
                @endforeach
                <h5 style="style=font-family:segoe ui;text-align:left;letter-spacing:1px;color:Tomato ">"Election Not Open Yet"</h5>
                
            </div>
        </div>
    </div>
    
    <div class="box" style="background-color:rgba(248, 248, 248, 0.71);" >
        <div class="box-header"  style=" ">
            <p class="box-title" style="font-family:helvetica;letter-spacing:2px;font-size:28px;margin-left: 16px;color: DodgerBlue    ">Candidates</p>
        </div>
        <div class="box-body" style="padding-left: 40px;padding-right:40px">
        @foreach($partylist as $party)
            <div class="row panel" style="border-left: 4px solid {{$party->strPartyColor}}; background-color:rgba(0, 0, 0, 0.20)">
                 <div class="col-md-12">
                 <div class="col-md-12" style="font-family:segoe ui;text-transform: capitalize;"><h5 style="letter-spacing:1px">Party Affiliation</h5><h3 style="letter-spacing:1px;font-family: helvetica;color: white ;text-shadow: 1px 1px 5px rgba(5, 5, 5, 0.62);">{{$party->strPartyName}}</h3></div>
                 
                    
            @foreach($positions as $position)
                   
                
                @foreach($candidates as $candidate)
                     
                    @if($candidate->strCandPosId == $position->strCandPosId )
                    @if($candidate->intCandParId == $party->intCandParId)
                     <div class="col-md-2">
                         <div class="thumbnail">
                             <div class="panel tooltipped" data-position="top" data-delay="50" data-tooltip="logo picture">
                                 <img id="cand-pic" src="../assets/images/{{$candidate->txtCandPic}}" style="background-size: contain; max-width:152px;border: 2px solid darkgray" /> 
                             </div>
                             <div class="caption">
                                 <h4 style="text-transform: capitalize;font-weight:bold">{{$candidate->strMemFname}} {{$candidate->strMemLname}}</h4>
                                 <h5 style="font-family:segoe ui;text-transform: capitalize;"> {{$position->strPosName}}</h5>
                             </div>
                             <center>
                             <button type="button" class="btn btn-info btn-xs" data-toggle="collapse" href="#{{$candidate->strCandId}}" style="width:150px;">Information</button></center>
                                  <div id="{{$candidate->strCandId}}" class="collapse" >
                                    <p style="margin-left:5px;font-family:segoe ui;">Education Background: &nbsp {{ $candidate->strCandEducBack}} </p>

                                    <p style="margin-left:5px;font-family:segoe ui;"> Platform: &nbsp {{ $candidate->strCandInfo}} </p>
                                  </div>
                          </div>
                    </div>
                    @endif
                    @endif
                @endforeach
            @endforeach
                </div>
            </div>
        @endforeach
        </div>
        
    </div>
    </div>
<footer style="text-shadow: 2px 2px 8px rgba(5, 5, 5, 0.62);background-color:rgba(0, 0, 0, 0.35);height:59px;">
<center><p style="color:white;font-size:14px;font-family: segoe ui;padding-top:10px;">Copyright © 2015-2016 iVote++<br>All rights reserved</p></center>
</footer>
    
    <!-- jQuery 2.2.0 -->
<script src="{{ URL::asset('assets/jquery/jquery.min.js') }}"></script>
<script src="{{ URL::asset('assets/jquery/jquery-ui.min.js') }}"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{ URL::asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
<!-- SlimScroll -->
<script src="{{ URL::asset('assets/plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/iCheck/icheck.min.js')}}"></script>
<!-- FastClick -->
<script src="{{ URL::asset('assets/plugins/fastclick/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{ URL::asset('assets/dist/js/app.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ URL::asset('assets/dist/js/demo.js')}}"></script>
<script>
  $(function () {
    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass: 'iradio_minimal-blue'
    });
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass: 'iradio_minimal-red'
    });
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass: 'iradio_flat-green'
    });
  });
</script>
@yield('script')   
</body>
</html>
    