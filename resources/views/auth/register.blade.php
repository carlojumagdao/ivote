
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>iVote++ | Registration Page</title>
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
<div class="login-box" style="width:500px ">
  <div class="login-box-body" padding-top: "40px">
    <center>
      <img src="{{ URL::asset('assets/images/i.png') }}" style="width:100%;">
      <h4>Election Content Management and Exit Poll Survey System</h4>
    </center>
    <br>
    <form method="POST" action="/auth/register">
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
            <div>
                <center>
                    <div class="col s12">
                        <br>
                        <div class="card-panel2 tooltipped" data-position="top" data-delay="50" data-tooltip="logo picture">
                            <img id="user-pic" src="../assets/images/Avatar.jpg" width="180px" height="180px" style="background-size: contain;" /> 
                        </div>
                    </div>
                </center>
                <div class="form-group col-md-12 ">
                    <span class="btn btn-default btn-file">
                    {!! Form::label( 'file', 'File Path:' ) !!}
                    {!! Form::file
                        ('file', array(
                        'id' => 'file',
                        'name' => 'image',
                        'class' => 'form-control btn btn-success btn-xs',
                        'enctype' => 'multipart/form-data',
                        'style' => 'display:none',
                        'onchange' => '$("#upload-file-info").html($(this).val());readURL(this)',
                        )) 
                    !!}
                    </span>
                    <span class='label label-info' id="upload-file-info"></span>
                </div>
                <div class="box-body">
                    <div class="form-group col-md-12 ">
                        <label for="Name">Name:</label>
                        <input id="Name" placeholder="Full Name" name="name" class="form-control" required="1" type="text" value="{{ old('name') }}">  
                    </div>
                    <div class="form-group col-md-12 ">
                        <label for="Email">Email:</label>
                        <input id="Email" placeholder="Email" name="email" class="form-control" required="1" type="email" value="{{ old('email') }}">  
                    </div>
                    <div class="form-group col-md-12 ">
                        <label for="password">Password:</label>
                        <input id = "password" name = "password" type="password" class="form-control" placeholder="Must be at least 6 characters.">
                    </div>
                    <div class="form-group col-md-12 ">
                        <label for="password">Confirm Password:</label>

                        <input id = "password_confirm" name = "password_confirmation" type="password" class="form-control" placeholder="Re-enter Password.">
                    </div>
                    <div class="col-xs-4">
                      <input type="submit" class="btn btn-primary btn-block btn-flat" name="btnRegister" value="Register">
                    </div>
                </div>
              </form>
            </div>
    <!-- <a href="#" style="color:white;">forgot password?</a><br> -->
  </div>
  <!-- /.form-box -->
<br> 
<center><p style="color:white;font-size:16px;">Powered by iVote++</p></center>
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
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
                reader.onload = function (e) {
                    $('#user-pic')
                    .attr('src', e.target.result)
                    .width(180)
                    .height(180);
                    
                };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
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
