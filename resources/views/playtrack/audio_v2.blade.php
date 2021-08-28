 <!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <!-- internet explorer meta-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!--first mobile meta-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{$track[0]->tr_title}}</title>
    <link rel="stylesheet" href="{{url('campaign/style/style2.css')}}" >
    <link rel="stylesheet" href="{{url('campaign/style/font-awesome.min.css')}}" >
    <link rel="stylesheet" href="{{url('campaign/style/bootstrap.css')}}" >
    <script src="{{url('campaign/js/jquery-3.2.1.min.js')}}"></script>
    <?php
        $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    ?>

    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{$track[0]->tr_title}}" />
    <meta property="og:description" content="From Album {{$track[0]->name}}" />
    <meta property="og:image"  content="{{url($track[0]->background_image)}}" />
    <meta property="og:width"  content="500" />
    <meta property="og:height"  content="500" />

    <script>

     //   var id = "" ;// rbt
        var operator_code = "";
        var sub_txt = "{{$track[0]->subscription_txt}}";
        if(!sub_txt)
        {
            sub_txt = "إشترك الآن" ;
        }
        var tracks_img = new Array() ;
        var tracks_rbt_sms_code = new Array() ;
        var tracks_rbt_ussd_code = new Array() ;
        var tracks_code = new Array() ;
        "<?php
          foreach($track as $item)
             {  ?>"+
              tracks_rbt_sms_code.push("<?php echo $item->rbt_sms_code ; ?>") ;
             tracks_rbt_ussd_code.push("<?php echo $item->rbt_ussd_code ; ?>") ;  // ussd
              tracks_img.push("<?php echo url($item->image) ; ?>") ;
              tracks_code.push("<?php echo $item->code ; ?>") ;


             +"<?php }  ?> " ;

    </script>
    <script src="{{url('campaign/js/js.js')}}"></script>
</head>


<body>
<div id="fb-root"></div>
<script>

        (function(d, s, id) {
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
            <p>{{$track[0]->tr_title}}</p>
        </header>

        <section class="item">
           <div class="container">
               <div class="section-head" id="item1">
                   <div id="chooseDevice">
                        <div id="vid">
                          <div class="img-size">
                           @if($track[0]->type=="Audio")
                              <img src="{{url($track[0]->background_image)}}" alt="">

                               <audio id="trackId" width="100%" controls controlsList="nodownload"   playsinline>
                                    <source src="{!! url($track[0]->track_file) !!}">
                                </audio>
                           @else
                           <video id="trackId"  width="100%"  controlsList="nodownload" controls  playsinline>
                                    <img src="{{url($track[0]->background_image)}}" alt="">
                                    <source src="{!! url($track[0]->track_file) !!}">
                                </video>
                           @endif
                            </div>
                            <div class="pop-contant" id="popo"></div>
                            <br>
                       </div>
                   </div>
               </div>

           </div>
        </section>





        <footer>
           <div id="fb-root"></div>
            <div class="footer-wrapper">
                <div class="social-media-wrapper">
                   <div>Design & Developed By
                       <a href="http://ivas.mobi/">IVAS</a>
                       <?php
                        $link_to_share = url()."/share_track?link=$actual_link" ;
                       ?>
                     <!--  <iframe src="<?php echo $link_to_share ?>"style="width: 100px;
                            height: 38px;
                            border: none;
                            overflow: hidden;
                            position: relative;
                            top: 13px;">
                    </iframe>  -->
                </div>
            </div>
        </footer>
</body>
</html>
