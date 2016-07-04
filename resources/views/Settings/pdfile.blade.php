<!DOCTYPE html>
<html>
<head>
	<title>
	</title>

</head>
<body>
	<table>
			<thead></thead>

			<tbody>
				@foreach($result as $row)
					<tr>
						<td>{{$row->strHeader}}</td>
						<td><img src="assets/images/{{$row->txtSetLogo}}" style="max-width: 200px"></td>
						
					</tr>
				@endforeach
			</tbody>
		</table>



</body>
</html>