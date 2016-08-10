<div id="positionId">
    <select name="position" class="form-control select2" required>
        <option></option>
        @for($intCounter = 0; $intCounter < sizeof($arrPosAvail); $intCounter++)
        	<option value='{{$arrPosAvailId[$intCounter]}}'>{{$arrPosAvail[$intCounter]}}</option>
        @endfor
    </select>
</div>
<script src="{{ URL::asset('assets/plugins/select2/select2.full.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/colorpicker/bootstrap-colorpicker.min.js') }}"></script>
<script>
    $(".select2").select2();
    //Colorpicker
    $(".my-colorpicker1").colorpicker();
    //color picker with addon
    $(".my-colorpicker2").colorpicker();

</script>