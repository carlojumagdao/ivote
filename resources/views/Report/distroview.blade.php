@extends('master-notitle')
@section('title')
    {{"Vote Distribution"}}
@stop   
@section('style')
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/colorpicker/bootstrap-colorpicker.min.css') }}">
    
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/datatables/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/datatables/datatables-responsive/css/dataTables.responsive.css') }}">
    <style>
        .colorpicker {
            z-index: 9999 !important;
        }
    </style>
@stop
@section('content')
<!-- START CONTENT -->
    @section('title-page')
        {{"Vote Distribution"}}
    @stop  
    <!--start container-->
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
    
    <div class="col-md-12">
        <div class="box box-default collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">Vote Distribution: <span style="color:#36A2EB;font-size:20px;font-weight:bold;">{{ucwords($by)}}</span></h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body table-responsive">
                <form action="{{ URL::to('/viewDistro') }}" method="post">
                    <div class="col-md-2 ">
                        {!! Form::label( 'distro', 'References:' ) !!}
                    </div>
                    <div class="col-md-8">
                        <select name="distro" class="form-control select2" required>
                            <option></option>
                            @foreach($posdetail as $detail)
                            <option value="{{$detail->strDynFieldName}}">{{ucwords($detail->strDynFieldName)}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-2 ">
                    <input type="submit" class="btn btn-primary" name="btnSubmit" value="Submit">
                </div>
                </form>    
            </div>
            <div class="box-footer">
                Footer
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <!-- Custom Tabs -->
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab">Overall</a></li>
                    <li><a href="#tab_2" data-toggle="tab">Line</a></li>
                    <li><a href="#tab_3" data-toggle="tab">Individual</a></li>
                    <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Overall Distribution</h3>
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="chart">
                                        <canvas id="overallBar" style="height:230px"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_2">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Line Distribution</h3>
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="chart">
                                        <canvas id="overallLine" style="height:230px"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_3">
                            <div class="row">
                            @foreach($candidate as $cand)
                                <div class="col-lg-6">
                                    <div class="box">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">{{$cand->strMemFname}} {{$cand->strMemLname}}</h3>
                                            <div class="box-tools pull-right">
                                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="box-body">
                                            <div class="chart">
                                                <canvas id="{{$cand->strCandId}}" style="height:230px"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>       
                
@stop 
@section('script')
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip(); 
    });
</script>
<script> 
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
                reader.onload = function (e) {
                    $('#cand-pic1')
                    .attr('src', e.target.result)
                    .width(150)
                    .height(150);
                };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<script src="{{ URL::asset('assets/datatables/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/datatables/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
                responsive: true
        });
    });
</script>
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip(); 
    });
</script>
<script src="{{ URL::asset('assets/plugins/select2/select2.full.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/colorpicker/bootstrap-colorpicker.min.js') }}"></script>
<script>
    //Colorpicker
    $(".my-colorpicker1").colorpicker();
    //color picker with addon
    $(".my-colorpicker2").colorpicker();

