<?php
$image = "https://s3.amazonaws.com/ndap-ivote-2017/settings/".$set->txtSetLogo."";
?>

<!DOCTYPE html>
<html>
	<link rel="stylesheet" href="{{ URL::asset('assets/bootstrap/css/bootstrap.min.css') }}">
  	<link rel="stylesheet" href="{{ URL::asset('assets/bootstrap/css/font-awesome.css') }}">
  	<link rel="stylesheet" href="{{ URL::asset('assets/bootstrap/css/ionicons.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/iCheck/all.css') }}">
  	<link rel="stylesheet" href="{{ URL::asset('assets/dist/css/AdminLTE.min.css') }}">
  	<link rel="stylesheet" href="{{ URL::asset('assets/dist/css/skins/_all-skins.min.css') }}">
  	<link rel="stylesheet" href="{{ URL::asset('assets/flipclockcss/flipclock.css') }}">


<head></head>

<style type="text/css">
	body{
		background-image: url(assets/images/bgCount.png)
	}

	.flip-clock-divider .flip-clock-label {
	    font-size: 20px;
	    color: white;
	    font-family: Raleway, Helvetica, Arial, Sans-Serif;
	    text-align: center;
}
	a:hover {
		border-color: black;
		background-color: rgba(110, 193, 252, 0.5) !important;;
		color: white !important;;
	}
	
	.wrapper {
		padding:20px;
	}

</style>

