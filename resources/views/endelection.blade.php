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
      padding:20px;
      }
      footer {
      width:100%;
      height:100px;
      position:absolute;
      bottom:0;
      left:0;
      overflow-x: hidden;
      overflow-y: hidden;
    }
      
    
</style>

</head>
<body>
  <div class="wrapper">
    <center>
    <p class="responsive-text" style="font-size:75px;color:white;margin-top:100px;font-family:Helvetica;text-shadow: 2px 2px 8px rgba(5, 5, 5, 0.62);">The Election is already closed. </p>
    </center>
    <center>
    <p class="responsive-text" style="font-size:60px;color:#1d96f3 ;font-family:Helvetica ;">Thank you for participating.</p>
    </center>

  </div>
  </div>
	
  <!-- /.form-box -->
<footer style="text-shadow: 2px 2px 8px rgba(5, 5, 5, 0.62);background-color:rgba(0, 0, 0, 0.35);height:59px;">
<center><p style="color:white;font-size:14px;font-family: segoe ui;padding-top:10px;">Copyright © 2015-2016 iVote++<br>All rights reserved</p></center>
</footer>

<script src="{{ URL::asset('assets/jquery/jquery.min.js') }}"></script>
<script src="{{ URL::asset('assets/jquery/jquery-ui.min.js') }}"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{ URL::asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('assets/mc-profile/js/jquery.material-cards.min.js') }}"></script>
<script src="{{ URL::asset('assets/mc-profile/dist/mansory.js') }}"></script>
<script src="{{ URL::asset('assets/responsivetext/jquery.responsivetext.js') }}"></script>
<script type="text/javascript">
  $("body").responsiveText({
     bottomStop : '480',
     topStop    : '1400'
});
</script>

<!-- /.login-box -->
<!-- jQuery 2.2.0 -->

</body>
</html>
