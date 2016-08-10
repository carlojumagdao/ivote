@extends('master')
@section('title')
    {{"Vote Auditing"}}
@stop   
@section('style')
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/colorpicker/bootstrap-colorpicker.min.css') }}">

     <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/datatables/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/datatables/datatables-responsive/css/dataTables.responsive.css') }}">
@stop
@section('content')
<!-- START CONTENT -->
    @section('title-page')
        {{"Vote Auditing"}}
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
                <h3 class="box-title">List of Voted</h3>
            </div>
            <div class="box-body dataTable_wrapper">
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>Vote Reference</th>
                            <th>Member ID</th>
                            <th>Member Name</th>
                            <th>Date Voted</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                @foreach($voted as $value)
                        <tr>
                            
                            <td class="code">{{$value->strVHCode}}</td>
                            <td class="id">{{$value->strMemberId}}</td>
                            <td class="name">{{$value->strMemFname.' '.$value->strMemLname}}</td>
                            <td class="">{{$value->datVHVoted}}</td>
                            <!-- if else to make the independent party not editable/deletable -->
                           
                            <td>
                                <a href="member/view/{{$value->strMemberId}}" class="btn btn-primary btn-sm view" data- toggle="tooltip" title="View"><i class="fa fa-eye"></i></a>
                            </td>
                            
                        </tr>
                       
                @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Vote Reference</th>
                            <th>Member ID</th>
                            <th>Member Name</th>
                            <th>Date Voted</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
        </div>
    </div> 
    <!-- Delete Form -->
    <div class="hide">
        <form method="POST" action="{{ URL::to('/settings/party/delete') }}" id="delform">
            <input type="hidden" name="id" id="delparty">
        </form>
    </div>
    <!-- Delete Form -->
    <!-- Edit Form -->
    <div class="hide">
        <form method="POST" action="{{ URL::to('/settings/party/') }}" id="editform">
            <input type="hidden" name="id" id="editparty">
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
                responsive: false
        });
    });
</script>
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip(); 
    });
</script>
<script>
    $(document).on("click", ".delParty", function(){
        var x = confirm("Are you sure you want to delete this record?");
        if (x){
            var id = $(this).parent().parent().find('.id').text();
            document.getElementById('delparty').value = id;
            document.getElementById('delform').submit();
        }
        else
            return false;
    });
    $(document).on("click", ".editParty", function(){
            var id = $(this).parent().parent().find('.id').text();
            document.getElementById('editparty').value = id;
            document.getElementById('editform').submit();
        
    });
</script>

@stop