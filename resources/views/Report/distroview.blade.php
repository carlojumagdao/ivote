@extends('master')
@section('title')
    {{"Vote Distribution"}}
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
        {{"Vote Distribution"}}
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
                <h3 class="box-title">List of all Queries</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body table-responsive">
                <form action="{{ URL::to('/viewDistro') }}" method="post">
                    <div class="col-md-2 ">
                        {!! Form::label( 'distro', 'Vote Distribution By:' ) !!}
                    </div>
                    <div class="col-md-8">
                        <select name="distro" class="form-control select2" required>
                            <option></option>
                            @foreach($posdetail as $detail)
                            <option value="{{$detail->strDynFieldName}}">{{ucwords($detail->strDynFieldName)}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-2 ">
                    <input type="submit" class="btn btn-primary" name="btnSubmit" value="Submit">
                </div>
                </form>    
            </div>
            <div class="box-footer">
                Footer
            </div>
        </div>
        <div class ="callout callout-info">
            <h4>
                    Vote Distribution by:
                    <span style="font-size:24px">{{ucwords($by)}}</span>
            </h4>
        </div>
        
        @foreach($candidate as $cand)
        <div class="col-lg-6">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">{{$cand->strMemFname}} {{$cand->strMemLname}}</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="chart">
                        <canvas id="{{$cand->strCandId}}" style="height:230px"></canvas>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
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
<script src="{{ URL::asset('assets/plugins/chartJS2/Chart.min.js') }}"></script>
<script>
    
    @foreach($candidate as $cand)
    $(function () {
        var data = {
            labels: [
                @foreach($votedistro as $dis)
                @if($cand->strCandId == $dis->strCandId)
                    @if($dis->strMemDeFieldData == null) "unidentified",
                    @else "{{$dis->strMemDeFieldData}}",
                    @endif
                @endif
                @endforeach
            ],
            datasets: [
                {
                    data: [
                        @foreach($votedistro as $dis)
                        @if($cand->strCandId == $dis->strCandId)
                            {{$dis->count}},
                        @endif
                        @endforeach
                    ],
                    backgroundColor: [
                        '#FFCE56',
                        '#4BC0C0',
                        '#FF6384',
                        '#36A2EB',
                        '#ff7a56',
                        '#56e5ff'
                    ],
                }]
        };
        
         var options = {
             //Boolean - Whether we should show a stroke on each segment
             segmentShowStroke: true,
             //String - The colour of each segment stroke
             segmentStrokeColor: "#fff",
             //Number - The width of each segment stroke
             segmentStrokeWidth: 2,
             //Number - The percentage of the chart that we cut out of the middle
             percentageInnerCutout: 50, // This is 0 for Pie charts
             //Number - Amount of animation steps
             animationSteps: 100,
             //String - Animation easing effect
             animationEasing: "easeOutBounce",
             //Boolean - Whether we animate the rotation of the Doughnut
             animateRotate: true,
             //Boolean - Whether we animate scaling the Doughnut from the centre
             animateScale: false,
             //Boolean - whether to make the chart responsive to window resizing
             responsive: true,
             // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
             maintainAspectRatio: true,
             //String - A legend template
             /*legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"*/
         };
                 
        var pieChartCanvas = $("#{{$cand->strCandId}}").get(0).getContext("2d");
        var pieChart = new Chart(pieChartCanvas, {
            type: 'doughnut',
            data: data,
            options: options
        });
    });
      @endforeach
</script>

@stop