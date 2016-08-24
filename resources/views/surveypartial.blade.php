<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta name="csrf_token" content="{{ csrf_token() }}" />
        <title>@yield('title', 'iVote++ | Survey Result')</title>
        <link rel="stylesheet" href="{{ URL::asset('assets/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('assets/bootstrap/css/font-awesome.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('assets/bootstrap/css/ionicons.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('assets/plugins/iCheck/all.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('assets/dist/css/AdminLTE.min.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('assets/dist/css/skins/_all-skins.min.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('assets/toastr/toastr.min.css') }}">
        <script src="//js.pusher.com/3.0/pusher.min.js"></script> <!-- download this -->
    </head>
    <script>
        // Added Pusher logging
        Pusher.log = function(msg) {
            console.log(msg);
        };
    </script>

     <style>
        .wrapper{
            padding: 30px;
        }
        body{
            background-color: WhiteSmoke  ;
        }
    </style>

    <body>
        <div class="wrapper">

        <h3 class="responsive-text" style="font-style:Helvetica;color:black;text-shadow: 2px 2px 8px rgba(217, 217, 217, 0.88);margin-left:15px;"> Partial Survey Result <h3>
        
        @foreach($SurveyQuestions as $SurveyQuestion)

        <?php

            $str = str_replace('_', ' ', strtolower($SurveyQuestion->strSQQuestion));
            $str = ucwords($str); 
        ?>

            @if(($SurveyQuestion->strSQQuesType == "element-single-line-text") || ($SurveyQuestion->strSQQuesType == "element-paragraph"))
                <div class="col-lg-6 col-xs-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{$str}}</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="chart">
                                <ul>
                                 @foreach($SurveyTally as $Answer)
                                    @if($SurveyQuestion->intSQId == $Answer->intSQId)
                                        <li style="font-size:16px;">{{$Answer->strSDAnswer}}</li>
                                    @endif
                                @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-lg-6 col-xs-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{$str}}</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="chart">
                                <canvas id="{{$SurveyQuestion->intSQId}}" style="height:230px"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
        <!-- BAR CHART -->

        <!-- jQuery 2.2.0 -->
        <script src="{{ URL::asset('assets/jquery/jquery.min.js') }}"></script>
        <script src="{{ URL::asset('assets/jquery/jquery-ui.min.js') }}"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="{{ URL::asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
        <!-- SlimScroll -->
        <script src="{{ URL::asset('assets/plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
        <script src="{{ URL::asset('assets/plugins/chartJS2/Chart.min.js')}}"></script>
        <!-- FastClick -->
        <script src="{{ URL::asset('assets/plugins/fastclick/fastclick.js')}}"></script>
        <!-- AdminLTE App -->
        <script src="{{ URL::asset('assets/dist/js/app.min.js')}}"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="{{ URL::asset('assets/dist/js/demo.js')}}"></script>
        <script src="{{ URL::asset('assets/toastr/toastr.min.js') }}"></script>
        <script src="{{ URL::asset('assets/responsivetext/jquery.responsivetext.js') }}"></script>
        <script type="text/javascript">
          $("body").responsiveText({
             bottomStop : '800',
             topStop    : '1400'
        });
        </script>
        <script>
        @foreach($SurveyQuestions as $SurveyQuestion)
            <?php $strQuestion = str_replace(' ', '', strtolower($SurveyQuestion->strSQQuestion)); ?>

            @if(($SurveyQuestion->strSQQuesType == "element-checkboxes") || ($SurveyQuestion->strSQQuesType == "element-dropdown"))
                $(function () {
                    function getRandomColor() {
                        var letters = '0123456789ABCDEF'.split('');
                        var color = '#';
                        for (var i = 0; i < 6; i++ ) {
                            color += letters[Math.floor(Math.random() * 16)];
                        }
                        return color;
                    }
                    
                    var colorBar = getRandomColor();
                    
                    var areaChartData = {
                        labels: [
                        @foreach($SurveyTally as $Answer)
                            @if($SurveyQuestion->intSQId == $Answer->intSQId)
                                "{{$Answer->strSDAnswer}}",
                            @endif
                        @endforeach
                        ],
                        datasets: [{
                            label: "Partial Result",
                            fillColor: "rgba(210, 214, 222, 1)",
                            strokeColor: "rgba(210, 214, 222, 1)",
                            pointColor: "rgba(210, 214, 222, 1)",
                            pointStrokeColor: "#c1c7d1",
                            pointHighlightFill: "#fff",
                            pointHighlightStroke: "rgba(220,220,220,1)",
                            backgroundColor: [
                                '#FFCE56',
                                '#4BC0C0',
                                '#FF6384',
                                '#36A2EB',
                                '#ff7a56',
                                '#56e5ff'
                            ],
                            borderColor: [
                                'rgba(255,99,132,1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            data: [
                                @foreach($SurveyTally as $Answer)
                                    @if($SurveyQuestion->intSQId == $Answer->intSQId)
                                        {{$Answer->Tally}},
                                    @endif
                                @endforeach
                            ]
                        }]
                    };
                    

                    var barChartOptions = {
                        //Boolean - whether to make the chart responsive
                        responsive: true,
                        maintainAspectRatio: true,
                        legend: {
                            display: true,
                            position: "top",
                            labels: {
                                fontColor: "black"
                            }
                        },
                        scales: {
                        yAxes: [{
                            display: true,
                            ticks: {
                                beginAtZero: true,
                            }
                        }]
                    },
                    animation: {
                        onComplete: function () {
                            // render the value of the chart above the bar
                            var ctx = this.chart.ctx;
                            ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal', Chart.defaults.global.defaultFontFamily);
                            ctx.textAlign = 'center';
                            ctx.fillStyle = 'black';
                            ctx.textBaseline = 'bottom'; 
                            this.chart.ctx.font="15px Verdana";     
                            this.data.datasets.forEach(function (dataset) {
                                for (var i = 0; i < dataset.data.length; i++) {
                                    var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model;
                                    var total = dataset.data.reduce(function(previousValue, currentValue, currentIndex, array) {
                                        return previousValue + currentValue;
                                    });
                                    var value = Math.floor(((dataset.data[i]/total)*100)+0.5)+'%';

                                    ctx.fillText(value, model.x, model.y - 5);
                                }
                            });
                        }
                    }
                    
                };
                    barChartOptions.datasetFill = false;
                  
                    var barChartCanvas = $("#{{$SurveyQuestion->intSQId}}").get(0).getContext("2d");
                    var barChartData = areaChartData;
                    barChartData.datasets[0].fillColor = getRandomColor();
                    var barChart = new Chart(barChartCanvas, {
                        type: 'bar',
                        data: barChartData,
                        options: barChartOptions
                    } );

                });
            @elseif($SurveyQuestion->strSQQuesType == "element-multiple-choice")
                $(function () {
                    function getRandomColor() {
                        var letters = '0123456789ABCDEF'.split('');
                        var color = '#';
                        for (var i = 0; i < 6; i++ ) {
                            color += letters[Math.floor(Math.random() * 16)];
                        }
                        return color;
                    }
                    
                    var PieData = {
                        labels: [
                           @foreach($SurveyTally as $Answer)
                            @if($SurveyQuestion->intSQId == $Answer->intSQId)
                                    "{{$Answer->strSDAnswer}}",
                            @endif
                            @endforeach 
                        ],
                        datasets:[
                            {
                                data: [
                                    @foreach($SurveyTally as $Answer)
                                    @if($SurveyQuestion->intSQId == $Answer->intSQId)
                                
                                       {{$Answer->Tally}},
                                    
                                    @endif
                                    @endforeach 
                                ],
                                backgroundColor: [
                                '#FFCE56',
                                '#4BC0C0',
                                '#FF6384',
                                '#36A2EB',
                                '#ff7a56',
                                '#56e5ff'
                            ],
                            }
                        ]
                    };
                            
                    var pieOptions = {
                      //Boolean - Whether we should show a stroke on each segment
                      segmentShowStroke: true,
                      //String - The colour of each segment stroke
                      segmentStrokeColor: "#fff",
                      //Number - The width of each segment stroke
                      segmentStrokeWidth: 2,
                      //Number - The percentage of the chart that we cut out of the middle
                      percentageInnerCutout: 50, // This is 0 for Pie charts
                      //Number - Amount of animation steps
                      animationSteps: 100,
                      //String - Animation easing effect
                      animationEasing: "easeOutBounce",
                      //Boolean - Whether we animate the rotation of the Doughnut
                      animateRotate: true,
                      //Boolean - Whether we animate scaling the Doughnut from the centre
                      animateScale: false,
                      //Boolean - whether to make the chart responsive to window resizing
                      responsive: true,
                      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
                      maintainAspectRatio: true,
                        animation: {
                            onComplete: function () {
                                // render the value of the chart above the bar
                                var ctx = this.chart.ctx;
                                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal', Chart.defaults.global.defaultFontFamily);
                                ctx.textAlign = 'center';
                                ctx.fillStyle = 'black';
                                ctx.textBaseline = 'bottom'; 
                                this.chart.ctx.font="15px Verdana";     
                                this.data.datasets.forEach(function (dataset) {
                                    for (var i = 0; i < dataset.data.length; i++) {
                                        var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model;
                                        var total = dataset.data.reduce(function(previousValue, currentValue, currentIndex, array) {
                                            return previousValue + currentValue;
                                        });
                                        mid_radius = model.innerRadius + (model.outerRadius - model.innerRadius)/2,
                                          start_angle = model.startAngle,
                                          end_angle = model.endAngle,
                                          mid_angle = start_angle + (end_angle - start_angle)/2;

                                      var x = mid_radius * Math.cos(mid_angle);
                                      var y = mid_radius * Math.sin(mid_angle);
                                      var percent = String(Math.round(dataset.data[i]/total*100)) + "%";
                                      ctx.fillText(percent, model.x + x, model.y + y + 15);
                                    }
                                });
                            }
                        }       
                    };
                    
                    var pieChartCanvas = $("#{{$SurveyQuestion->intSQId}}").get(0).getContext("2d");
                    var pieChart = new Chart(pieChartCanvas, {
                        type: 'doughnut',
                        data: PieData,
                        options: pieOptions
                    });
            
                    
                    //Create pie or douhnut chart
                    // You can switch between pie and douhnut using the method below.
                });
            @endif
        @endforeach
        </script>
    </body>
</html>