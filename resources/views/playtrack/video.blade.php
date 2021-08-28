<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <!-- internet explorer meta-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--first mobile meta-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Video IVAS</title>
    <script src="{{url('campaign/js/jquery-3.2.1.min.js')}}"></script>
    <script>
        var id = "{{$optTrack->code}}" ;// rbt
        var operator_code = "{{$optTrack->operator->rbt_sms_code }}";
        var sub_txt = "{{$track->subscription_txt}}";
        if(!sub_txt)
            sub_txt = "إشترك الآن";
    </script>
    <script src="{{url('campaign/js/js_v2.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{url('campaign/style/style.css')}}">
</head>
<body>
<div id="chooseDevice">
    <div id="vid">
        <video id="trackId" width="100%"  autoplay controls playsinline>
            <source src="{{url($track->track_file)}}" >
        </video>
        <div class="pop-contant"></div>
    </div>
</div>
</body>
</html>
