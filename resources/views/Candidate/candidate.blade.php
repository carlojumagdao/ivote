@extends('master')
@section('title')
    {{"Candidates"}}
@stop   
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/datatables/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/datatables/datatables-responsive/css/dataTables.responsive.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/colorpicker/bootstrap-colorpicker.min.css') }}">
    <style>
        .colorpicker {
            z-index: 9999 !important;
        }
    </style>
@stop
@section('content')
<!-- START CONTENT -->
    @section('title-page')
        {{"Candidates Maintenance"}}
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
                <h3 class="box-title">Display all candidates</h3>
            </div>
            <div class="box-body dataTable_wrapper">
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ID</th>
                            <th>Candidate Name</th>
                            <th>Position</th>
                            @if($party)<th>Party</th>@endif
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($candidates as $candidate)
                        <tr>
                            
                            <td>{{++$intCounter}}</td>
                            <td class="id">{{$candidate->strCandId}}</td>
                            <td class="name">{{$candidate->strMemFname}} {{$candidate->strMemLname}}</td>
                            <td class="leader">{{$candidate->strPosName}}</td>
                            @if($party)<td class="color">{{$candidate->strPartyName or 'disabled'}}</td>@endif
                            <!-- if else to make the independent party not editable/deletable -->
                       
                            <td>
                                <button class="btn btn-warning btn-sm editCandidate" data-toggle="modal" title="Edit"><i class="glyphicon glyphicon-edit"></i></button>
                                <button class="btn btn-danger btn-sm delCandidate" data-toggle="tooltip" title="Delete"><i class="glyphicon glyphicon-trash"></i></button>
                            </td>
                       
                        </tr>
                        @endforeach
                    
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>ID</th>
                            <th>Candidate Name</th>
                            <th>Position</th>
                            @if($party)<th>Party</th>@endif
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="box-footer">
                <a href="{{ URL::to('/candidates/page')}}" class="btn btn-primary">SHOW CANDIDATE PAGE</a>
            </div>
        </div>
    </div> 
    <!-- Delete Form -->
    <div class="hide">
        <form method="POST" action="{{ URL::to('/candidates/delete') }}" id="delform">
            <input type="hidden" name="id" id="delcandidate">
        </form>
    </div>
    <!-- Delete Form -->
    <!-- Edit Form -->
    <div class="hide">
        <form method="POST" action="{{ URL::to('/candidates') }}" id="editform">
            <input type="hidden" name="id" id="editcandidate">
        </form>
    </div>
    <!-- Edit Form -->
@stop 
@section('script')
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
<script> 
    function readURL(input) {
        alert("add");
        if (input.files && input.files[0]) {
            var reader = new FileReader();
                reader.onload = function (e) {
                    $('#cand-pic')
                    .attr('src', e.target.result)
                    .width(150)
                    .height(150);
                    
                };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<script>
    $(document).on("click", ".delCandidate", function(){
        var x = confirm("Are you sure you want to delete this record?");
        if (x){
            var id = $(this).parent().parent().find('.id').text();
            document.getElementById('delcandidate').value = id;
            document.getElementById('delform').submit();
        }
        else
            return false;
    });
    $(document).on("click", ".editCandidate", function(){
            var id = $(this).parent().parent().find('.id').text();
            document.getElementById('editcandidate').value = id;
            document.getElementById('editform').submit();
        
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