</script>
<script src="{{ URL::asset('assets/plugins/chartJS2/Chart.min.js') }}"></script>
<script>
    
    @foreach($candidate as $cand)
    $(function () {
        var data = {
            labels: [
                @foreach($votedistro as $dis)
                @if($cand->strCandId == $dis->strCandId)
                    @if($dis->strMemDeFieldData == null) "unidentified",
                    @else "{{$dis->strMemDeFieldData}}",
                    @endif
                @endif
                @endforeach
            ],
            datasets: [
                {
                    data: [
                        @foreach($votedistro as $dis)
                        @if($cand->strCandId == $dis->strCandId)
                            {{$dis->count}},
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
                }]
        };
        
         var options = {
             segmentShowStroke: true,
             segmentStrokeColor: "#fff",
             segmentStrokeWidth: 2,
             percentageInnerCutout: 50, 
             animationSteps: 100,
             animationEasing: "easeOutBounce",
             animateRotate: true,
             animateScale: false,
             responsive: true,
             maintainAspectRatio: true,
             animation: {
                onComplete: function () {
                    // render the value of the chart above the bar
                    var ctx = this.chart.ctx;
                    ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal', Chart.defaults.global.defaultFontFamily);
                    ctx.textAlign = 'center';
                    ctx.fillStyle = 'black';
                    ctx.textBaseline = 'bottom'; 
                    this.chart.ctx.font="14px Verdana";     
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
                 
        var pieChartCanvas = $("#{{$cand->strCandId}}").get(0).getContext("2d");
        var pieChart = new Chart(pieChartCanvas, {
            type: 'doughnut',
            data: data,
            options: options
        });
    });
      @endforeach

      $(function () {
        
        function getLineRandomColor() {
            var color = ['rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'];
            $index = Math.floor(Math.random() * 6);  
            return color[$index];
        }            
        var data = {
            labels: [
                @foreach($candidate as $cand)
                    "{{$cand->strMemFname}} {{$cand->strMemLname}}",
                @endforeach
            ],
            datasets: [
                @foreach($posData as $value)
                {
                    data: [

                        @foreach($candidate as $cand)
                            <?php $intCounter = 0;?>
                            @foreach($votedistro as $dis)
                                @if($cand->strCandId == $dis->strCandId)
                                    @if($value->strMemDeFieldData == $dis->strMemDeFieldData)
                                        {{$dis->count}},
                                        <?php $intCounter++?>
                                    @endif
                                @endif
                            @endforeach
                            @if($intCounter == 0)
                                0,
                            @endif
                        @endforeach
                        
                    ],
                    label: "{{$value->strMemDeFieldData}}",
                    lineTension: 0.1,
                    backgroundColor: getLineRandomColor(),
                    borderCapStyle: 'butt',
                    borderDash: [],
                    fill: true,
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: "rgba(75,192,192,1)",
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(75,192,192,1)",
                    pointHoverBorderColor: "rgba(220,220,220,1)",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    spanGaps: false,
                },
                @endforeach
            ]
        };
        
         var options = {
            scales: {
                yAxes: [{
                    display: false,
                    
                }]
            },
             segmentShowStroke: true,
             segmentStrokeColor: "#fff",
             segmentStrokeWidth: 2,
             percentageInnerCutout: 50, 
             animationSteps: 100,
             animationEasing: "easeOutBounce",
             animateRotate: true,
             animateScale: false,
             responsive: true,
             maintainAspectRatio: true,
            
         };
                 
        var pieChartCanvas = $("#overallLine").get(0).getContext("2d");
        var pieChart = new Chart(pieChartCanvas, {
            type: 'line',
            data: data,
            options: options
        });
    });

    
    $(function () {
        function getRandomColor() {
                        var letters = '0123456789ABCDEF'.split('');
                        var color = '#';
                        for (var i = 0; i < 6; i++ ) {
                            color += letters[Math.floor(Math.random() * 16)];
                        }
                        return color;
                    }  
        var data = {
            labels: [
                @foreach($candidate as $cand)
                    "{{$cand->strMemFname}} {{$cand->strMemLname}}",
                @endforeach
            ],
            datasets: [
                @foreach($posData as $value)
                {
                    data: [

                        @foreach($candidate as $cand)
                            <?php $intCounter = 0;?>
                            @foreach($votedistro as $dis)
                                @if($cand->strCandId == $dis->strCandId)
                                    @if($value->strMemDeFieldData == $dis->strMemDeFieldData)
                                        {{$dis->count}},
                                        <?php $intCounter++?>
                                    @endif
                                @endif
                            @endforeach
                            @if($intCounter == 0)
                                0,
                            @endif
                        @endforeach
                        
                    ],
                    label: "{{$value->strMemDeFieldData}}",
                    lineTension: 0.1,
                    backgroundColor: getRandomColor(),
                    borderColor: "rgba(75,192,192,1)",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: "rgba(75,192,192,1)",
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(75,192,192,1)",
                    pointHoverBorderColor: "rgba(220,220,220,1)",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    spanGaps: false,
                },
                @endforeach
            ]
        };
        
         var options = {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true,
                        steps: 1,
                    }
                }]
            },
             segmentShowStroke: true,
             segmentStrokeColor: "#fff",
             segmentStrokeWidth: 2,
             percentageInnerCutout: 50, 
             animationSteps: 100,
             animationEasing: "easeOutBounce",
             animateRotate: true,
             animateScale: false,
             responsive: true,
             maintainAspectRatio: true,
             animation: {
                onComplete: function () {
                    // render the value of the chart above the bar
                    var ctx = this.chart.ctx;
                    ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal', Chart.defaults.global.defaultFontFamily);
                    ctx.textAlign = 'center';
                    ctx.fillStyle = 'black';
                    ctx.textBaseline = 'top'; 
                    this.chart.ctx.font="10px Verdana";     
                    this.data.datasets.forEach(function (dataset) {
                        for (var i = 0; i < dataset.data.length; i++) {
                            var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model;
                            var total = dataset.data.reduce(function(previousValue, currentValue, currentIndex, array) {
                                return previousValue + currentValue;
                            });
                            var value = Math.floor(((dataset.data[i]/total)*100)+0.5)+'%';
                            ctx.fillText(value, model.x, model.y - 11);
                        }
                    });
                }
            }
         };
                 
        var pieChartCanvas = $("#overallBar").get(0).getContext("2d");
        var pieChart = new Chart(pieChartCanvas, {
            type: 'bar',
            data: data,
            options: options
        });
    });
</script>

@stop