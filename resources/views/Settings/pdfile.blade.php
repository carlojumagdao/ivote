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
						<td>{{$row->txtSetLogo}}</td>
						
					</tr>
				@endforeach
			</tbody>
		</table>



</body>
</html>