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
    <!-- for the jquery to hide positions without candidate -->
    <script src="{{ URL::asset('assets/jquery/jquery.min.js') }}"></script>

    <style>
        .body{
            padding:0;
            background-color: #fff;
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
            <h2 class="responsive-text">{{$set->strSetElecName}}</h2>
            <h4 class="responsive-text">{{$set->strHeader}}</h4>
            <h5 class="responsive-text">Powered by: iVOTE++</h5>
        </div>
    </div>
    <div class="row header2" style="border-top:1px solid white;">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="pull-left" >
                <h4 class="responsive-text">SELECT YOUR CANDIDATE</h4>
            </div>
            <div class="pull-right" >
                <h4 class="responsive-text">Member: <span style="font-weight:bold">{{$memberName}}</span> </h4>
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
                    'action' => 'votingController@summary',
                    'class' => 'col s12',
                    'files' => true
                ) ) !!}
        <div class="col-md-10 col-md-offset-1">
        <div class="box-header boxhead" style="background-color: #3c8dbc ">
            <h3 style="font-family:helvetica;letter-spacing:1px;" class="box-title">Vote Straight ?</h3>
        </div>
        <div class="box-body boxbody" style="padding: 40px;">
            @foreach($partylist as $party)
            @if($party->strPartyName != 'Independent')
            <div class="radio">
                <label >
                    <input  type="radio" value="{{$party->intCandParId}}" name="par" class="vote_{{$party->intCandParId}}" onclick="revert(); auto_{{$party->intCandParId}}()" value='{{$party->strPartyName}}'>
                    {{$party->strPartyName}}
                </label>
            </div>
            @endif
             @endforeach
        </div>
            <br>
        </div>    
        <div class="col-md-10 col-md-offset-1">
            
            @foreach($positions as $position)
            <div class="box-header boxhead {{$position->strPosName}}" style="background-color: @if($position->strPosColor == NULL) cornflowerblue @else {{$position->strPosColor}} @endif ">
                <h3  style="font-family:helvetica;letter-spacing:1px;" class="box-title">{{$position->strPosName}} | <span style="font-size: 12px;">vote limit: {{$position->intPosVoteLimit}}</span></h3>
                <input type="hidden" name='position[]' value='{{$position->strPositionId}}'>
            </div>
            <div class="box-body boxbody {{$position->strPosName}}" style="padding: 40px;">
                <?php $intCounter = 0; ?>
                @foreach($candidates as $candidate)
                    @if($candidate->strCandPosId == $position->strPositionId )
                        <div class="col-lg-3 col-md-5 col-xs-12">
                            <div class="thumbnail boxtheme" style="border-left: 5px solid {{$candidate->strPartyColor}};  ">
                                <center>
                                <div class="checkbox">
                                    <label style="font-family:helvetica;">
                                        <div>
                                            <img id="cand-pic" src="../assets/images/{{$candidate->txtCandPic}}" style="background-size: contain; border: 0px; padding-bottom:10px;padding-right:15px;" class="img-responsive"/> 
                                        </div>
                                       
                                        <input style="text-transform:capitalize;padding-top:15px;" type="checkbox" value="{{$candidate->strCandId}}" name="vote[]"  class="pos_{{$position->strPositionId}} v_{{$candidate->intCandParId}} responsive-text" onclick=" return maxCast_{{$position->strPositionId}}()"
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
                                    <p class="responsive-text" style="font-size: 10px;">{{$candidate->strPartyName}}</p>
                                </div>
                                </center>
                            </div>
                        </div>
                        <?php $intCounter++; ?>
                    @endif
                @endforeach  
                @if(!$intCounter)
                    <script>
                         $(function(){
                            $(".{{$position->strPosName}}").hide();
                          });
                    </script>
                @endif         
            </div>
            <br>
            @endforeach
        </div>
        <div class="row"  style="padding-right:80px">
            <div class="col-md-2 col-md-offset-10 col-xs-4 col-xs-offset-4 col-sm-4">
                <input style="height:40px;" type="submit" class="btn btn-primary responsive-text" name="btnSubmit" value="CAST MY VOTES!">
            </div>
            
        </div>
         {!! Form::close() !!}
    </div>
    <br>
    <footer class="row header2" style="height:25px">
        <div class="col-md-12">
            <div class="pull-right hidden-xs">
                <b>Version</b> 1.2.1
            </div>
            <strong style="margin-left:10px;padding-top:40px;">Copyright &copy; 2015-2016 <a href="http://ivote++.com" class="btn btn-xs btn-primary">&nbsp iVote++ &nbsp </a>&nbsp .</strong> All rights
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
<script src="{{ URL::asset('assets/responsivetext/jquery.responsivetext.js') }}"></script>
<script type="text/javascript">
  $("p").responsiveText({
     bottomStop : '500',
     topStop    : '1000'
});
</script>
<script>
@foreach($positions as $position)

    function maxCast_{{$position->strPositionId}}(){
        var maxcheck = {{$position->intPosVoteLimit}};
        var position = "{{$position->strPosName}}";
        var checkedBox = $(".pos_{{$position->strPositionId}}:checked").size();
        var radio = document.getElementsByName('par');
        for(var x=0; x<radio.length; x++){
            if(radio[x].checked == true) radio[x].checked=false; 
        }
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
    