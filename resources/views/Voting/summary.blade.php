<?php 
    
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
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <title>@yield('title', 'iVote++ | Home')</title>
    @yield('style')
    <link rel="stylesheet" href="{{ URL::asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/bootstrap/css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/bootstrap/css/ionicons.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/iCheck/all.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/dist/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/dist/css/skins/_all-skins.min.css') }}">
    <script src="//js.pusher.com/3.0/pusher.min.js"></script>  <!-- download this -->
    <script>
        Pusher.log = function(msg) {
            console.log(msg);
        };
    </script>
    <style>
        .body{
            padding:0;
            background-color: #fff;
            font-family: Helvetica, Arial, Sans-Serif;
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
            background-color: #3c8dbc;
            border-bottom: 2px solid #3c8dbc;
            color: #fff;
        }
        .boxhead{
            box-shadow: 0 0px 8px 0 rgba(0, 0, 0, 0.2), 0 0px 20px 0 rgba(0, 0, 0, 0.19);
            color: #fff;
            
        }
        .boxbody{
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            background-color: #ecf0f5;
            color: #242424;
        }
        .boxtheme{
            border-bottom: 0px;
            border-right: 0px ;
            border-top: 0px;
            background-color: #fff;
            color: #242424;
        }
    </style>
</head>
<body class="body">
    @foreach($election as $set)
    <div class="row header2">
        <div class="col-md-2 col-xs-4 col-md-offset-1">
            <img src="assets/images/{{$set->txtSetLogo}}" class="paddify img-responsive">
        </div>
        <div class="col-md-5 col-xs-8">
            <h2>{{$set->strSetElecName}}</h2>
            <h4>{{$set->strHeader}}</h4>
            <h5>Powered by: iVOTE++</h5>
        </div>
    </div>
    <div class="row header2" style="border-top:1px solid white;">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="pull-left" >
                <h4>SUMMARY OF VOTES</h4>
            </div>
            <div class="pull-right" >
                <h4>Member: <span style="font-weight:bold">{{$memberName}}</span> </h4>
            </div>  
        </div>
    </div>
    @endforeach
    <br>
    <br>
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
        <input style="text-transform:capitalize" type="hidden" value="{{$par}}" name="par">
        <input style="text-transform:capitalize" type="hidden" value="{{$countCand}}" name="countCand">
                                <br>
        <div class="col-md-10 col-md-offset-1">
            
            <div class="box-header boxhead" style="background-color:#3c8dbc">
                <h3 class="box-title">
                Votes Review</h3>
            </div>
            <div class="box-body boxbody" style="padding: 40px;">
                <center>
                    @if($candidates != NULL)
                    @foreach($candidates as $candidate)
                    <div class="row col-md-offset-4"> 
                        <center>
                        <div class="tooltipped col-md-3" data-position="top" data-delay="50" data-tooltip="logo picture">
                            <img id="cand-pic" src="../assets/images/{{$candidate->txtCandPic}}" style="background-size: contain;  border: 0px; border-left: 5px solid {{$candidate->strPosColor}};" class="img-responsive"/> 
                        </div>
                        <div class="col-md-3">
                            <label style="font-size: 20px;">
                                <input style="text-transform:capitalize" type="hidden" value="{{$candidate->strCandId}}" name="vote[]">
                                <br>
                                
                                     {{$candidate->strMemFname}} {{$candidate->strMemLname}}
                            </label>
                            <p style="font-size: 15px;">{{$candidate->strPosName}}</p>
                        </div>
                        </center>
                    </div>
                    <br>
                    <div class="col-md-6 col-md-offset-3" style="border-bottom: 1px solid #3c8dbc">
                    </div>
                    <br>
                @endforeach
                    @else
                    <div class="row col-md-offset-4"> 
                        <center>
                        <div class="col-md-3">
                            <label style="font-size: 20px;">
                                
                                     NO VOTES
                            </label>
                        </div>
                        </center>
                    </div>
                    <br>
                    <div class="col-md-6 col-md-offset-3" style="border-bottom: 1px solid #3c8dbc">
                    </div>
                    <br>
                    
                    @endif
                    
                    </center>
                <div class="col-md-6 col-md-offset-3 alert alert-warning alert-dismissible">
                        <h4><i class="icon fa fa-warning"></i><input type="checkbox" id="agree" name="agree"> IMPORTANT!</h4>
                        I reviewed my vote and understand that once I submit this, it cannot be changed. 
                    </div>
                <input type="hidden" id="blRedirect" name="redirect">
                <div class="row" style="padding-right:72px;">
                    <a href="#" style="height:40px;" onclick="redirect()">
                        <div class="col-md-1 col-md-offset-6 col-xs-4 col-xs-offset-3 col-sm-4" style="width:145px">
                            change my votes
                        </div>
                    </a>
                    <div class="col-md-1 col-xs-4 col-sm-4">
                        <input style="height:40px;" id="btnSubmit" type="submit" class="btn btn-primary" name="btnSubmit" value="SUBMIT MY VOTES!" disabled>
                    </div>
                </div>
            </div>
            <br>
        </div>
         {!! Form::close() !!}
    </div>
    <br>
    <footer class="row header2" style="height:30px">
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
    function confirm_submit(){
        var r = confirm("Are you sure you want to cast this votes?");
        if (r == true) {
            
            return true;
        } else {
            return false;
        }
    }
    
    function redirect(){
        document.getElementById('blRedirect').value = 1;
        document.getElementById('form-vote').submit();
    }
</script>
<script>
    $('#agree').change(function() {
        $('#btnSubmit').attr('disabled', !this.checked);
    });
</script>
@yield('script')   
</body>
</html>
    