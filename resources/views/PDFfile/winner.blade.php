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
	.img-left {

		float: left;
	}
    .img-right {

		float: right;
	}

	h4 {

		float: right;
		margin-left: 200px;
	}
    
    .td {
         border-bottom: 1px solid #ddd;
    }
    tr:nth-child(even) {background-color: #f2f2f2}
    th {
    background-color: #4CAF50;
    color: white;
    }
</style>
    
    <table width="100%">
        <tr height="10%">
            <td width="15%"><img class="img-left" src="assets/images/{{$txtSetLogo}}" style="max-width: 90px;"></td>
            <td width="70%">
                <br>
                <p>
        
                    <span style="font-size:20px;font-family:helvetica;"><center>{{$strHeader}} <br><span style="font-size: 12px">{{$strAddress}}</span></center></span>
                </p>
            </td>
            <td width="15%">
                <img src="assets/images/systemlogo.png" style="max-width: 90px;">
            </td>
        </tr>
    </table>
     @foreach($positions as $pos)
    <br>
                <h3>{{$pos->strPosName}}</h3>
    <br>        <?php $counter = 0;?>
    <table width="100%">
        <tr>
            <th class="td" width="10%"></th>
            <th class="td">Last Name</th>
            <th class="td">Vote Count</th>
            <th class="td">Percentage</th>
        </tr>
        
                
               
                @foreach($tally as $cand)
                <!-- Apply any bg-* class to to the info-box to color it -->
                @if($pos->strCandPosId == $cand->strCandPosId)
                @if($pos->intPosVoteLimit > $counter)  
        <tr>
            <td class="td"><img src="assets/images/{{$cand->txtCandPic}}" height="100px" width="100px"></td>
            <td class="td">{{$cand->strMemLName}}, {{$cand->strMemFName}}</td>
            <td class="td">{{$cand->votes}}</td>
            <td class="td">@if($count!=0){{($cand->votes / $count )* 100}}% of Votes
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