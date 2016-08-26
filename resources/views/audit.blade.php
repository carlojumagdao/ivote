@extends('master')
@section('title')
    {{"Audit"}}
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
    
    
</ul> 
        <div class="stop"><center><h3>No More to Load</h3></center>
        </div>

       <center> <div class="ajax-loading"><img src="{{URL::asset('assets/images/Loading_icon3.gif')}}" style="max-height:50px"/>
           </div></center>
                
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
    var page = 1; //track user scroll as page number, right now page number is 1
    $('.stop').hide();
    load_more(page); //initial content load
    $(window).scroll(function() { //detect page scroll
        if($(window).scrollTop() + $(window).height() >= $(document).height()) { //if user scrolled from top to bottom of the page
            page++; //page number increment
            load_more(page); //load content   
        }
    });
    
function load_more(page){
  $.ajax(
        {
            url: '?page=' + page,
            type: "get",
            datatype: "html",
            beforeSend: function(xhr)
            {
                $('.stop').hide();
                $('.ajax-loading').show();
                if(page == 1)var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                      return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            }
        })
        .done(function(data)
        {
            if(data.length == 0){
            console.log(data.length);
               
                //notify user if nothing to load
                $('.ajax-loading').html("No more records!");
                return;
            }
            $('.ajax-loading').hide(); //hide loading animation once data is received
            $("#myList").append(data); //append data into #results element          
        })
        .fail(function(jqXHR, ajaxOptions, thrownError)
        {
              //alert('No response from server');
           
            $('.stop').show();
            $('.ajax-loading').hide();
        });
 }
</script>
    
</script>

@stop