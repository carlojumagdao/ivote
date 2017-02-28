<?php
  $image = "https://s3.amazonaws.com/ndap-ivote-2017/settings/".$logo."";
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
	
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>iVote++ | User Login Page</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="{{ URL::asset('assets/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('assets/bootstrap/css/font-awesome.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('assets/bootstrap/css/ionicons.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('assets/plugins/iCheck/all.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('assets/dist/css/AdminLTE.min.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('assets/dist/css/skins/_all-skins.min.css') }}">
    <script src='https://www.google.com/recaptcha/api.js?hl='></script>

<style>
    body{
      background-image: url("{{ URL::asset('assets/images/7.jpg') }}");
        background-size: cover;
      
      background-attachment: inherit;
      
      
    }
    .form-control{
      background-color: rgba(232, 232, 232, 0.28);
      border-color: gray;
      
    }
    
    
    .login-box-body{
      background-color:rgba(248, 248, 248, 0.71);
      color: black;
    }
    h1{
      font-weight: bold;
      font-size: 49px;
      -webkit-text-stroke-width: .5px;
      -webkit-text-stroke-color: yellow;
      -webkit-font-smoothing: antialiased;
    }
    .custom {height: 50px}
    input[type="text"]{
    	color: SteelBlue ;
    } 
</style>

</head>
<body>
  <div class="wrapper">
	<div class="login-box">
  <div class="login-box-body">
    <center>
      <img src='{{ $image }}' style="max-width: 130px;">
      <br>
      <h3>{{$header}}</h3>
    </center>
    <div class="col-md-12">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
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
    <br><br>
         <form action='{{ URL::to("/security/question/$id") }}' method="post">
      		{!! csrf_field() !!}
             <div class="form-group has-feedback">
                <input style="font-size:25px; text-align:center;" type="text" name="txtPasscode" class="form-control custom" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;6-digit Passcode" autocomplete="off" maxlength="6">
            </div>
            <div class="form-group has-feedback">
                <select name="secques" class="form-control" required>
                     <option disabled="true" selected="true">Choose your security question</option>
                     @foreach($SecQues as $value)
                     	<option value='{{$value->intSecQuesId}}'>{{$value->strSecQuestion}}</option>
                     @endforeach
                 </select>
            </div>
            <div class="form-group has-feedback">
                <input type="text" name="txtAnswer" class="form-control" placeholder="Enter your answer in your security question" autocomplete="off">
            </div>
            <div class="row">
               <div class="col-md-6">
               		<center>
                  		<div class="col s12 offset-s1">
                            <div class="g-recaptcha" data-sitekey="{{$sitekey}}" required></div>
                        </div>
                  	</center>	
                </div>
            </div>
            <br><br>
            <div class="row">
               <div class="col-md-6 col-md-offset-3">
               		<center>
                  		<button style="font-size:20px;" type="submit" class="btn btn-primary btn-block btn-flat">Submit</button>
                  	</center>	
                </div>
            </div>
    </form>
  </div>
  <!-- /.form-box -->
<footer style="text-shadow: 2px 2px 8px rgba(5, 5, 5, 0.62);background-color:rgba(0, 0, 0, 0.35);height:59px;">
<div class="col-md-8">
      <p style="color:white;font-size:16px;font-family: segoe ui;padding-top:20px;margin-left:65px;">Powered by iVote++</p>
</div>
<div class="col-md-4">
<img src="../../assets/images/ivote5.png" style="width:50%;padding-top:13px;">
</div>
</footer>
</div>
<!-- /.login-box -->
<!-- jQuery 2.2.0 -->
<script src="{{ URL::asset('assets/jquery/jquery.min.js') }}"></script>
<script src="{{ URL::asset('assets/jquery/jquery-ui.min.js') }}"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{ URL::asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
<!-- iCheck -->
<script src="{{ URL::asset('assets/plugins/iCheck/icheck.min.js')}}"></script>
<script>
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
</script>
</body>
</html>
