@extends('master')
@section('title')
    {{"Reports"}}
@stop   
@section('style')
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/colorpicker/bootstrap-colorpicker.min.css') }}">
    
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/datatables/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/datatables/datatables-responsive/css/dataTables.responsive.css') }}">
    <style>
        .colorpicker {
            z-index: 9999 !important;
        }
    </style>
@stop
@section('content')
<!-- START CONTENT -->
    @section('title-page')
        {{"Audit Trail"}}
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
    <div class="col-md-12">
<ul class="timeline" id="myList">
    <li class="time-label">
        <span class="bg-red">
            {{date('D, M. d Y', strtotime($first))}}
        </span>
    </li>
    @foreach($audit as $aud)
    <!-- timeline time label -->
    @if($first != $aud->date)
    <?php $first = $aud->date ?>
    <li class="time-label">
        <span class="bg-red">
           {{date('D, M. d Y', strtotime($first))}}
        </span>
    </li>
    @endif
    <!-- /.timeline-label -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        @if($aud->Action == 'INSERTED')
        <i class="fa fa-plus-square bg-yellow"></i>
        @elseif($aud->Action == 'DELETED')
        <i class="fa fa-trash bg-red"></i>
        @else
        <i class="fa fa-edit bg-blue"></i>
        @endif
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i>{{date('h:i a', strtotime($aud->time) )}}</span>

            <h3 class="timeline-header"><a href="#">{{$aud->user}}</a> {{$aud->Action}}  {{$aud->strMemberId}}</h3>

            <!--div class="timeline-body">
                ...
                Content goes here
            </div>

            <div class="timeline-footer">
                <a class="btn btn-primary btn-xs">...</a>
            </div-->
        </div>
    </li>
    <!-- END timeline item -->
    @endforeach
    <li>
        <i class="fa fa-clock-o bg-gray"></i>
    </li>

</ul>
<div id="loadMore" class="btn btn-primary">Load more</div>
<div id="showLess" class="btn btn-danger">Show less</div>
</div>           
                
@stop 
@section('script')
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
<script src="{{ URL::asset('assets/datatables/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/datatables/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
                responsive: true
        });
    });
</script>
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip(); 
    });
</script>
<script src="{{ URL::asset('assets/plugins/select2/select2.full.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/colorpicker/bootstrap-colorpicker.min.js') }}"></script>
<script>
    //Colorpicker
    $(".my-colorpicker1").colorpicker();
    //color picker with addon
    $(".my-colorpicker2").colorpicker();

</script>
<script>
$(document).ready(function () {
    size_li = $("#myList li").size();
    x=3;
    $('#myList li:lt('+x+')').show();
    $('#loadMore').click(function () {
        x= (x+5 <= size_li) ? x+5 : size_li;
        $('#myList li:lt('+x+')').show();
         $('#showLess').show();
        if(x == size_li){
            $('#loadMore').hide();
        }
    });
    $('#showLess').click(function () {
        x=(x-5<0) ? 3 : x-5;
        $('#myList li').not(':lt('+x+')').hide();
        $('#loadMore').show();
         $('#showLess').show();
        if(x == 3){
            $('#showLess').hide();
        }
    });
});
</script>

@stop