
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>iVote++ Survey</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="{{ URL::asset('assets/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('assets/bootstrap/css/font-awesome.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('assets/bootstrap/css/ionicons.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('assets/plugins/iCheck/all.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('assets/dist/css/AdminLTE.min.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('assets/dist/css/skins/_all-skins.min.css') }}">

  <style>
        .login-page,
        .register-page {
          background: #ffffff;
          border-top: 250px solid #3288c5;
        }
        .login-box,
        .register-box {
          width: 750px;
          margin: 7% auto;
        }
        @media (max-width: 768px) {
          .login-box,
          .register-box {
            width: 90%;
            margin-top: 20px;
          }
        }
        .login-box-body,
        .register-box-body {
          background: #000000;
          padding: 20px;
          border-top: 0;
          color: #666;
        }
        label{
            font-size: 19px;
            font-weight: 400;
        }
        .box{
            padding: 4%;
            margin-top: 7%;
            -webkit-box-shadow: 0px 1px 5px 3px rgba(158,158,158,0.69);
            -moz-box-shadow: 0px 1px 5px 3px rgba(158,158,158,0.69);
            box-shadow: 0px 1px 5px 3px rgba(158,158,158,0.69);
        }
        h4{
            font-size: 28px;
        }
  </style>
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div>
            <div class="col-md-12" style="margin-top:-40%">
                <h3>
                    <center>
                    <img src='{{ URL::asset("assets/images/$logo") }}' style="max-width: 75px;">
                    <b >&nbsp;{{$header}}</b>
                    </center>
                </h3>
                <div class="box">
                    <div class="box-header">
                        <h1>{{$formTitle}}</h1> 
                        <p style="font-size:16px">{{$formDesc}}</p> 
                    </div>
                    <div class="box-body">
                        <?php echo "$form"; ?>
                    </div>
                    <div class="box-footer">
                        Never submit passwords through iVote++.
                    </div>
                </div>
            </div>
        </div>
  <!-- /.form-box -->
    </div>
<!-- /.login-box -->

<!-- jQuery 2.2.0 -->
<script src="{{ URL::asset('assets/jquery/jquery.min.js') }}"></script>
<script src="{{ URL::asset('assets/jquery/jquery-ui.min.js') }}"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{ URL::asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
<!-- iCheck -->
<script src="{{ URL::asset('assets/plugins/iCheck/icheck.min.js')}}"></script>
<script src="{{ URL::asset('assets/responsivetext/jquery.responsivetext.js') }}"></script>
<script type="text/javascript">
  $("body").responsiveText({
     bottomStop : '200',
     topStop    : '1400'
});
</script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
