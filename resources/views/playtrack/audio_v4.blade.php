<!DOCTYPE html>
<html>
    <head>

        <meta charset="utf-8">
        <!-- internet explorer meta-->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <!--first mobile meta-->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{$album[0]->album_name}}</title>
        <link rel="stylesheet" href="{{url('campaign/style/style4.css')}}" >
        <link rel="stylesheet" href="{{url('campaign/style/font-awesome.min.css')}}" >
        <link rel="stylesheet" href="{{url('campaign/style/bootstrap.css')}}" >
        <script src="{{url('campaign/js/jquery-3.2.1.min.js')}}"></script>
        <?php
        $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        ?>

        <meta property="og:type" content="website" />
        <meta property="og:title" content="{{$album[0]->album_name}}" />
        <meta property="og:description" content="From Album {{$album[0]->name}}" />
        <meta property="og:image"  content="{{url($album[0]->background_image)}}" />
        <meta property="og:width"  content="500" />
        <meta property="og:height"  content="500" />

        <script>

//   var id = "" ;// rbt
var operator_code = "";
var sub_txt = "إشترك الآن";

var tracks_img = new Array();
var tracks_rbt_sms_code = new Array();
var tracks_rbt_ussd_code = new Array();
var tracks_code = new Array();
"<?php
        foreach ($album as $item) {
            ?>" +
            tracks_rbt_sms_code.push("<?php echo $item->rbt_sms_code; ?>");
            tracks_rbt_ussd_code.push("<?php echo $item->rbt_ussd_code; ?>");  // ussd
            tracks_img.push("<?php echo url($item->image); ?>");
            tracks_code.push("<?php echo $item->code; ?>");


    +"<?php } ?> ";

        </script>
        <script src="{{url('campaign/js/js_4.js')}}"></script>

<style>
body, html {
  height: 100%;
  margin: 0;
}
@if(isset($album[0]->background_image))
.bg {
  /* The image used */
  background-image: url('{{url()."/".$album[0]->background_image}}');

  /* Full height */
  height: 100%;

  /* Center and scale the image nicely */
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
}
@endif

</style>

    </head>


    <body>

        <div class="bg">


        <div id="fb-root"></div>
        <script>

(function (d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id))
        return;
    js = d.createElement(s);
    js.id = id;
    js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.11&appId=172570463327773';
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
        </script>

        <header>
            <p>{{$album[0]->album_name}}</p>
        </header>

        <section class="item">
            <div class="container">



                <?php
                for($i=0 ; $i<count($album) ;$i++){
                    ?>
                    <div class="section-head" style="position: relative;margin: 107px auto;">
                    <div id="chooseDevice" >
                        <div >
                            <div class="img-size">
                                @if($album[$i]->type=="Audio")
                                <img src="{{url($album[$i]->background_image)}}" alt="">

                                <audio id="trackId" width="100%" controls controlsList="nodownload"   playsinline>
                                    <source src="{!! url($album[$i]->track_file) !!}">
                                </audio>
                                @else
                                <video id="trackId"  width="100%" @if($album[$i]->track_poster) poster="{{url($album[$i]->track_poster)}}" @endif  controlsList="nodownload" controls  playsinline>
                                    <img src="{{url($album[$i]->background_image)}}" alt="">
                                    <source src="{!! url($album[$i]->track_file) !!}">
                                </video>
                                @endif
                            </div>
                            <div class="pop-contant" id="popo_{{}}" style="position: absolute;;top:90%">
                              @for($j=0;$j<count(get_track($album[$i]->track_id));$j++)
                              <img src="{!! url(get_track($album[$i]->track_id)[$j]->image) !!}" width="100px" height="50px"/>
                              @endfor
                            </div>
                            <br>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>


            </div>
        </section>





        <!--        <footer>
                   <div id="fb-root"></div>
                    <div class="footer-wrapper">
                        <div class="social-media-wrapper">
                           <div>Design & Developed By
                               <a href="http://ivas.mobi/">IVAS</a>
        <?php
        $link_to_share = url() . "/share_track?link=$actual_link";
        ?>
                               <iframe src="<?php echo $link_to_share ?>"style="width: 100px;
                                    height: 38px;
                                    border: none;
                                    overflow: hidden;
                                    position: relative;
                                    top: 13px;">
                            </iframe>
                        </div>
                    </div>
                </footer>-->
                </div>
    </body>
</html>
