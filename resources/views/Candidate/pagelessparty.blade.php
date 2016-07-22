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
      header {
        background:#ededed;
        padding:10px;
        padding-left: 50px;
        height: 200px;
      }
      .header-cont {
          width:97%;
          position:relative;
          top:0px;
         margin-left: 20px;
      }
      /*footer {
      width:100%;
      height:100px;
      position:absolute;
      bottom:0;
      left:0;
    }*/
      
    
</style>
<header style="background-color:rgba(248, 248, 248, 0.71);border-bottom: 3px solid  DodgerBlue ">
 @foreach($election as $setting)
 <div class="row">
 
      <div class="col-md-2 col-xs-6">
            <div class="tooltipped" data-position="top" data-delay="50" data-tooltip="logo picture">
                <img id="cand-pic" class="img-responsive" src="../assets/images/{{$setting->txtSetLogo}}"  style="opacity:2px; width: 180px;background-size: contain " /> 
            </div>
        </div>
        <div class="col-md-7 col-xs-6 "  >
            
               
                <h2 style="font-family:helvetica;text-align:left;text-transform: capitalize;letter-spacing:1px">{{$setting->strHeader}}</h2>
                
                <h4 style="font-family:segoe ui;text-align:left;margin-top:10px;">{{$setting->strSetElecName}}</h5>
                <h5 style="font-family:segoe ui;text-align:left;letter-spacing:1px;text-transform: capitalize;">{{$setting->strSetElecDesc}}</h5>
                @endforeach
                <h5 style="style=font-family:segoe ui;text-align:left;letter-spacing:1px;color:Tomato ">"Election Not Open Yet"</h5>
                
            
        </div>

</div>
  
</header>
<body>
    <div style="padding: 10px">
    <h3></h3>
    </div>
    
    <div class="box header-cont" style="background-color:rgba(248, 248, 248, 0.71);" >
        <div class="box-header"  style="background-color:rgba(248, 248, 248, 0.71)">
            <p class="box-title" style="font-family:helvetica;letter-spacing:2px;font-size:28px;margin-left: 16px;color: DodgerBlue">Candidates</p>
        </div>
        <div class="box-body" style="padding-left: 40px;padding-right:40px">
            
            @foreach($positions as $position)
                   <div class="row panel" style="border-left: 4px solid GoldenRod    ;background-color:rgba(0, 0, 0, 0.20)">
                 <div class="col-md-12">
                      <div class="col-md-12" style="font-family:segoe ui;text-transform: capitalize;"><h5 style="letter-spacing:1px">Position Name</h5><h3 style="letter-spacing:1px;font-family: helvetica;color: white  ;text-shadow: 1px 1px 4px rgba(6, 5, 5, 0.62);">{{$position->strPosName}}</h3></div>
                     
                
                @foreach($candidates as $candidate)
                     
                    @if($candidate->strCandPosId == $position->strCandPosId )
                     <div class="col-md-2 col-xs-6">
                         <div class="thumbnail">
                             <div class="panel tooltipped" data-position="top" data-delay="50" data-tooltip="logo picture">
                                 <img id="cand-pic" src="../assets/images/{{$candidate->txtCandPic}}"  class="img-responsive" style="background-size: contain; border: 2px solid darkgray" class="img-responsive" /> 
                             </div>
                             <div class="caption">
                                 <center><p style="text-transform: capitalize;font-size: 16px;font-family: segoe ui ">{{$candidate->strMemFname}} {{$candidate->strMemLname}}</p></center>
                                 <button type="button" class="btn btn-info btn-xs" data-toggle="collapse" href="#{{$candidate->strCandId}}" style="width:120px;">Information</button></center>
                                  <div id="{{$candidate->strCandId}}" class="collapse" >
                                    <p style="margin-left:5px;font-family:segoe ui;">Education Background: &nbsp {{ $candidate->strCandEducBack}} </p>

                                    <p style="margin-left:5px;font-family:segoe ui;"> Platform: &nbsp {{ $candidate->strCandInfo}} </p>
                                  </div>
                             </div>
                         </div>
                    </div>
                    @endif
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
    