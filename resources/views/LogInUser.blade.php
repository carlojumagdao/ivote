
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>

<style type="text/css">
	body  {
	    background-image: url(assets/images/bglogin.png);
	    background-color: 	#2F4F4F;
}
	.form.control:focus{
		border-color: #2F4F4F;
	}

	h1	{
		padding-top: 5px;
		margin-left: 30px;
		color: #f5c012;
		font-family: helvetica;
	}
	p 	{
		margin-left: 30px;
		font-size: 16px;
	}
	button	{
		appearance: none;
		outline: 0;
		border: 0;
		padding: 10px 15px;
		margin-left: 80px;
		color: @prim;
		border-radius: 3px;
		width: 100px;
		height: 40px;
		cursor: pointer;
		font-size: 24px;
		transition-duration: 0.25s;
		
		&:hover{
			background-color: white;
		}
	}
	input	{
		display: block;
		appearance: none;
		outline: 0;
		border: 1px solid fade(white, 40%);
		background-color: fade(white, 20%);
		width: 250px;
		
		border-radius: 3px;
		padding: 10px 15px;
		margin: 0 auto 10px auto;
		display: block;
		text-align: center;
		
		
		color: white;
		
		transition-duration: 0.25s;
		
		
		&:hover{
			background-color: white;
		}
		
		&:focus{
			background-color: white;
			width: 300px;
			
			color: @prim;
	}
	form{
	padding: 20px 0;
	position: relative;
	z-index: 2;
}
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
      background-image: url("{{ URL::asset('assets/images/bglogin.png') }}");
    }
    .login-box-body{
      background-color:rgba(232, 232, 232, 0.28);
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
    	color: black;
    } 
</style>

</head>
<body>
  <div class="wrapper">
	<div class="container">
		


	  <div class="col-md-3">
		<br>
	  </div>
	  <div class="col-md-6">
		  <div class="panel panel-default" style="margin-top:110px;background-color:rgba(49, 45, 45, 0.28);border-color:rgba(49, 45, 45, 0.28);">
	 		<div class="panel-body" style="background-color:transparent;">
	 			<h1>Welcome</h1>
	 			<p>Please enter your credentials to vote.</p>
	  			<form class="form-horizontal" role="form" style="padding-top:20px;">
					  <div class="form-group">
					      <label class="control-label col-sm-3" for="" style="padding-right:16px;">Passcode:</label>
					    <div class="col-sm-9">
					      <input  class="form-control" id="" placeholder="Enter passcode" style="background-color:rgba(49, 45, 45, 0.28);outline-color:white;">
					  	</div>
			  		  </div>
			  		  <div class="form-group" >
			  			  <label for="sel1" class="col-sm-3" style="padding-left:4px;">Security Question:</label>
				          <div class="col-sm-9" >
							  <select class="form-control" id="sel1" style="background-color:rgba(49, 45, 45, 0.28);outline-color:white;">
							    <option>1</option>
							    <option>2</option>
							    <option>3</option>
							    <option>4</option>
							  </select>
				         </div>
			          </div>
			          <div class="form-group">
			    		  <label class="control-label col-sm-3" for="" style="padding-right:16px;">Answer:</label>
			          	<div class="col-sm-9"> 
			      		  <input class="form-control" id="" placeholder="Enter the answer to your security question" style="background-color:rgba(49, 45, 45, 0.28);outline-color:white;color:white;">
			            </div>
			          </div>
					  <div class="form-group" style="padding-top:20px;"> 
					    <div class="col-sm-offset-4 col-sm-8" >
					      <button type="submit" class="btn btn-primary" style="font-size: 18px;" >Submit</button>
					    </div>
			  		  </div>
			    </form>
	  		</div>
		  </div>
		</div>
		<div class="col-md-3">
		    <br>
		</div>
		
		
	 </div>
<div class="login-box">
  <div class="login-box-body">
    <center>
      <img src='{{ URL::asset("assets/images/$logo") }}' style="max-width: 130px;">
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
    </div>
    <br><br>
         <form action='{{ URL::asset("survey/answer") }}' method="post">
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
            <br><br>
            <div class="row">
               <div class="col-md-6 col-md-offset-3">
               		<center>
                  		<button style="font-size:20px;" type="submit" class="btn btn-primary btn-block btn-flat">Start Voting</button>
                  	</center>	
                </div>
            </div>
    </form>

    <!-- <a href="#" style="color:white;">forgot password?</a><br> -->
>>>>>>> Stashed changes
  </div>
  <!-- /.form-box -->
<br>  
<center><p style="color:white;">Powered by iVote++</p></center>
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
