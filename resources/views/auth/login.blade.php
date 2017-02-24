
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>iVote++ | Admin Login Page</title>
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
    body{
      background-image: url("{{ URL::asset('assets/images/7.jpg') }}");
        background-size: cover;
    }
    .form-control{
      background-color: rgba(232, 232, 232, 0.28);
      border-color: gray;
      color: SteelBlue;
    }
    .login-box-body{
      background-color: rgba(240, 240, 240, 0.71);
      color:black;
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
<div class="login-box">
  <div class="login-box-body">
    <center>
      <img src='{{ URL::asset("assets/images/i.PNG") }}' style="width:100%;">
      <h4>Election Content Management and Exit Poll Survey System</h4>
    </center>
    <br>
    <form action="/auth/login" method="post">
      {!! csrf_field() !!}
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
            <div class="form-group has-feedback">
                <input type="email" name="email" class="form-control" placeholder="Email">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="password" class="form-control" placeholder="Password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <br>
            <div class="row">
              <div class="col-xs-8">
                <div class="checkbox icheck" >
                  <label style="color:gray">
                    <input type="checkbox" class="flat-red" name="remember" >&nbsp;&nbsp;Remember Me</a>
                  </label>
                </div>
            </div>
              <!-- /.col -->
               <div class="col-xs-12">
                  <button type="submit" class="btn btn-primary btn-block btn-flat">Login</button>
                </div>
                <!-- <div class="col-xs-6">
                 <a href="{{ URL::to('/auth/register') }}" class="text-center">Register a new account</a>
                </div> --><!-- /.col -->
            </div>
    </form>

    <!-- <a href="#" style="color:white;">forgot password?</a><br> -->
  </div>
  <!-- /.form-box -->
<footer style="text-shadow: 2px 2px 8px rgba(5, 5, 5, 0.62);background-color:rgba(0, 0, 0, 0.35);height:59px;">
<div class="col-md-8">
      <p style="color:white;font-size:16px;font-family: segoe ui;padding-top:20px;margin-left:65px;">Powered by iVote++</p>
</div>
<div class="col-md-4">
<img src="assets/images/ivote5.png" style="width:50%;padding-top:13px;">
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
