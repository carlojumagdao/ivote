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
    <body>

        <!-- BAR CHART -->
        @foreach($positions as $position)
        <div class="col-lg-6">
            <div class="box box-success">
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
                        <canvas id="{{$position->strPosName}}" style="height:230px"></canvas>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        <!-- BAR CHART -->

        <!-- jQuery 2.2.0 -->
        <script src="{{ URL::asset('assets/jquery/jquery.min.js') }}"></script>
        <script src="{{ URL::asset('assets/jquery/jquery-ui.min.js') }}"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="{{ URL::asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
        <!-- SlimScroll -->
        <script src="{{ URL::asset('assets/plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
        <script src="{{ URL::asset('assets/plugins/chartJS/Chart.min.js')}}"></script>
        <!-- FastClick -->
        <script src="{{ URL::asset('assets/plugins/fastclick/fastclick.js')}}"></script>
        <!-- AdminLTE App -->
        <script src="{{ URL::asset('assets/dist/js/app.min.js')}}"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="{{ URL::asset('assets/dist/js/demo.js')}}"></script>
        <script src="{{ URL::asset('assets/toastr/toastr.min.js') }}"></script>
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
                        label: "Electronics",
                        fillColor: "rgba(210, 214, 222, 1)",
                        strokeColor: "rgba(210, 214, 222, 1)",
                        pointColor: "rgba(210, 214, 222, 1)",
                        pointStrokeColor: "#c1c7d1",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(220,220,220,1)",
                        data: [
                        @foreach($tally as $candidate)
                            @if($position->strCandPosId == $candidate->strCandPosId)
                                {{$candidate->votes}},
                            @endif
                        @endforeach
                        ]
                    }]
                };
                var barChartCanvas = $("#{{$position->strPosName}}").get(0).getContext("2d");
                var barChart = new Chart(barChartCanvas);
                var barChartData = areaChartData;
                barChartData.datasets[0].fillColor = "{{$position->strPosColor}}";
                barChartData.datasets[0].strokeColor = "{{$position->strPosColor}}";
                barChartData.datasets[0].pointColor = "{{$position->strPosColor}}";

                var barChartOptions = {
                    //Boolean - whether to make the chart responsive
                    responsive: true,
                    maintainAspectRatio: true
                };
                barChartOptions.datasetFill = false;
                barChart.Bar(barChartData, barChartOptions);
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