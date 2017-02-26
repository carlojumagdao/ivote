<!DOCTYPE html>
<html>
<head>
	<title>
	</title>

</head>
<body>

<style type="text/css">
    body{
        font-family: helvetica;
    }
	#contentTable {
        border-collapse: collapse;
        border: 1px solid #000;
        padding: 1%;
    }
    .ted {
        border: 1px solid #000;
    }
</style>
    
    <table width="100%">
        <tr height="10%">
            <td width="15%">
            <!-- <img class="img-left" src="assets/images/{{$txtSetLogo}}" style="max-width: 90px;"> -->
            </td>
            <td width="70%">
                <br>
                <p>
                    <span><center>{{$strHeader}} <br><span>{{$strAddress}}</span></center></span>
                </p>
            </td>
            <td width="15%">
                <!-- <img src="assets/images/systemlogo.png" style="max-width: 90px;"> -->
            </td>
        </tr>
    </table>
    <center><h1>Winners</h1></center>
    <br>
    <h5 style="text-align:right">as of {{date('D, M. d Y h:i a')}}</h5>
     @foreach($positions as $pos)
    <br>
                <h3>{{$pos->strPosName}}</h3>
    <br>        <?php $counter = 0;?>
    <table width="100%" id="contentTable">
        <tr>
            <!-- <th class="ted" width="10%"></th> -->
            <th class="ted">Last Name</th>
            <th class="ted">Vote Count</th>
            <th class="ted">Percentage</th>
        </tr>
        
                
               
                @foreach($tally as $cand)
                <!-- Apply any bg-* class to to the info-box to color it -->
                @if($pos->strCandPosId == $cand->strCandPosId)
                @if($pos->intPosVoteLimit > $counter)  
        <tr>
            <!-- <td class="ted"><img src="assets/images/{{$cand->txtCandPic}}" height="100px" width="100px"></td> -->
            <td class="ted">{{$cand->strMemLName}}, {{$cand->strMemFName}}</td>
            <td class="ted">{{$cand->votes}}</td>
            <td class="ted">@if($count!=0){{number_format(($cand->votes / $count )* 100, 2, '.', '')}}% of Votes
                            @else 0% of Votes
                            @endif</td>
            
        </tr>
        @endif
            <?php $counter++;?>
        @endif
        @endforeach
    </table>
    @endforeach
    <br>
    <br>
    <h3>Total Voters: {{$count}}</h3>
	 
	
    
        



</body>
</html>