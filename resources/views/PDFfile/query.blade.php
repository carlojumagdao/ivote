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
    <center><h1>{{$title}}</h1></center>
    <br>
    <h5 style="text-align:right">as of {{date('D, M. d Y h:i a')}}</h5>
    <h3>{{number_format($percent, 2, '.', '')}}% of members</h3>
    <p><big>{{$count}}</big> out of {{$members}} members</p>
    <br>
    <table width="100%">
        <tr>
            <th>Member Id</th>
            <th>Full Name</th>
             @if($query%2!=0) <th>Date</th> @endif
        </tr>
        
                
               
        @foreach($list as $value)
        <tr>
            <td class="id">{{$value->strMemberId}}</td>
            <td class="name">{{$value->strMemFname.' '.$value->strMemLname}}</td>
            @if($query%2 != 0)
            <td class="date">@if($query <= 2){{date('D, M. d Y h:i a', strtotime($value->datSHAnswered))}} 
                                @else {{date('D, M. d Y h:i a', strtotime($value->datVHVoted))}} @endif </td>@endif
        </tr>
        @endforeach
    </table>
    <br>
    <br>
	 
	
    
        



</body>
</html>