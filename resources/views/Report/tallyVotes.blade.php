@extends('master')
@section('title')
    {{"Queries"}}
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
        {{"Reports"}}
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
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Tally of Votes</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body table-responsive">
                @foreach($positions as $pos)
                <div class="row ">
                    <div class="col-md-12">
                <h3>{{$pos->strPosName}}</h3>
               
                @foreach($tally as $cand)
                <!-- Apply any bg-* class to to the info-box to color it -->
                @if($pos->strPositionId == $cand->strCandPosId)
                <div class="col-md-3">
                <div class="info-box bg-blue">
                    <span class="info-box-icon"><image class="img-circle" src ="assets/images/{{$cand->txtCandPic}}" height="80" width="80"></span>
                    <div class="info-box-content">
                        <span class="info-box-text">{{$cand->strMemLName}}, {{$cand->strMemFName}}</span>
                        <span class="info-box-number">{{$cand->votes}}</span>
                        <!-- The progress section is optional -->
                        <div class="progress">
                            <div class="progress-bar" style="width: {{($cand->votes / $count )* 100}}%"></div>
                        </div>
                        <span class="progress-description">
                            {{($cand->votes / $count )* 100}}% of Votes
                        </span>
                    </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->
                    </div>
                    @endif
                @endforeach
                        </div>
                </div>
                @endforeach
            </div>
            <div class="box-footer">
                <a href="{{ URL::to('/getPDF') }}" target="_blank"><input type="button" class="btn btn-primary pull-right" name="btnSubmit" value="Create PDF"></a>
            </div>
        </div>
        
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

@stop