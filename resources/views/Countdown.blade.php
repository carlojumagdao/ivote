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
	    font-family: helvlight;
	    text-align: center;
}
	button:hover {
		border-color: black;
		background-color: white !important;;
		color:black !important;;
	}

</style>

<body>
<div class="wrapper">
<div class="container">
	<img src="assets/images/countpic.png" style="width:80%;padding-left:220px;">
	<div class="col-sm-offset-2 col-sm-10" style="padding-left:50px;">
	<div class="clock flip-clock-wrapper" style="margin:2em;">
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
	<div class="message"></div>

	<div class=" col-sm-offset-2 col-md-9" style="padding-left:50px;">
		<a class="btn " href="{{ URL::to('/candidates/page')}}" style="font-size: 18px;background-color:#498eeb;color:white;" >Click here for Campaign Page</a>
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

var clock = $('.clock').FlipClock(3600 * 24 * {{$day}}, {
		clockFace: 'DailyCounter',
		countdown: true
	}); 

</script>


</html>