<body>
<div class="wrapper">
<div class="container">
<div class="row">
 
	<center><img src="assets/images/countpic.png" style="width:70%;"></center>
	
	<div class="col-md-offset-2 col-md-10  col-xs-12" style="padding-left: 80px;padding-top:50px" >
	<div class="clock flip-clock-wrapper" >
		<span class="flip-clock-divider days" >
			<span class="flip-clock-label" >Days</span>
		</span>
		<ul class="flip ">
			<li class="flip-clock-before">
				<a href="#">
					<div class="up">
						<div class="shadow"></div>
						<div class="inn">9<</div>
					</div>
					<div class="down">
						<div class="shadow"></div>
						<div class="inn">9</div>
					</div>
				</a>
			</li>
			<li class="flip-clock-active">
				<a href="#">
					<div class="up">
						<div class="shadow"></div>
						<div class="inn">0</div>
					</div>
					<div class="down">
						<div class="shadow"></div>
						<div class="inn">0</div>
					</div>
				</a>
			</li>
		</ul>
		<ul class="flip ">
			<li class="flip-clock-before">
				<a href="#">
					<div class="up">
						<div class="shadow"></div>
						<div class="inn">0</div>
					</div>
					<div class="down">
						<div class="shadow"></div>
						<div class="inn">0</div>
					</div>
				</a>
			</li>
			<li class="flip-clock-active">
				<a href="#">
					<div class="up">
						<div class="shadow"></div>
						<div class="inn">2</div>
					</div>
					<div class="down">
						<div class="shadow"></div>
						<div class="inn">2</div>
					</div>
				</a>
		    </li>
		</ul>
		<span class="flip-clock-divider hours">
			<span class="flip-clock-label">Hours</span>
				<span class="flip-clock-dot top"></span>
				<span class="flip-clock-dot bottom"></span>
			</span>
		<ul class="flip ">
			<li class="flip-clock-before">
				<a href="#">
					<div class="up">
						<div class="shadow"></div>
						<div class="inn">0</div>
					</div>
					<div class="down">
						<div class="shadow"></div>
						<div class="inn">0</div>
					</div>
				</a>
			</li>
			<li class="flip-clock-active">
				<a href="#">
					<div class="up">
						<div class="shadow"></div>
						<div class="inn">1</div>
					</div>
					<div class="down">
						<div class="shadow"></div>
						<div class="inn">1</div>
					</div>
				</a>
			</li>
		</ul>
		<ul class="flip ">
			<li class="flip-clock-before">
				<a href="#">
					<div class="up">
						<div class="shadow"></div>
							<div class="inn">0</div>
					</div>
					<div class="down">
						<div class="shadow"></div>
						<div class="inn">0</div>
					</div>
				</a>
			</li>
			<li class="flip-clock-active">
				<a href="#">
					<div class="up">
						<div class="shadow"></div>
						<div class="inn">3</div>
					</div>
					<div class="down">
						<div class="shadow"></div>
						<div class="inn">3</div>
					</div>
				</a>
			</li>
		</ul>
		<span class="flip-clock-divider minutes">
			<span class="flip-clock-label">Minutes</span>
				<span class="flip-clock-dot top"></span>
				<span class="flip-clock-dot bottom"></span>
			</span>
			<ul class="flip  play">
				<li class="flip-clock-before">
					<a href="#">
						<div class="up">
							<div class="shadow"></div>
							<div class="inn">1</div>
						</div>
						<div class="down">
							<div class="shadow"></div>
							<div class="inn">1</div>
						</div>
					</a>
				</li>
				<li class="flip-clock-active">
					<a href="#">
						<div class="up">
							<div class="shadow"></div>
							<div class="inn">0</div>
						</div>
						<div class="down">
							<div class="shadow"></div>
							<div class="inn">0</div>
						</div>
					</a>
				</li>
			</ul>
			<ul class="flip  play">
				<li class="flip-clock-before">
					<a href="#">
						<div class="up">
							<div class="shadow"></div>
							<div class="inn">0</div>
						</div>
						<div class="down">
							<div class="shadow"></div>
							<div class="inn">0</div>
						</div>
					</a>
				</li>
				<li class="flip-clock-active">
					<a href="#">
						<div class="up">
							<div class="shadow"></div>
							<div class="inn">0</div>
						</div>
						<div class="down">
							<div class="shadow"></div>
							<div class="inn">0</div>
						</div>
					</a>
				</li>
			</ul>
			<span class="flip-clock-divider seconds">
				<span class="flip-clock-label">Seconds</span>
				<span class="flip-clock-dot top"></span>
				<span class="flip-clock-dot bottom"></span>
			</span>
			<ul class="flip  play">
				<li class="flip-clock-before">
					<a href="#">
						<div class="up">
							<div class="shadow"></div>
							<div class="inn">2</div>
						</div>
						<div class="down">
							<div class="shadow"></div>
							<div class="inn">2</div>
						</div>
					</a>
				</li>
				<li class="flip-clock-active">
					<a href="#">
						<div class="up">
							<div class="shadow"></div>
							<div class="inn">1</div>
						</div>
						<div class="down">
							<div class="shadow"></div>
							<div class="inn">1</div>
							</div>
						</a>
					</li>
				</ul>
				<ul class="flip  play">
					<li class="flip-clock-before">
						<a href="#">
							<div class="up">
								<div class="shadow"></div>
								<div class="inn">1</div>
							</div>
							<div class="down">
								<div class="shadow"></div>
								<div class="inn">1</div>
							</div>
						</a>
					</li>
					<li class="flip-clock-active">
						<a href="#">
							<div class="up">
								<div class="shadow"></div>
								<div class="inn">0</div>
							</div>
							<div class="down">
								<div class="shadow"></div>
								<div class="inn">0</div>
							</div>
						</a>
					</li>
				</ul>
			</div>
	
	<div class="row">
	<div class="col-md-2 col-xs-2"> <br></div>
	<div class="  col-md-3 col-xs-4" style="padding-top:20px;padding-left: 60px; ">
		<a class="btn " href="{{ URL::to('/candidates/page')}}" style="font-size: 18px;background-color:rgba(235, 246, 255, 0.3);color:white;" >&nbsp&nbsp&nbspClick here for Campaign Page&nbsp&nbsp&nbsp&nbsp&nbsp</a>
	</div>
	<div class="col-md-3 col-xs-6"><br></div>
	</div>
    <div class="row">
    <div class="col-md-12 col-xs-12">
        <div class="col-md-3 col-xs-4">
            <img class="img-responsive" src="assets/images/ivote4.png" style="padding:53px" >
        </div>
        <div class="col-md-3 col-xs-4">
            <center>
            <p style="font-size: 12px; padding-top: 70px;color: white"> Copyright © 2015-2016 iVote++<br>All rights reserved.</p>
            <center>
        </div>
        <div class="col-md-3 col-xs-4">
            <img class="img-responsive"  src="{{$image}}" style="padding:53px" >
        </div>
    </div>
    </div>
        
    
	</div>

	</div>
	</div>

</div>
</div>
	
	
	


 





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
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="{{ URL::asset('assets/flipclockjs/flipclock.js')}}"></script>
<script src="{{ URL::asset('assets/flipclockjs/flipclock.min.js')}}"></script>
<script type="text/javascript">

var clock = $('.clock').FlipClock({{$day}}, {
		clockFace: 'DailyCounter',
		countdown: true,
		stop: function () {
	        window.location.href = "/"
	    }
	}); 
</script>


</html>