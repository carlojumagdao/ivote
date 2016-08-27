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
        {{"Queries"}}
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
                <form action="{{ URL::to('/queries') }}" method="post">
                    <div class="col-md-2 ">
                        {!! Form::label( 'queries', 'Select Query:' ) !!}
                    </div>
                    <div class="col-md-8">
                        <select name="query" class="form-control select2" required>
                            <option></option>
                            @if($surveystat == 1)<option value=1>Members who took survey</option>
                            <option value=2>Members who did not take survey</option>@endif
                            <option value=3>Members who voted</option>
                            <option value=4>Members who did not vote</option>
                            <option value=5>Candidates who voted</option>
                            <option value=6>Candidates who did not vote</option>
                            <option value=7>Members who undervote</option>
                            <option value=8>Members who did not undervote</option>
                            @if($partystat == 1)<option value=9>Members who votestraight</option>
                            <option value=10>Members who did not votestraight</option>@endif
                            
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
        @if(isset($query))
      
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Query Result</h3>
                <div class="box-tools pull-right">
                    
                    <a href="{{$link}}" class="btn btn-xs btn-info sendall" data-toggle="tooltip" title="Get PDF of Query" target="_blank"><i class="fa fa-file-pdf-o"></i> Get PDF</a>
                </div>
            </div>
            <div class="box-body dataTable_wrapper">
                <!-- Apply any bg-* class to to the info-box to color it -->
                <div class="info-box bg-blue">
                    <span class="info-box-icon"><i class="fa fa-pie-chart"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">{{$title}}</span>
                        <span class="info-box-number">{{$count}}</span>
                        <!-- The progress section is optional -->
                        <div class="progress">
                            <div class="progress-bar" style="width: {{$percent}}%"></div>
                        </div>
                        @if($publish == 1)
                        <span class="progress-description">
                            {{number_format($percent, 2, '.', '')}}% of total members with passcode sent
                        </span>
                        @else
                        <span class="progress-description">
                            {{number_format($percent, 2, '.', '')}}% of total members
                        </span>
                        @endif
                    </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>Member Id</th>
                            <th>Full Name</th>
                             @if($query%2 != 0)<th>Date</th>@endif
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($list as $value)
                        <tr>
                            <td class="id">{{$value->strMemberId}}</td>
                            <td class="name">{{$value->strMemFname.' '.$value->strMemLname}}</td>
                            @if($query%2 != 0)
                            <td class="date">@if($query <= 2){{date('D, M. d Y h:i a', strtotime($value->datSHAnswered))}} 
                                @else {{date('D, M. d Y h:i a', strtotime($value->datVHVoted))}} @endif </td>@endif
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Member Id</th>
                            <th>Full Name</th>
                             @if($query%2 != 0)<th>Date</th>@endif
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="box-footer">
                Footer
            </div>
        </div>
        @endif
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