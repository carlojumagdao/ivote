<!-- Ito yung dropdown ng Province, ilalagay mo sa value yung id(Primary Key) para walang duplicate-->
<!-- Yung value nitong Select yung mapupunta sa AJAX -->
<!-- example ng id: 10 --> 
<!-- example ng value: Rizal -->

<select name="Province" class="form-control select2" onchange="getCity()" id="provinceId" required> 
     <option></option>
     @foreach($Provinces as $Province)
     <option value='{{$Province->ProvinceId}}'>{{$Province->ProvinceName}}</option>
     @endforeach
 </select>



<!-- Ilalagay mo dito yung filtered na, na cities -->
<div class="col-md-10" id="cityId">
    <select name="city" class="form-control select2" required>
        <option></option>
        @foreach($Cities as $City)
        <option value='{{$City->CityId}}'>{{$City->CityName}}</option> 
        @endforeach
    </select>
</div>


<!-- ======================================JAVASCRIPT=========================================================== -->

<!-- JAVASCRIPT | AJAX -->
<script>
function getPosition() {
	// itong var id yung value ng napili sa select ng province
    var id = document.getElementById("provinceId").value;
    $.ajax({
        url: "{{ URL::to('province/filter') }}", // url to ng POST Method
        type:"POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
            if (token) {
                  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: { id : id },
        success:function(data){
            $( "#cityId" ).empty(); // tatangalin mo yung laman ng select (City)
            $( "#cityId" ).append(data); // ilalagay mo ung na query mong mga city.
        },error:function(){ 
            alert("Error: Please check your input.");
        }
    }); //end of ajax
}
</script>
<!-- JAVASCRIPT | AJAX -->



<!-- ======================================DATABASE=========================================================== -->


<!-- Yung id yung pinasa galing sa ajax  -->
$City = Select * FROM tblCity WHERE intProvinceId = $id


