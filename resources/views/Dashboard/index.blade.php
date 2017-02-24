@extends('master')
@section('title')
    {{"Dashboard"}}
@stop   
@section('style')
    <style>
        #content{
            padding: 30px;
            height: 500;
            margin: 0 auto;
            display: flex;
            justify-content: center;
            resize: both;
            overflow: hidden;
            flex-wrap: nowrap;
            align-items: flex-start;
            width:2000;
        }
        .modal-body {
            position: relative;
            overflow-y: auto;
            max-height: 800px;
            width:2000;
        }
        .modal-content{
            position: relative;
            max-height: 1000px;
            width:3000;
        }
    </style>
@stop
@section('content')
<!-- START CONTENT -->
    @section('title-page')
        {{"Dashboard"}}
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
    <?php
            $convertDateStart = date('l F j, Y', strtotime($start));
            $convertDateEnd = date('l F j, Y', strtotime($end));
            $pieces = explode(" ", $start);
            $timeStart = date('h:i A',strtotime($pieces[1]));//convert to user readable -start
                // $startDate =  "$pieces[1]/$pieces[2]/$pieces[0]";
                // $piece2 = explode("-",$datEnd);
                // $endDate = "$piece2[1]/$piece2[2]/$piece2[0]";
                // $timeStart = $startdatetime[1].$startdatetime[2];
            $pieces2 = explode(" ",$end);
            $timeEnd = date('h:i A',strtotime($pieces2[1]));
            $startDate = explode("-",$pieces[0]);
            $endDate = explode("-", $pieces2[0]);
            $finalstartdate = "$startDate[1]/$startDate[2]/$startDate[0] $timeStart-$endDate[1]/$endDate[2]/$endDate[0] $timeEnd";
                // $finalstarttime = "$timeStart"; 
        ?>
    <div class="col-md-12">
        <div class="col-lg-3 col-xs-6" id="position">
            <div class="panel" style="border-left:8px solid #FF6384;color:#FF6384; cursor:pointer" data-toggle="modal" data-target="#viewPosition">   
                <div class="panel-body">
                    <div class="info-box-number text-center" style="font-size:70px;" > {{$TotalPosition}}</div>
                    <div class="info-box-text text-center" style="font-size:130%">Positions</div>
                </div>
            </div>
            <div class="panel" style="border-left:8px solid #4BC0C0;color:#4BC0C0; cursor:pointer" data-toggle="modal" data-target="#viewVoted">
                <div class="panel-body">  
                    <div class="info-box-number text-center" style="font-size:70px">{{$TotalVoted}}</div>
                    <div class="info-box-text text-center" style="font-size:130%">Voted</div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-body"><strong>Start:</strong> {{$convertDateStart}}<br>{{$timeStart}}</div>    
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="panel" style="border-left:8px solid #FFCE56;color:#FFCE56; cursor:pointer" data-toggle="modal" data-target="#viewCandidate">
                <div class="panel-body"> 
                    <div class="info-box-number text-center" style="font-size:70px">{{$TotalCandidate}}</div>
                    <div class="info-box-text text-center" style="font-size:130%">Candidates</div>
                </div>
            </div>
            <div class="panel" style="border-left:8px solid #36A2EB;color:#36A2EB; cursor:pointer">
                <div class="panel-body">  
                    <a href="{{ URL::to('/member') }}" class="info-box-number text-center" style="font-size:70px;color:#36A2EB;" >{{$TotalVoter}}</a>
                    <div class="info-box-text text-center" style="font-size:130%">Members</div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-body"><strong>End: </strong>{{$convertDateEnd}}<br>{{$timeEnd}}</div>  
            </div> 
        </div>
        <div class="col-md-6 col-xs-6">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="chart">
                    <canvas id="Chart" height="269px"></canvas>
                    </div>
                </div>    
            </div> 
        </div>   
        @foreach($DynFields as $DynField)
        <div class="col-md-6 col-xs-6">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="chart">
                    <canvas id="{{$DynField->intDynFieldId}}" height="200px"></canvas>
                    </div>
                </div>    
            </div> 
        </div>  
        @endforeach     
    </div>

    <div class="modal fade" id="viewPosition" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">List of Positions</h4>
                    </div>
                <div class="modal-body">
                    <?php
                        $formDesign = DB::table('tblSetting')->select('strHeader','txtSetLogo','strSetElecName','strSetAddress')->get();
                        foreach ($formDesign as $design) {
                            $org = $design->strHeader;
                            $logo = $design->txtSetLogo;
                            $election = $design->strSetElecName;
                            $address = $design->strSetAddress;
                        }
                        $Positions = DB::table('tblposition')->where('blPosDelete', '=', 0)->get();
                    ?>
                    <center>
                        <img src='{{ URL::asset("assets/images/$logo") }}' style="max-width: 200px;">
                        <br>
                        <h3>{{$election}}</h3>
                        <h4>{{$org}}</h4>
                        <h5>{{$address}}</h5>
                    </center>
                    <div id="content">
                        <div class="col-md-12" >
                            <ul class="list-group list-group-unbordered">
                                <h3 class="list-group-item-heading with-border">Position <a class="pull-right">Vote Limit</a></h3>
                                @foreach($Positions as $value)
                                    <li class="list-group-item">
                                        <b>{{$value->strPosName}}</b>
                                        <a class="pull-right">{{$value->intPosVoteLimit}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>    

    <div class="modal fade" id="viewCandidate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">List of Candidates</h4>
                    </div>
                <div class="modal-body" style="padding:40px">
                    <center>
                        <img src='{{ URL::asset("assets/images/$logo") }}' style="max-width: 200px;">
                        <br>
                        <h3>{{$election}}</h3>
                        <h4>{{$org}}</h4>
                        <h5>{{$address}}</h5>
                    </center>
                    <?php
                        $party = DB::table('tblSetting')->where('blSetParty', '=', 1)->get();
                        $formDesign = DB::table('tblSetting')->select('strHeader','txtSetLogo','strSetElecName','strSetAddress')->get();
                        foreach ($formDesign as $design) {
                            $org = $design->strHeader;
                            $logo = $design->txtSetLogo;
                            $election = $design->strSetElecName;
                            $address = $design->strSetAddress;
                        }
                        if($party){
                            
                            $partylist = DB::table('tblcandidate')
                                            ->distinct()
                                            ->join('tblparty', 'tblcandidate.intCandParId', '=', 'tblparty.intPartyId')
                                            ->where('blCandDelete', '=', 0)
                                            ->select('tblcandidate.intCandParId','tblparty.strPartyName', 'tblparty.strPartyColor')
                                            ->get();
                            $positions = DB::table('tblcandidate')
                                            ->join('tblposition', 'strPositionId', '=', 'strCandPosId')
                                            ->select('strCandPosId', 'strPosName')
                                            ->where('blPosDelete', '=', '0')
                                            ->distinct()
                                            ->get();
                            $candidates = DB::table('tblcandidate')
                                            ->join('tblmember', 'tblcandidate.strCandMemId', '=', 'tblmember.strMemberId')
                                            ->where('blCandDelete', '=', 0)
                                            ->select('tblcandidate.*', 'tblmember.strMemFname', 'tblmember.strMemLname')
                                            ->get();
                            ?>
                            <ul class="users-list clearfix">
                                @foreach($partylist as $party)
                                    <div class="col-md-12 row panel" style="border-left: 4px solid {{$party->strPartyColor}}; background-color:#eee">
                                        <div class="col-md-12">
                                            <h3>{{$party->strPartyName}}</h3>
                                            @foreach($positions as $position)
                                                @foreach($candidates as $candidate)
                                                    @if($candidate->strCandPosId == $position->strCandPosId )
                                                    @if($candidate->intCandParId == $party->intCandParId)
                                                     <div class="col-md-4">
                                                        <li>
                                                            <center>
                                                                <?php $image = "https://s3.amazonaws.com/ndap-ivote-2017/candidates/".$candidate->txtCandPic."";
                                                                ?>
                                                                <img class="img-circle" height="100" width="100" id="cand-pic" src="{{$image}}">
                                                                <a class="users-list-name">{{$candidate->strMemFname}} {{$candidate->strMemLname}}</a>
                                                                <span class="users-list-position">{{$position->strPosName}}</span>
                                                            </center>
                                                        </li>
                                                    </div>
                                                    @endif
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </ul>
                        <?php
                        }
                        else {
                                $positions = DB::table('tblcandidate')
                                                ->join('tblposition', 'strPositionId', '=', 'strCandPosId')
                                                ->select('strCandPosId', 'strPosName')
                                                ->where('blPosDelete', '=', '0')
                                                ->distinct()
                                                ->get();
                                $candidates = DB::table('tblcandidate')
                                                ->join('tblmember', 'tblcandidate.strCandMemId', '=', 'tblmember.strMemberId')
                                                ->where('blCandDelete', '=', 0)
                                                ->select('tblcandidate.*', 'tblmember.strMemFname', 'tblmember.strMemLname')
                                                ->get();
                            ?>
                            <ul class="users-list clearfix">
                                    @foreach($positions as $position)
                                        <div class="col-md-12 box border-style=none" > 
                                            <div class="box-header with-border">
                                                <h3 class="box-title">{{$position->strPosName}}</h3>
                                            </div>
                                            <div class="box-body">
                                                @foreach($candidates as $candidate)
                                                    @if($candidate->strCandPosId == $position->strCandPosId)
                                                        <div class="col-md-4">
                                                            <li>
                                                                <center>
                                                                    <?php $image = "https://s3.amazonaws.com/ndap-ivote-2017/candidates/".$candidate->txtCandPic."";
                                                                    ?>
                                                                    <img class="img-circle" height="100" width="100" id="cand-pic" src="{{$image}}">
                                                                    <a class="users-list-name">{{$candidate->strMemFname}} {{$candidate->strMemLname}}</a>
                                                                    <span class="users-list-position">{{$position->strPosName}}</span>
                                                                </center>
                                                            </li>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                            </ul>
                        <?php
                        }
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>    

    <div class="modal fade" id="viewVoter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">List of Voters</h4>
                    </div>
                <div class="modal-body">
                    <?php
                        $Members = DB::table('tblMember')->where('blMemDelete', '=', 0)->where('blMemCodeSendStat', '=', 1)->get();
                        $formDesign = DB::table('tblSetting')->select('strHeader','txtSetLogo','strSetElecName','strSetAddress')->get();
                        foreach ($formDesign as $design) {
                            $org = $design->strHeader;
                            $logo = $design->txtSetLogo;
                            $election = $design->strSetElecName;
                            $address = $design->strSetAddress;
                        }
                    ?>
                    <center>
                        <img src='{{ URL::asset("assets/images/$logo") }}' style="max-width: 200px;">
                        <br>
                        <h3>{{$election}}</h3>
                        <h4>{{$org}}</h4>
                        <h5>{{$address}}</h5>
                    </center>
                    <div id="content">
                        <div class="col-md-12" >
                            <ul class="list-group list-group-unbordered">
                                <h3 class="list-group-item-heading with-border">Voter ID <a class="pull-right">Voter Name</a></h3>
                                @foreach($Members as $member)
                                    <li class="list-group-item">
                                        <b>{{$member->strMemberId}}</b> 
                                        <a class="pull-right">{{$member->strMemFname}} {{$member->strMemLname}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>     

    <div class="modal fade" id="viewVoted" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">List of Voters</h4>
                    </div>
                <div class="modal-body">
                    <?php
                        $formDesign = DB::table('tblSetting')->select('strHeader','txtSetLogo','strSetElecName','strSetAddress')->get();
                        foreach ($formDesign as $design) {
                            $org = $design->strHeader;
                            $logo = $design->txtSetLogo;
                            $election = $design->strSetElecName;
                            $address = $design->strSetAddress;
                        }
                        $members = DB::table('tblvoteheader')
                                            ->join('tblmember', 'tblvoteheader.strVHMemId', '=', 'tblmember.strMemberId')
                                            ->select('tblvoteheader.*', 'tblmember.strMemFname', 'tblmember.strMemLname')
                                            ->get();
                    ?>
                    <center>
                        <img src='{{ URL::asset("assets/images/$logo") }}' style="max-width: 200px;">
                        <br>
                        <h3>{{$election}}</h3>
                        <h4>{{$org}}</h4>
                        <h5>{{$address}}</h5>
                    </center>
                    <div id="content">
                        <div class="col-md-12" >
                            <ul class="list-group list-group-unbordered">
                                <h3 class="list-group-item-heading with-border">Voter ID <a class="pull-right">Voter Name</a></h3>
                                @foreach($members as $member)
                                    <li class="list-group-item">
                                        <b>{{$member->strVHMemId}}</b> 
                                        <a class="pull-right">{{$member->strMemFname}} {{$member->strMemLname}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>     
@stop 
@section('script')
<script src="{{ URL::asset('assets/plugins/chartJS2/Chart.min.js') }}"></script>
<script>
    function getRandomColor() {
        var letters = '0123456789ABCDEF'.split('');
        var color = '#';
        for (var i = 0; i < 6; i++ ) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }
    $(function () {
        var data = {
            labels: [
                @foreach($candno as $value)
                "{{$value->strPosName}}",
                @endforeach
            ],
            datasets: [
                {
                    data: [
                        @foreach($candno as $value)
                            {{$value->Total}},
                        @endforeach
                    ],
                    backgroundColor: [
                        @foreach($candno as $value)
                            "{{$value->strPosColor}}",
                        @endforeach
                    ]
                }]
        };
        
         var options = {
            legend:{
                position: "bottom",
            },
            title: {
                display: true,
                text: 'Candidates per Position',
                fontSize: 18,
            },
            segmentShowStroke: true,
            segmentStrokeColor: "#fff",
            segmentStrokeWidth: 2,
            percentageInnerCutout: 50, // This is 0 for Pie charts
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
                    this.chart.ctx.font="18px Verdana";     
                    this.data.datasets.forEach(function (dataset) {
                        for (var i = 0; i < dataset.data.length; i++) {
                            var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model;
                            var total = dataset.data[i];
                            mid_radius = model.innerRadius + (model.outerRadius - model.innerRadius)/2,
                              start_angle = model.startAngle,
                              end_angle = model.endAngle,
                              mid_angle = start_angle + (end_angle - start_angle)/2;

                          var x = mid_radius * Math.cos(mid_angle);
                          var y = mid_radius * Math.sin(mid_angle);
                          var percent = String(Math.round(dataset.data[i]/total*100)) + "%";
                          ctx.fillText(total, model.x + x, model.y + y + 15);
                        }
                    });
                }
            } 
           
         };
                 
        var pieChartCanvas = $("#Chart").get(0).getContext("2d");
        var pieChart = new Chart(pieChartCanvas, {
            type: 'pie',
            data: data,
            options: options
        });
    });
    @foreach($DynFields as $DynField)
            $(function () {
                var areaChartData = {
                    labels: [
                        @foreach($FieldData as $value)
                            @if($DynField->intDynFieldId == $value->intDynFieldId)
                                "{{$value->strMemDeFieldData}}",
                            @endif
                        @endforeach
                    ],
                    datasets: [{
                        label: "Partial Tally of votes",
                        backgroundColor: [
                            '#FFCE56',
                            '#4BC0C0',
                            '#FF6384',
                            '#36A2EB',
                            '#ff7a56',
                            '#56e5ff'
                        ],
                        borderWidth: 1, 
                        barPercentage: 1,
                        data: [
                            @foreach($FieldData as $value)
                                @if($DynField->intDynFieldId == $value->intDynFieldId)
                                    {{$value->Count}},
                                @endif
                            @endforeach
                        ]
                    }]
                };
                var totalValue = getTotalValue(areaChartData);
                var options = {
                    legend:{
                        position: "bottom",
                    },
                    title: {
                        display: true,
                        text: 'Member Distribution per {{ucwords(str_replace("_", " ", $DynField->strDynFieldName))}}',
                        fontSize: 15,
                    },
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
                var pieChartCanvas = $("#{{$DynField->intDynFieldId}}").get(0).getContext("2d");
                var pieChart = new Chart(pieChartCanvas, {
                    type: 'polarArea',
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
@stop