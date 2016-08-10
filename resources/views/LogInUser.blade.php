
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


<style>
    body{
      /*background-image: url("{{ URL::asset('assets/images/7.jpg') }}");
        background-size: cover;*/
        background-color: white;
    }
    .form-control{
      background-color: rgba(232, 232, 232, 0.71);
      border-color: gray;
      
    }
    .login-box-body{
      background-color:transparent;
      color:black;
      
    }
    h1{
      font-weight: bold;
      font-size: 49px;
      -webkit-text-stroke-width: .5px;
      -webkit-text-stroke-color: yellow;
      -webkit-font-smoothing: antialiased;
    }
    .custom {height: 180px; }
    input[type="text"]{
    	color: SteelBlue;
    } 
     
    header {
        background:#ededed;
        padding-left: 0px;
        padding-bottom: none;
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
<header style="background-color:rgba(248, 248, 248, 0.71);border-bottom: 3px solid  DodgerBlue ">
    
 <div class="row ">
 
      <div class="col-md-2 col-xs-6">
            <div class="tooltipped" data-position="top" data-delay="50" data-tooltip="logo picture">
                <img id="cand-pic" class="img-responsive" src="assets/images/systemlogo.png"  style="opacity:2px; width: 140px;margin-left: 50px " /> 
            </div>
        </div>
        <div class="col-md-10 col-xs-6 "  >
            
               
                <h4 class="responsive-text" style="font-family:helvetica;text-align:left;letter-spacing:1px;padding-top:23px;">The iVote++</h4>
                
                <h4 class="responsive-text" style="font-family:segoe ui;text-align:left;">Election System</h4>
                
            
        </div>

</div>
</header>
<body>
  <div class="container">
      <div class="login-box" style="width:80%;padding-top:none;">
          
                <h6 class="responsive-text"  style="font-family:helvetica;text-align:center;letter-spacing:1px;">Enter your Member Code to start voting</h6>
                <div class="col-md-4 col-xs-12">
                    <img id="cand-pic" class="img-responsive" src='{{ URL::asset("assets/images/$logo") }}' style="padding-top:30px">
                    <br>
                    <h4 class="responsive-text" style="color:white;text-align:center;color:SteelBlue;">{{$header}}</h4>
                    <h6 class="responsive-text" style="font-family:helvetica;text-align:center;">Powered by iVote++</h6>
                </div>
                <div class="col-md-6 col-xs-12"> 
                    <div class="col-md-12">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            {!! implode('', $errors->all(
                                '<li>:message</li>'
                            )) !!}
                        </div>
                    @endif
                    </div>
                <br><br>
                <div class="login-box-body">
                     <form action='{{ URL::to("/") }}' method="post">
                      {!! csrf_field() !!}
                        <div class="form-group has-feedback">
                            <input style="font-size:75px; text-align:center;" type="text" name="txtPasscode" class="form-control custom responsive-text" autocomplete="off" maxlength="6">
                        </div>
                        <div class="form-group has-feedback">
                            <select name="secques" class="form-control " required>
                                 <option disabled="true" selected="true">Choose your security question</option>
                                 @foreach($SecQues as $value)
                                  <option value='{{$value->intSecQuesId}}'>{{$value->strSecQuestion}}</option>
                                 @endforeach
                             </select>
                        </div>
                        <div class="form-group has-feedback">
                            <input type="text" name="txtAnswer" class="form-control " placeholder="Enter your answer in your security question" autocomplete="off">
                        </div>
                        
                        <div class="row">
                           <div class="col-md-12">
                              <center>
                                  <button style="font-size:30px;" type="submit" class="btn btn-primary btn-block btn-flat ">Start Voting</button>
                                </center> 
                            </div>
                        </div>
                      </form>
          </div> 
      </div>
  </div>
  <!-- /.form-box -->


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
  $("header").responsiveText();

</script>
<script type="text/javascript">
  $("header").responsiveText({
     bottomStop : '500',
     topStop    : '1500'
});
</script>
<script type="text/javascript">
  $("h6").responsiveText({
     bottomStop : '800',
     topStop    : '1500'
});
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
