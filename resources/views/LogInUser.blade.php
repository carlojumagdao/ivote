<!DOCTYPE html>
<html>
	<link rel="stylesheet" href="{{ URL::asset('assets/bootstrap/css/bootstrap.min.css') }}">
  	<link rel="stylesheet" href="{{ URL::asset('assets/bootstrap/css/font-awesome.css') }}">
  	<link rel="stylesheet" href="{{ URL::asset('assets/bootstrap/css/ionicons.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/iCheck/all.css') }}">
  	<link rel="stylesheet" href="{{ URL::asset('assets/dist/css/AdminLTE.min.css') }}">
  	<link rel="stylesheet" href="{{ URL::asset('assets/dist/css/skins/_all-skins.min.css') }}">


<head>
	<title></title>
</head>

<style type="text/css">
	body  {
	    background-image: url(assets/images/bglogin.png);
	    background-color: 	#2F4F4F;
}

	h1	{
		padding-top: 5px;
		margin-left: 30px;
		color: #f5c012;
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
		font-size: 18px;
		
		color: white;
		
		transition-duration: 0.25s;
		font-weight: 300;
		
		&:hover{
			background-color: fade(white, 40%);
		}
		
		&:focus{
			background-color: white;
			width: 300px;
			
			color: @prim;
	}
	
</style>


<body>

  <div class="wrapper">
	<div class="container">
		


	  <div class="col-md-3">
		<br>
	  </div>
	  <div class="col-md-6">
		  <div class="panel panel-default" style="margin-top:110px;">
	 		<div class="panel-body" style="background-color:transparent;">
	 			<h1>Welcome</h1>
	 			<p>Please enter your credentials to vote.</p>
	  			<form class="form-horizontal" role="form" style="padding-top:20px;">
					  <div class="form-group">
					      <label class="control-label col-sm-3" for="" style="padding-right:16px;">Passcode:</label>
					    <div class="col-sm-9">
					      <input  class="form-control" id="" placeholder="Enter passcode">
					  	</div>
			  		  </div>
			  		  <div class="form-group" >
			  			  <label for="sel1" class="col-sm-3" style="padding-left:4px;">Security Question:</label>
				          <div class="col-sm-9">
							  <select class="form-control" id="sel1">
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
			      		  <input class="form-control" id="" placeholder="Enter the answer to your security question">
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
	
	
  </div>




    
    
    
  

</body>


</body>

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


</html>