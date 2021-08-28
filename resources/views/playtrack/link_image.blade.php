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
        var id = "9999" ;
        var operator_code = "1234";
    </script>
    <script src="{{url('campaign/js/js.js')}}"></script>
</head>
<body>

<div id="chooseDevice">
    <div id="vid" class="container">
        <img id="trackId" src="{{url('img/avatar5.jpg')}}" onclick="myFunction()">
        <div class="pop-contant" ></div>
    </div>

</div>
<script>

    function myFunction() {
        var dv = document.getElementById("chooseDevice");
        var ua = navigator.userAgent;
        // determine OS
        if ( ua.match(/iPad/i) || ua.match(/iPhone/i) ) {
            mobileOS = 'iOS';
        } else if ( ua.match(/Android/i) ){
            mobileOS = 'Android';
        }else {
            mobileOS = 'unknown';
        }
        if ( mobileOS === 'iOS' ){
            window.location.href = "sms:" + operator_code + "&body=" + id;
        } else if ( mobileOS === 'Android' ){
            window.location.href = "sms:" + operator_code + "?body=" + encodeURIComponent(id);
        }else{
             window.location.href = "sms:" + operator_code + "?body=" + encodeURIComponent(id);
        }



            $("#trackId").bind('ended', function() {
                var dv = document.getElementById("chooseDevice");
                var ua = navigator.userAgent;
                // determine OS
                if (ua.match(/iPad/i) || ua.match(/iPhone/i)) {
                    mobileOS = 'iOS';
                } else if (ua.match(/Android/i)) {
                    mobileOS = 'Android';
                } else {
                    mobileOS = 'unknown';
                }

                if (mobileOS === 'iOS') {
                    window.location.href = "sms:" + operator_code + "&body=" + id;
                } else if (mobileOS === 'Android') {
                    window.location.href = "sms:" + operator_code + "?body=" + encodeURIComponent(id);
                } else {
                    console.log('here');
                    window.location.href = "sms:" + operator_code + "?body=" + encodeURIComponent(id);
                }

                $('.pop-contant').fadeIn(2000);
                //  setTimeout(function () {
                //      $('.pop-contant').fadeOut(2000);
                //  }, 5000);
            });
        }
</script>
</body>
</html>
