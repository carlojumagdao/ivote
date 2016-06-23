@extends('master')
@section('title')
    {{"Member Form"}}
@stop   
@section('style')
<link href="{{ URL::asset('assets/form/dist/form-builder.min.css') }}" type="text/css" rel="stylesheet">
<link href="{{ URL::asset('assets/form/dist/form-render.min.css') }}" type="text/css" rel="stylesheet">
<style type="text/css">
  
 body {
  background: lightgrey;
}

form {
  max-width: 500px;
  margin:auto;
}

textarea.form-control {
  height:120px;
}
}
</style>
@stop
@section('content')
<!-- START CONTENT -->
    @section('title-page')
        {{"Add New Member"}}
    @stop  
    <!--start container-->
      @if ($errors->any())
          <ul>
              <blockquote class="error">
                  {!! implode('', $errors->all(
                      '<li>:message</li>'
                  )) !!}
              </blockquote>
          </ul>
      @endif
      @if (Session::has('message'))
          <div>
              <blockquote>{{ Session::get('message') }}</blockquote>
          </div>
      @endif
      <div class="col-md-8">
          <div class="box">
              <div class="box-header with-border">
                  <h3 class="box-title">Member form</h3>
                  <div class="box-tools pull-right">
                      <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                      <i class="fa fa-minus"></i></button>
                      <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                      <i class="fa fa-times"></i></button>
                  </div>
              </div>
              <div class="box-body">
                  <form action="{{ URL::to('form/build') }}" id="rendered-form" method="POST">
                  </form>
              </div>
              <div class="box-footer">
                This is footer
              </div>
          </div>
          <div class="hide" id="formData">{{$form}}</div>
      </div>
@stop 

@section('script')
<script src="{{ URL::asset('assets/memberform/jquery/jquery-ui.min.js') }}"></script>
<script src="{{ URL::asset('assets/form/dist/form-builder.min.js') }}"></script>
<script src="{{ URL::asset('assets/form/dist/form-render.min.js') }}"></script>
<script>
    jQuery(document).ready(function($) {
      var fbTemplate = document.getElementById('fb-template'),
        formContainer = document.getElementById('rendered-form'),
        formData = $("#formData").text();

      var formRenderOpts = {
        container: formContainer,
        formData: formData
      };

      $(formContainer).formRender(formRenderOpts);
    });
</script>
@stop