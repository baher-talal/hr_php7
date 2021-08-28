 <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <!-- internet explorer meta-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--first mobile meta-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Audio IVAS</title>
    <link rel="stylesheet" href="{{url('campaign/style/style.css')}}" >
    <script src="{{url('campaign/js/jquery-3.2.1.min.js')}}"></script>


    <script>
        var id = "{{$optTrack->code}}" ;
        var operator_code = "{{$optTrack->operator->rbt_sms_code }}";
        var sub_txt = "{{$track->subscription_txt}}";
        if(!sub_txt)
            sub_txt = "إشترك الآن";
    </script>
    <script src="{{url('campaign/js/js_v2.js')}}"></script>
</head>
<body background="{{url($track->album->background_image)}}">

<div id="chooseDevice">
    <div id="vid" class="container">
        <h1> {!! $track->title !!} </h1>
        <audio id="trackId" width="100%"  autoplay controls>
            <source src="{!! url($track->track_file) !!}">
        </audio>
        <div class="pop-contant"></div>
    </div>

</div>

</body>
</html>
