@extends('master')
@section('title')
    {{"General Settings"}}
@stop   
@section('style')
<link rel="stylesheet" href="{{ URL::asset('assets/plugins/daterangepicker/daterangepicker-bs3.css') }}">
<link rel="stylesheet" href="{{ URL::asset('assets/switch-css/bootstrap-switch.min.css') }}">
@stop
@section('content')
<!-- START CONTENT -->
    @section('title-page')
        {{"General Settings"}}
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
    <div class="col-md-7">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Election</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                {!! Form::open( array(
                    'method' => 'post',
                    'id' => 'form-add-setting',
                    'action' => 'gensetController@save',
                    'class' => 'col s12',
                ) ) !!}
                    <div class="form-group col-md-12 ">
                    {!! Form::label( 'ElectionTitle', 'Election Title:' ) !!}
                        {!! Form::text
                            ('ElectionTitle', $strElecName, array(
                            'id' => 'ElectionTitle',
                            'placeholder' => 'PUP Faculty National Election',
                            'name' => 'txtElectionTitle',
                            'class' => 'form-control',
                            'required' => true,)) 
                        !!}
                        
                    </div>
                    <div class="form-group col-md-12 ">
                        {!! Form::label( 'ElectionDesc', 'Election Description:' ) !!}
                        {!! Form::textarea
                            ('ElectionDesc', $strElecDesc, array(
                            'id' => 'ElectionDesc',
                            'rows' => 12,
                            'class' => 'form-control',
                            'name' => 'txtElectionDesc',)) 
                        !!}
                    </div>
            </div>
            <div class="box-footer">
                Footer
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Schedule</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <label>Date Range</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" name="txtSchedule" class="form-control pull-right" id="reservation">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">System Controls</h3>
                
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body" style="margin-left:4%;margin-right:4%;">
                @if($blSurvey)
                    <?php $surveyStatus = "checked"; $survey = 1 ?>
                @else
                    <?php $surveyStatus = ""; $survey = 0?>
                @endif

                @if($blParty)
                    <?php $partyStatus = "checked"; $party = 1?>
                @else
                    <?php $partyStatus = ""; $party = 0?>
                @endif
                <div class="form-group" style="border-bottom:1px solid rgba(130, 116, 116, 0.1);; padding-bottom:4%;">
                    <input type="checkbox" name="chkbxSurvey" class="chkbxSurvey" {{$surveyStatus}} ><span style="margin-left:30%; font-size:15px;">Exit Poll Survey</span>
                    <input type="hidden" id="survey" name="txtSurveyStatus" value="{{$survey}}">
                </div>
                <div class="form-group">
                    <input type="checkbox" name="chkbxParty" class="chkbxParty" {{$partyStatus}} ><span style="margin-left:30%; font-size:15px;">Party Affiliation</span>
                    <input type="hidden" id="party" name="txtPartyStatus" value="{{$party}}">
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Save Changes?</h3>
                
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="form-group col-md-6">
                    <input type="submit" name="btnGenSetSubmit" value="Save" class="btn btn-primary btn-block">

                </div>
                <div class="form-group col-md-6">
                    <input type="submit" name="btnCancel" value="Cancel" class="btn btn-default btn-block">
                </div>
            {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop 

@section('script')
<script src="{{ URL::asset('assets/plugins/select2/select2.full.min.js') }}"></script>

<script src="{{ URL::asset('assets/plugins/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="{{ URL::asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('assets/switch-js/bootstrap-switch.min.js') }}"></script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $(".select2").select2();

    //Datemask dd/mm/yyyy
    $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    //Datemask2 mm/dd/yyyy
    $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
    //Money Euro
    $("[data-mask]").inputmask();

    //Date range picker
    $('#reservation').daterangepicker();
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'});
    //Date range as a button
    $('#daterange-btn').daterangepicker(
        {
          ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          startDate: moment().subtract(29, 'days'),
          endDate: moment()
        },
        function (start, end) {
          $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
    );

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    });

    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass: 'iradio_minimal-blue'
    });
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass: 'iradio_minimal-red'
    });
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass: 'iradio_flat-green'
    });

    //Colorpicker
    $(".my-colorpicker1").colorpicker();
    //color picker with addon
    $(".my-colorpicker2").colorpicker();

    //Timepicker
    $(".timepicker").timepicker({
      showInputs: false
    });
  });
</script>
<script>
    $.fn.bootstrapSwitch.defaults.offColor = 'danger';
    $("[name='chkbxSurvey']").bootstrapSwitch();
    $('.chkbxSurvey').on('switchChange.bootstrapSwitch', function (event, state) {
        if(state){
            $( "#survey" ).val(1); 
        } else{
            $( "#survey" ).val(0);
        }
    });
</script>
<script>$("[name='chkbxParty']").bootstrapSwitch();
    $('.chkbxParty').on('switchChange.bootstrapSwitch', function (event, state) {
        if(state){
            $( "#party" ).val(1); 
        } else{
            $( "#party" ).val(0);
        }
    });
</script>

@stop