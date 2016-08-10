<?php 

  use App\ui AS ui;

    $ui = ui::find(1);
    if($ui) $skin = $ui->strUISkin;
    else $skin = 'skin-blue';
    $bgcolor = 'lightgrey';
    $headercolor = 'white';
    $theme = "white";
    $themeSub = "white";
    $boxTheme = "white";
    $pieces = explode("-", $skin);

    if(sizeof($pieces) == 3){
        $color = '#242424';
        $headercolor = 'white';
        $theme = 'white';
        $themeSub = '#ecf0f5';
        
    }
    else{
        $color = 'white';
        $theme = '#242424';
        $themeSub = '#3c3f41';
        $boxTheme = '#626262';
    }

    switch($pieces[1]){
        case 'blue':
            $bgcolor = "#3c8dbc";
            break;
        case 'yellow':
            $bgcolor = "#f39c12";
            break;
        case 'green':
            $bgcolor = "#00a65a";
            break;
        case 'purple':
            $bgcolor = "#605ca8";
            break;
        case 'red':
            $bgcolor = "#dd4b39";
            break;
        case 'black':
            $bgcolor = "#eee";
            $headercolor = '#242424';
            break;
        
    }

    
    if(Session::has('memid')){
        $memberID = session('memid');
        $memberName = session('memfullname');
    }

    else{
        $memberID = "None";
        $memberName = "None";
    }

    
?>
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
    <style>
        .body{
            padding:0;
            background-color: {{$theme}};
        }
        .paddify{
            padding: 10px;
        }
        .resizepic{
            max-width: 140px;
        }
        
        .resizepic2{
            max-width: 100px;
        }
        .header2{
            background-color: {{$bgcolor}};
            border-bottom: 2px solid {{$bgcolor}};
            color: {{$headercolor}}
        }
        .boxhead{
            
            color: {{$headercolor}};
            
        }
        
        .boxbody{
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            background-color: {{$themeSub}};
            color: {{$color}}
        }
        
        .boxtheme{
            border-bottom: 0px;
            border-right: 0px ;
            border-top: 0px;
            background-color: {{$boxTheme}};
            color: {{$color}};
        }
    </style>
</head>
<body class="body">
    @foreach($election as $set)
    <div class="row header2">
        <div class="col-md-2 col-xs-4 col-md-offset-2">
            <img src="assets/images/{{$set->txtSetLogo}}" class="paddify img-responsive">
        </div>
        <div class="col-md-3 col-xs-8">
            <h3 style="font-family:helvetica;text-align:left;text-transform:capitalize">{{$set->strSetElecName}}</h3>
            <h4 style="font-family:segoe ui;text-align:left;margin-top:10px;text-transform:capitalize">{{$set->strHeader}}</h4>
            <h5 style="font-family:segoe ui;text-align:left;text-transform:capitalize">Powered by: iVOTE++</h5>
        </div>
    </div>
    
    <div class="row header2">
        <div class="col-md-4 col-md-offset-1" >
            <h4 style="font-family:helvetica; letter-spacing: 1px; text-transform: uppercase">Select Your Candidate</h4>
        </div>
        <div class="col-md-2 col-md-offset-4" >
            <h5 style="font-family:segoe ui; ">Member: <big style="font-weight:bold;font-family:helvetica;text-transform:capitalize">{{$memberName}}</big> </h5>
        </div>
            
    </div>
    @endforeach
    <br>
    <div class="row">
        {!! Form::open( array(
                    'method' => 'post',
                    'id' => 'form-vote',
                    'action' => 'votingController@summary',
                    'onsubmit' => 'return confirm_submit()',
                    'class' => 'col s12',
                    'files' => true
                ) ) !!}
                    
                
        <div class="col-md-10 col-md-offset-1">
            @foreach($positions as $position)
            <div class="box-header boxhead" style="background-color: @if($position->strPosColor == NULL) cornflowerblue @else {{$position->strPosColor}} @endif ">
                <h3  style="font-family:helvetica;letter-spacing:1px;text-transform:capitalize" class="box-title">{{$position->strPosName}} | <span style="font-size: 12px">vote limit: {{$position->intPosVoteLimit}}</span></h3>
                <input type="hidden" name='position[]' value='{{$position->strPositionId}}'>
            </div>
            <div class="box-body boxbody" style="padding: 40px;">
                    @foreach($candidates as $candidate)
                     
                    @if($candidate->strCandPosId == $position->strCandPosId )
                
                    
                        
                <div class="col-md-2 col-xs-12">
                    <div class="thumbnail boxtheme">
                        <center>
                        <div class="tooltipped" data-position="top" data-delay="50" data-tooltip="logo picture">
                            <img id="cand-pic" src="../assets/images/{{$candidate->txtCandPic}}" style="background-size: contain;" class="img-responsive"/> 
                        </div>
                        <div class="checkbox">
                            <label>
                                <input style="text-transform:capitalize" type="checkbox" value="{{$candidate->strCandId}}" name="vote[]" class="pos_{{$position->strPositionId}}" onclick=" return maxCast_{{$position->strPositionId}}()"
                                
                                       <?php
                                    $cdvote = old('vote');
                                    
                                  for($x=0; $x<sizeOf(old('vote')); $x++){
                        
                                      if($cdvote[$x] == $candidate->strCandId)
                                          echo 'checked=checked';
                                  }
                                
                                ?>
                                       
                                       >
                                     {{$candidate->strMemFname}} {{$candidate->strMemLname}}
                            </label>
                        </div>
                        </center>
                    </div>
                </div>
                           
                    @endif
                @endforeach           
            </div>
            <br>
            @endforeach
        </div>
        <div class="row"  style="padding-right:72px;">
            <div class="col-md-2 col-md-offset-10 col-xs-4 col-xs-offset-4 col-sm-4">
                <input  style="font-family:segoe ui;height:40px;"  type="submit" class="btn btn-primary" name="btnSubmit" value="CAST MY VOTES!">
            </div>
            
        </div>
         {!! Form::close() !!}
    </div>
    <br>
    <footer class="row header2">
        <div class="col-md-12">
            <div class="pull-right hidden-xs">
                <b>Version</b> 1.2.1
            </div>
            <strong style="margin-left:10px;padding-top:40px;">Copyright &copy; 2015-2016 <a href="http://ivote++.com" class="btn btn-xs btn-primary">&nbsp iVote++ &nbsp</a>&nbsp .</strong> All rights
            reserved. &nbsp &nbsp 
        </div>  
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
<script>
@foreach($positions as $position)

function maxCast_{{$position->strPositionId}}(){

		var maxcheck = {{$position->intPosVoteLimit}};
		var position = "{{$position->strPosName}}";
		
		var checkedBox = $(".pos_{{$position->strPositionId}}:checked").size();
		
		if(checkedBox > maxcheck){
		
			alert('You can only vote ' + maxcheck + ' from the ' + position + ' position.');document.voteform; return false;
			
		}
		
		else return true;
	}
 @endforeach
</script>
<script>
    function confirm_submit(){
        var r = confirm("Are you sure you want to cast this votes?");
        if (r == true) {
            return true;
        } else {
            return false;
        }
    }
</script>
@yield('script')   
</body>
</html>
    