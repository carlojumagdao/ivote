@extends('master')
@section('title')
    {{"Member Form"}}
@stop   
@section('style')
<link href="{{ URL::asset('assets/css/style.css') }}" type="text/css" rel="stylesheet">
@stop
@section('content')
<!-- START CONTENT -->
    @section('title-page')
        {{"Member Form"}}
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
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Drag and Drop form</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div id="formBuilder"></div>
            </div>
            <div class="box-footer">
                Footer
            </div>
        </div>
    </div>
@stop 

@section('script')
<script src="{{ URL::asset('assets/memberform/jquery/jquery-ui.min.js') }}"></script>
<script src="{{ URL::asset('assets/memberform/src/libraries/dust-js/dust-core-0.3.0.min.js') }}"></script>
<script src="{{ URL::asset('assets/memberform/src/libraries/dust-js/dust-full-0.3.0.min.js') }}"></script>
<script src="{{ URL::asset('assets/memberform/src/libraries/dust-js/dust-helpers.js') }}"></script>
<script src="{{ URL::asset('assets/memberform/src/libraries/tabs.jquery.js')}}"></script>
<script src="{{ URL::asset('assets/memberform/src/formBuilder.jquery.js')}}"></script>

<script>
    $('#formBuilder').formBuilder({
        load_url: "{{ URL::asset('assets/memberform/src/json/example.json') }}",
        save_url: "{{ URL::to('/memberform/save') }}",
        onSaveForm: function() {
            window.location.href = "{{ URL::to('/memberform/render') }}";
        }
    });
</script>
@stop