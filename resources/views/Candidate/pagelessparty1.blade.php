<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="msapplication-tap-highlight" content="no">
    <title>iVote++ | Candidate Page</title>
    <link rel="stylesheet" href="{{ URL::asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/bootstrap/css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/mc-profile/dist/material-cards-auto-height.css') }}">
    <style type="text/css">

        html {
            position: relative;
            min-height: 100%;
        }

        body {
            background-image: url("{{ URL::asset('../assets/images/bgGlass.jpg') }}");
            background-color: #ECEFF1;
            color: #37474F;
            font-family: 'Raleway', sans-serif;
            font-weight: 300;
            font-size: 16px;
        }

        h1, h2, h3 {
            font-weight: 200;
        }

        .grid-item {
            width: 390px;
            padding: 15px;
        }

    </style>
</head>
<body>
<section class="container">
    <div class="page-header">
        <h1>Material cards with proper jquery plugin and Masonry library<br>
            <small>jquery.material-cards.js with awesome Masonry grid library</small></h1>
    </div>
    
        @foreach($positions as $position)
            <div class="row active-with-click grid">
            @foreach($candidates as $candidate)
                @if($candidate->strCandPosId == $position->strCandPosId )
                <div class="grid-item">
                    <article class="material-card Teal">
                        <h2>
                            <span>{{$candidate->strMemFname}} {{$candidate->strMemLname}}</span>
                            <strong>
                                <i class="fa fa-fw fa-star"></i>
                                {{$position->strPosName}}
                            </strong>
                        </h2>
                        <div class="mc-content">
                            <div class="img-container">
                                    <?php $image = "https://s3.amazonaws.com/ndap-ivote-2017/candidates/".$candidate->txtCandPic."";
                                    ?>
                                    <img class="img-responsive" src="{{$image}}">
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
                                Social
                            </h4>
                            <a class="fa fa-fw fa-facebook"></a>
                            <a class="fa fa-fw fa-twitter"></a>
                            <a class="fa fa-fw fa-linkedin"></a>
                            <a class="fa fa-fw fa-google-plus"></a>
                        </div>
                    </article>
                </div>
                @endif
            @endforeach
            </div>
        @endforeach
    
</section>

<script src="{{ URL::asset('assets/jquery/jquery.min.js') }}"></script>
<script src="{{ URL::asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('assets/mc-profile/js/jquery.material-cards.min.js') }}"></script>
<script src="{{ URL::asset('assets/mc-profile/dist/mansory.js') }}"></script>
<script>
    $(function() {

        var $grid = $('.grid').masonry({
            itemSelector: '.grid-item',
            columnWidth: 390,
        });

        $('.material-card').materialCard();

        $('.material-card').on('shown.material-card hidden.material-card', function (event) {
            $grid.masonry();
        });

    });
</script>
</body>
</html>