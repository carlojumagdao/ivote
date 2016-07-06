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
<body style="background-color: #bbb">
    <div style="padding: 20px">
    <h3></h3>
    <div class="row">
        <div class="col-md-2">
            <div class="card-panel2 tooltipped" data-position="top" data-delay="50" data-tooltip="logo picture">
                <img id="cand-pic" src="../assets/images/ivote.jpg" width="200px" style="background-size: contain" /> 
            </div>
        </div>
        <div class="col-md-9 panel" style="border-left: 4px solid #2c8798; background-color:#eee">
            <div class="panel-body">
               
                <h2>Header Here</h2>
                @foreach($election as $setting)
                <h4>{{$setting->strSetElecName}}</h5>
                <h5>{{$setting->strSetElecDesc}}</h5>
                @endforeach
                <h5 style="color: red">"Election Not Open Yet"</h5>
                
            </div>
        </div>
    </div>
    
    <div class="box">
        <div class="box-header"  style="border-top: 4px solid #2c8798; background-color:#eee">
            <h3 class="box-title">Candidates</h3>
        </div>
        <div class="box-body" style="padding: 40px">
            
            @foreach($positions as $position)
                   <div class="row panel" style="border-left: 4px solid #2c879; background-color:#eee">
                 <div class="col-md-12">
                     <h3>{{$position->strPosName}}</h3>
                
                @foreach($candidates as $candidate)
                     
                    @if($candidate->strCandPosId == $position->strPositionId )
                     <div class="col-md-2">
                         <div class="thumbnail">
                             <div class="panel tooltipped" data-position="top" data-delay="50" data-tooltip="logo picture">
                                 <img id="cand-pic" src="../assets/images/{{$candidate->txtCandPic}}" style="background-size: contain; max-width:165px" /> 
                             </div>
                             <div class="caption">
                                 <h4>{{$candidate->strMemFname}} {{$candidate->strMemLname}}</h4>
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
    