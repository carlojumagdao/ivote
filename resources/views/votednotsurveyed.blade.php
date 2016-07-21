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
      background-repeat: no-repeat;
      
      
    }
    footer {
      width:100%;
      height:100px;
      position:absolute;
      bottom:0;
      left:0;
    }
    
</style>

</head>
<body>
  <div class="wrapper">
    <center>
    <p style="font-size:70px;color:white;margin-top:130px;font-family:Helvetica;text-shadow: 2px 2px 8px rgba(5, 5, 5, 0.62);">You already voted but you did not answer the survey.</p>
    </center>
    
    <center>
    <p style="font-size:65px;color:#1d96f3  ;font-family:Helvetica ;">Thank you for participating.</p>
    </center>
    <div class="row">
               <div class="col-md-4 col-md-offset-4" style="padding-top:30px;">
                  <center>
                      <button style="font-size:14px;background-color:rgba(250, 254, 255, 0.93);color:DarkSlateGray;border-color: none; width:60%" type="submit" class="btn btn-primary btn-block btn-flat">
Click to start answering the survey</button>
                    </center> 
                </div>
    </div>

  </div>
  </div>
	
  <!-- /.form-box -->
<footer style="text-shadow: 2px 2px 8px rgba(5, 5, 5, 0.62);background-color:rgba(0, 0, 0, 0.35);height:60px;">
<center><p style="color:white;font-size:14px;font-family: segoe ui;padding-top:10px;">Copyright © 2015-2016 iVote++<br>All rights reserved.</p></center>
</footer>

<!-- /.login-box -->
<!-- jQuery 2.2.0 -->

</body>
</html>