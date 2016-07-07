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
        }
        .header{
            background-color: lightgray;
        }
        .paddify{
            padding: 20px;
        }
        .resizepic{
            max-height: 180px;
        }
        .header2{
            background-color: #eee;
            border-bottom: 2px solid lightgray;
        }
        .boxhead{
            
            color: white;
            
        }
        
        .boxbody{
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);;
        }
    </style>
</head>
<body class="body">
    @foreach($election as $set)
    <div class="row header2">
        <div class="col-md-2 col-md-offset-1">
            <img src="assets/images/{{$set->txtSetLogo}}" class="paddify resizepic">
        </div>
        <div class="col-md-3">
            <h2>{{$set->strSetElecName}}</h2>
            <h3>{{$set->strHeader}}</h3>
            <h4>Powered by: iVOTE++</h4>
        </div>
        <div class="col-md-2 col-md-offset-3">
            <img src="assets/images/systemlogo.png" class="paddify resizepic">
        </div>
    </div>
    
    <div class="row header2">
        <div class="col-md-4 col-md-offset-1" >
            <h4>SELECT YOUR CANDIDATE</h4>
        </div>
        <div class="col-md-2 col-md-offset-4" >
            <h5>Member: name of voter</h5>
        </div>
            
    </div>
    @endforeach
    <br>
    <div class="row"> 
    <div class="col-md-10 col-md-offset-1">
        <div class="box-header boxhead" style="background-color: cornflowerblue ">
            <h3 class="box-title">Vote Straight???</h3>
        </div>
        <div class="box-body boxbody" style="padding: 40px;">
            @foreach($partylist as $party)
            @if($party->strPartyName != 'Independent')
            <div class="radio">
                <label>
                    <input type="radio" value="{{$party->intCandParId}}" name="party" class="vote_{{$party->intCandParId}}" onclick="revert(); auto_{{$party->intCandParId}}()">
                    {{$party->strPartyName}}
                </label>
            </div>
            @endif
             @endforeach
        </div>
    </div>
    </div>
    <br>
    <div class="row">
        {!! Form::open( array(
                    'method' => 'post',
                    'id' => 'form-vote',
                    'action' => 'votingController@cast',
                    'onsubmit' => 'return confirm_submit()',
                    'class' => 'col s12',
                    'files' => true
                ) ) !!}
                    
                
        <div class="col-md-10 col-md-offset-1">
            
            @foreach($positions as $position)
            <div class="box-header boxhead" style="background-color: @if($position->strPosColor == NULL) cornflowerblue @else {{$position->strPosColor}} @endif ">
                <h3 class="box-title">{{$position->strPosName}} | <span style="font-size: 12px">vote limit: {{$position->intPosVoteLimit}}</span></h3>
            </div>
            <div class="box-body boxbody" style="padding: 40px;">
                    @foreach($candidates as $candidate)
                     
                    @if($candidate->strCandPosId == $position->strPositionId )
                
                    
                        
                <div class="col-md-2">
                    <div class="thumbnail" style="border-left: 3px solid {{$candidate->strPartyColor}};">
                        <div class="panel tooltipped" data-position="top" data-delay="50" data-tooltip="logo picture">
                            <img id="cand-pic" src="../assets/images/{{$candidate->txtCandPic}}" style="background-size: contain; max-width:130px" /> 
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="{{$candidate->strCandPosId}}" name="vote[]"  class="pos_{{$position->strPositionId}} v_{{$candidate->intCandParId}}" onclick=" return maxCast_{{$position->strPositionId}}()" onchange="return maxCast_{{$position->strPositionId}}()">
                                     {{$candidate->strMemFname}} {{$candidate->strMemLname}}
                            </label>
                            <p style="font-size: 10px;">{{$candidate->strPartyName}}</p>
                        </div>
                    </div>
                </div>
                           
                    @endif
                @endforeach           
            </div>
            <br>
            @endforeach
        </div>
        <div class="row">
            <div class="col-md-2 col-md-offset-10">
                <input type="submit" class="btn btn-primary" name="btnSubmit" value="CAST MY VOTES!">
            </div>
            
        </div>
         {!! Form::close() !!}
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
    
    @foreach($partylist as $party)
    function auto_{{$party->intCandParId}}(){
        
        $('.v_{{$party->intCandParId}}').prop('checked', true);
    }
    
    @endforeach
    
    
    function revert(){
        @foreach($partylist as $party)
        $('.v_{{$party->intCandParId}}').prop('checked', false);
        @endforeach
    }
    
    
    
    
</script>
@yield('script')   
</body>
</html>
    