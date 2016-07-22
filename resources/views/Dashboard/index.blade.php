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
    <div class="col-md-12">
        <div class="col-lg-3 col-xs-6" id="position">
            <div class="panel" style="border-left:8px solid #2c8798;color:#2c8798; cursor:pointer" data-toggle="modal" data-target="#viewPosition">   
                <div class="panel-body">
                    <div class="info-box-number text-center" style="font-size:70px;" > {{$TotalPosition}}</div>
                    <div class="info-box-text text-center" style="font-size:130%">Positions</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="panel" style="border-left:8px solid #006400;color:#006400; cursor:pointer" data-toggle="modal" data-target="#viewCandidate">
                <div class="panel-body"> 
                    <div class="info-box-number text-center" style="font-size:70px">{{$TotalCandidate}}</div>
                    <div class="info-box-text text-center" style="font-size:130%">Candidates</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="panel" style="border-left:8px solid #b22222;color:#b22222; cursor:pointer">
                <div class="panel-body">  
                    <a href="{{ URL::to('/member') }}" class="info-box-number text-center" style="font-size:70px;color:#b22222;" >{{$TotalVoter}}</a>
                    <div class="info-box-text text-center" style="font-size:130%">Members</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="panel" style="border-left:8px solid #605ca8;color:#605ca8; cursor:pointer" data-toggle="modal" data-target="#viewVoted">
                <div class="panel-body">  
                    <div class="info-box-number text-center" style="font-size:70px">{{$TotalVoted}}</div>
                    <div class="info-box-text text-center" style="font-size:130%">Voted</div>
                </div>
            </div>
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
        <div class="col-md-3 col-xs-6">
            <div class="panel panel-default">
                <div class="panel-heading"><i class="glyphicon glyphicon-calendar"></i> Start Date and Time</div>
                <div class="panel-body">{{$convertDateStart}}<br>{{$timeStart}}</div>    
            </div>  
        </div>
        <div class="col-md-3 col-xs-6">
            <div class="panel panel-default">
                <div class="panel-heading"><i class="glyphicon glyphicon-calendar"></i> End Date and Time</div>
                <div class="panel-body">{{$convertDateEnd}}<br>{{$timeEnd}}</div>  
            </div>  
        </div>
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
                                                                <img class="img-circle" height="100" width="100" id="cand-pic" src="../assets/images/{{$candidate->txtCandPic}}">
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
                                                                    <img class="img-circle" height="100" width="100" id="cand-pic" src="../assets/images/{{$candidate->txtCandPic}}">
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
<script>

</script>


@stop