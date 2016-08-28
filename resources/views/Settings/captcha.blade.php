@extends('master')
@section('title')
    {{"General Settings"}}
@stop   
@section('style')
<link rel="stylesheet" href="{{ URL::asset('assets/plugins/daterangepicker/daterangepicker-bs3.css') }}">
<link rel="stylesheet" href="{{ URL::asset('assets/switch-css/bootstrap-switch.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('assets/plugins/timepicker/bootstrap-timepicker.min.css') }}">
<style>
    h3{
        margin: -10px;
    }
    .required:after{
        content: "*";
        color:red
    }
</style>
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
    
    <div class="col-md-6">
        {!! Form::open( array(
            'method' => 'post',
            'id' => 'form-add-setting',
            'action' => 'gensetController@recaptchaSave',
            'enctype' => 'multipart/form-data',
            'class' => 'col s12', 
            'novalidate' => 'novalidate'
        ) ) !!}
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Google reCaptcha Configuration</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                </div>
            </div>
           <div class="box-body">
               <div class="form-group col-md-12 :after">
                        {!! Form::label( 'sitekey', 'site key:', array(
                            'class' => 'required') ) !!}
                        {!! Form::text
                            ('sitekey', $txtSiteKey , array(
                            'id' => 'sitekey',
                            'placeholder' => "This will be the key from Google reCaptcha",
                            'name' => 'txtSiteKey',
                            'class' => 'form-control',
                            'required' => true,)) 
                        !!}  
               </div>
               <div class="form-group col-md-12 ">
                        {!! Form::label( 'secret', 'secret key:', array(
                            'class' => 'required') ) !!}
                        {!! Form::text
                            ('secret', $txtSecret , array(
                            'id' => 'secret',
                            'placeholder' => "This will be use for your reports",
                            'name' => 'txtSecret',
                            'class' => 'form-control',
                            'required' => true,)) 
                        !!}  
               </div>
               <div class="form-group col-md-6">
                   <input type="submit" name="btnGenSetSubmit" value="Save" class="btn btn-primary btn-block">

               </div>
               {!! Form::close() !!}
        </div>
    </div>
</div>
<div class="col-md-6">
        
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Google reCaptcha Instructions</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                </div>
            </div>
           <div class="box-body">
                <div class="row">
                    <div class="col-md-4"><img src="assets/images/captcha6.png" class="responsive" style="max-height:50px"></div>
                    <div class="col-md-1"><img src="assets/images/captcha5.png" class="responsive" style="max-height:45px"></div>
                    <div class="col-md-6"><span style="font-size:30px;color:red">reCAPTCHA</span>
                    </div>
               </div>
               <div class="col-md-12">
               <p>1) Sign in to Google</p>
               <p>2) visit <a href="https://www.google.com/recaptcha/intro/index.html" target="_blank">https://www.google.com/recaptcha/intro/index.html</a></p>
                   
               <p>3) Click Get reCaptcha on Menu</p>
                   <div class="col-md-12">
                    <img src="assets/images/captcha1.jpg" class="img-responsive">
                   </div>
               
               <p>4) Register your site in Google Recaptcha for the API. enter the name of your site in label field and all the domains used by your site in the domain field. Note: you can use the domain name paid like google.com or a specific ip address used by your site</p>
                   <div class="col-md-12">
                    <img src="assets/images/captcha2.jpg" class="img-responsive">
                   </div>
               <p>5) After registering, You'll able to see the site key and secret key. Copy and paste it to the this form on the left to get your reCaptcha working</p>
                   <div class="col-md-12">
                    <img src="assets/images/captcha3.jpg" class="img-responsive">
                   </div>
               <p>6) You can always manage your registered domain and keys by visiting again the google reCaptcha using your Google Account</p>
                   <div class="col-md-12">
                    <img src="assets/images/captcha4.jpg" class="img-responsive">
                   </div>
            </div>
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
          $('#daterange-btn span').html(start.format('MMMM D, YYYY')+'-'+end.format('MMMM D, YYYY'));
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
<script>$("[name='chkbxPublish']").bootstrapSwitch();
    $('.chkbxPublish').on('switchChange.bootstrapSwitch', function (event, state) {
        if(state){
            $( "#publish" ).val(1); 
        } else{
            $( "#publish" ).val(0);
        }
    });
</script>
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip(); 
    });
</script>
<script> 
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
                reader.onload = function (e) {
                    $('#cand-pic1')
                    .attr('src', e.target.result)
                    .width(150)
                    .height(150);
                };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

@stop