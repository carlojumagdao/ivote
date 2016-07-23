<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="csrf_token" content="{{ csrf_token() }}" />
  <title>@yield('title', 'iVote++ | Home')</title>
  @yield('style')
    <link rel="stylesheet" href="{{ URL::asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/bootstrap/css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/mc-profile/dist/material-cards-auto-height.css') }}">
    <!-- <link rel="stylesheet" href="{{ URL::asset('assets/bootstrap/css/ionicons.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/iCheck/all.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/dist/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/dist/css/skins/_all-skins.min.css') }}"> -->
</head>
<style>

    html {
            position: relative;
            min-height: 100%;
    }

    .grid-item {
        width: 300px;
        padding: 15px;
    }
    body{
        background-image: url("{{ URL::asset('../assets/images/bgGlass.jpg') }}");
        background-color: #ECEFF1;
        color: #37474F;
        font-family: 'Raleway', sans-serif;
        font-weight: 300;
        font-size: 16px;
      /*background-repeat: no-repeat;*/
      /*background-size: cover;*/
      /*background-attachment: fixed;*/

      }
      header {
        background:#ededed;
        padding-left: 50px;
        height: 200px;
      }
      .header-cont {
          width:97%;
          margin-left: 20px;
      }
      footer {
      width:100%;
      height:100px;
      position:absolute;
      bottom:0;
      left:0;
    }
      
    
</style>
<header style="background-color:rgba(248, 248, 248, 0.71);border-bottom: 3px solid  DodgerBlue ">
 @foreach($election as $setting)
 <div class="row">
 
      <div class="col-md-2 col-xs-6">
            <div class="tooltipped" data-position="top" data-delay="50" data-tooltip="logo picture">
                <img id="cand-pic" class="img-responsive" src="../assets/images/{{$setting->txtSetLogo}}"  style="opacity:2px; width: 180px;background-size: contain;margin-top: 10px; " /> 
            </div>
        </div>
        <div class="col-md-7 col-xs-6 "  >
            
               
                <h2 class="responsive-text" style="font-family:helvetica;text-align:left;text-transform: capitalize;letter-spacing:1px">{{$setting->strHeader}}</h2>
                
                <h4 class="responsive-text" style="font-family:segoe ui;text-align:left;margin-top:10px;">{{$setting->strSetElecName}}</h4>
                <h6 class="responsive-text" style="font-family:segoe ui;text-align:left;letter-spacing:1px;text-transform: capitalize;">{{$setting->strSetElecDesc}}</h6>
                @endforeach
                <h6 class="responsive-text" style="style=font-family:segoe ui;text-align:left;letter-spacing:1px;color:Tomato ">"Election Not Open Yet"</h6>
                
            
        </div>

</div>
  
</header>
<body>
    <div style="padding: 10px">
    <h3></h3>
    </div>
    
    
        <div class="box-body" style="padding-left: 40px;padding-right:40px">
            
            @foreach($positions as $position)
                   <div class="row panel" style="border-left: 4px solid {{$position->strPosColor}};background-color:rgba(0, 0, 0, 0.20)">
                        <div class="col-md-12">
                            <div class="col-md-12" style="text-transform: capitalize;">
                                <h3 style="letter-spacing:1px;font-family: helvetica;color: white  ;text-shadow: 1px 1px 4px rgba(6, 5, 5, 0.62);">{{$position->strPosName}}</h3>
                            </div>
                @foreach($candidates as $candidate)
                    @if($candidate->strCandPosId == $position->strCandPosId )
                    <div class="col-md-2 col-xs-12" style="padding:10px;" >
                    <div class="grid-item col-md-4 col-xs-12 ">
                        <article class="material-card Teal">
                            <h2>
                                <span>{{$candidate->strMemFname}} {{$candidate->strMemLname}}</span>
                                <strong>
                                    <i class="fa fa-fw fa-star"></i>
                                    Candidate
                                </strong>
                            </h2>
                            <div class="mc-content">
                                <div class="img-container">
                                    <img class="img-responsive" src="../assets/images/{{$candidate->txtCandPic}}">
                                </div>
                                <div class="mc-description">
                                    Education Background: &nbsp {{ $candidate->strCandEducBack}}
                                    Platform: &nbsp {{ $candidate->strCandInfo}}
                                </div>
                            </div>
                            <a class="mc-btn-action">
                                <i class="fa fa-bars"></i>
                            </a>
                            <div class="mc-footer">
                                <h4>
                                    Social Accounts
                                </h4>
                                <a class="fa fa-fw fa-facebook"></a>
                                <a class="fa fa-fw fa-twitter"></a>
                                <a class="fa fa-fw fa-linkedin"></a>
                                <a class="fa fa-fw fa-google-plus"></a>
                            </div>
                        </article>
                    </div>
                </div>
                    @endif
                @endforeach           
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <!-- </div> -->
<footer style="text-shadow: 2px 2px 8px rgba(5, 5, 5, 0.62);background-color:rgba(0, 0, 0, 0.35);height:59px;">
<center><p style="color:white;font-size:14px;padding-top:10px;">Copyright © 2015-2016 iVote++<br>All rights reserved</p></center>
</footer>
    
    <!-- jQuery 2.2.0 -->
<script src="{{ URL::asset('assets/jquery/jquery.min.js') }}"></script>
<script src="{{ URL::asset('assets/jquery/jquery-ui.min.js') }}"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{ URL::asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('assets/mc-profile/js/jquery.material-cards.min.js') }}"></script>
<script src="{{ URL::asset('assets/mc-profile/dist/mansory.js') }}"></script>
<script src="{{ URL::asset('assets/responsivetext/jquery.responsivetext.js') }}"></script>
<script type="text/javascript">
  $("header").responsiveText({
     bottomStop : '100',
     topStop    : '1500'
});
</script>
<script>
    $(function() {

        var $grid = $('.grid').masonry({
            itemSelector: '.grid-item',
            columnWidth: 300,
        });

        $('.material-card').materialCard();

        $('.material-card').on('shown.material-card hidden.material-card', function (event) {
            $grid.masonry();
        });

    });
</script>
@yield('script')   
</body>
</html>
    