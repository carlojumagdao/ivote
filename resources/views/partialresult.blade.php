<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta name="csrf_token" content="{{ csrf_token() }}" />
        <title>@yield('title', 'iVote++ | Result')</title>
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
        .box{
            box-shadow: 0 5px 5px rgba(0,0,0,0.1);
        }
        .wrapper{
            padding: 30px;
        }
        body{
            background-color: WhiteSmoke  ;
        }


    </style>
    <body>
        <div class="wrapper">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="pull-left header"><i class="fa fa-th"></i> Partial Result</li>
                    <li><a href="#tab_1" data-toggle="tab">Graphical</a></li>
                    <li class="active"><a href="#tab_2" data-toggle="tab">Tabular</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane" id="tab_1">
                        <div class="row">
                        @foreach($positions as $position)
                            <!-- Set the width of the column, if no. of candidates is > 6 or not -->
                            @foreach($candno as $value)
                                @if($position->strPositionId == $value->strPositionId)
                                    @if($value->Total < 6)
                                        <div class="col-lg-6 col-xs-12">
                                    @else
                                        <div class="col-lg-12 col-xs-12">
                                    @endif
                                @endif
                            @endforeach
                                <!-- Set the width of the column, if no. of candidates is > 6 or not -->
                                    <div class="box">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">{{$position->strPosName}}</h3>
                                            <div class="box-tools pull-right">
                                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                                </button>
                                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                            </div>
                                        </div>
                                        <div class="box-body">
                                            <div class="chart">
                                                <canvas id="{{$position->strPositionId}}" style="height:230px"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane active" id="tab_2">
                        <div class="row">
                        @foreach($positions as $position)
                        <div class="col-md-4">
                            <div class="box">
                                <div class="box-header with-border">
                                    <p class="box-title" style="color:#36A2EB;font-size:20px;font-weight:bold;">{{$position->strPosName}}</p>
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                                        <i class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body table-responsive no-padding">
                                    <table class="table table-hover">
                                    <tr>
                                        <th>Candidate Name</th>
                                        <th>No. of Votes</th>
                                    </tr>
                                    @foreach($tally as $candidate)
                                        <tr>
                                            @if($position->strCandPosId == $candidate->strCandPosId)
                                                <td><img src='{{ URL::asset("assets/images/$candidate->txtCandPic") }}' img class="img-circle" height="65" width="65" id="user-pic"> {{$candidate->fullname}}</td>
                                                <td style="padding:26px;">{{$candidate->votes}}</td>
                                            @endif
                                        </tr>
                                    @endforeach
                                    </table>
                                </div>
                            </div>
                        </div> 
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- BAR CHART -->

        <!-- jQuery 2.2.0 -->
        <script src="{{ URL::asset('assets/jquery/jquery.min.js') }}"></script>
        <script src="{{ URL::asset('assets/jquery/jquery-ui.min.js') }}"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="{{ URL::asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
        <!-- SlimScroll -->
        <script src="{{ URL::asset('assets/plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
        <script src="{{ URL::asset('assets/plugins/chartJS2/Chart.js') }}"></script>
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
        @foreach($positions as $position)
            $(function () {
                var areaChartData = {
                    labels: [
                        @foreach($tally as $candidate)
                            @if($position->strCandPosId == $candidate->strCandPosId)
                                "{{$candidate->fullname}}",
                            @endif
                        @endforeach
                    ],
                    datasets: [{
                        label: "Partial Tally of votes",
                        backgroundColor: [
                            @foreach($tally as $candidate)
                            @if($position->strCandPosId == $candidate->strCandPosId)
                                @if($candidate->strPartyColor == "")
                                "#000",
                                @else
                                "{{$candidate->strPartyColor}}",
                                @endif
                            @endif
                        @endforeach
                        ],
                        borderWidth: 1,
                        barPercentage: 1,
                        data: [
                            @foreach($tally as $candidate)
                                @if($position->strCandPosId == $candidate->strCandPosId)
                                    {{$candidate->votes}},
                                @endif
                            @endforeach
                        ]
                    }]
                };
                var totalValue = getTotalValue(areaChartData);
                var options = {
                    
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
                     scales: {
                        yAxes: [{
                            display: true,
                            ticks: {
                                beginAtZero: true,
                            }
                        }]
                    },
                     
                     //String - A legend template
                     /*legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"*/
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
                         
                var pieChartCanvas = $("#{{$position->strPositionId}}").get(0).getContext("2d");
                var pieChart = new Chart(pieChartCanvas, {
                    type: 'bar',
                    data: areaChartData,
                    options: options
                });
                function getTotalValue(arr) {
                    var total = 0;
                    for(var i=0; i<arr.length; i++)
                        total += arr[i].value;
                    return total;
                }
            });
        @endforeach
        </script>
        <script>
            var pusher = new Pusher('{{env("PUSHER_KEY")}}');
            // TODO: Subscribe to the channel
            var channel = pusher.subscribe('notifications');
            // TODO: Bind to the event and pass in the notification handler
            channel.bind('new-notification', function(data) {
                // do something with the event data
                var text = data.text;
                toastr.success(text, null, {"positionClass": "toast-bottom-left"});
                // var lala = new init();
                // lala.update();
                location.reload();
                // document.getElementById(text).click();
            });
        </script>
    </body>
</html>