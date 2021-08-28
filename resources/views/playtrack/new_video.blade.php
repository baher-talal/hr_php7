<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <!-- internet explorer meta-->
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!--first mobile meta-->
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <!-- <title>new Video</title> -->
      <title>{{$albums[0]->name}}</title>
      <link rel="stylesheet" href="{{url('campaign/style/style4.css')}}" >
      <link rel="stylesheet" href="{{url('campaign/style/font-awesome.min.css')}}" >
      <link rel="stylesheet" href="{{url('campaign/style/bootstrap.css')}}" >
      <script src="{{url('campaign/js/jquery-3.2.1.min.js')}}"></script>
      <style type="text/css">
      @import url('https://fonts.googleapis.com/css?family=Cairo');
         .bg {
        background-image: url({{url($albums[0]->background_image)}});
         height: 100%;
         background-position: center;
         background-repeat: no-repeat;
         background-size: 100% 100%;
         background-attachment: fixed;
         position: fixed;
         width: 100%;
         overflow-y: scroll;
         }
      </style>
      <?php
      $iPhone  = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
      $iPad    = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
      $Android = stripos($_SERVER['HTTP_USER_AGENT'],"Android");
      $webOS   = stripos($_SERVER['HTTP_USER_AGENT'],"webOS");
      if($iPhone || $iPad){
        $sign = "&";
      }else{
        $sign = "?";
      }
       ?>
   </head>
   <body>
      <div class="bg">
         <div id="fb-root"></div>
         <header>
<!--           <p>{{$albums[0]->name}}</p>-->
         </header>
         <section class="item">
            <div class="container">
               <div class="section-head" id="item1">
                  <div id="chooseDevice">
                    @foreach($albums as $album)
                     <!--  =========================== Start Video ===================================== -->
                     <div id="vid">
                        <div class="title_video">
                           <p>{{$album->subscription_txt}}</p>
                        </div>
                        <div class="img-size">
                          @if($album->type=="Audio")
                          <img src="{{url($album->background_image_track)}}" alt="">
                          <audio id="trackId" width="100%" controls controlsList="nodownload"   playsinline>
                              <source src="{!! url($album->track_file) !!}">
                          </audio>
                          @else
                           <video  width="100%"  controlsList="nodownload" @if($album->track_poster) poster="{{url($album->track_poster)}}" @endif controls  playsinline>
                              <source src="{!! url($album->track_file) !!}">
                           </video>
                          @endif
                        </div>
                        <!--  <div class="pop-contant" id="popo"></div> <br> -->
                        @if(count(get_track($album->track_id,$country_from_ip)) > 0)
                        <div class="content_operator">
                           <i class="fa fa-times close"></i>
                           <div class="row">
                              @for($j=0;$j<count(get_track($album->track_id,$country_from_ip));$j++)
                                  <div class="col-6" style="padding-bottom: 19px">
                               @if((int) get_track($album->track_id,$country_from_ip)[$j]->rbt_ussd_code > 0)
                               <a href="tel:*{{get_track($album->track_id,$country_from_ip)[$j]->rbt_ussd_code}}*{{get_track($album->track_id,$country_from_ip)[$j]->code}}%23">
                               @else
                               <a href="sms:{{get_track($album->track_id,$country_from_ip)[$j]->rbt_sms_code}}{{$sign}}body={{get_track($album->track_id,$country_from_ip)[$j]->code}}">
                               @endif
                                 <img src="{!! url('/'.get_track($album->track_id,$country_from_ip)[$j]->image) !!}" alt="operator"/>
                               </a>

                                 @if((int) get_track($album->track_id,$country_from_ip)[$j]->rbt_ussd_code > 0)
                               <a class="btn btn-info" role="button"  href="tel:*{{get_track($album->track_id,$country_from_ip)[$j]->rbt_ussd_code}}*{{get_track($album->track_id,$country_from_ip)[$j]->code}}%23"> اشترك </a>
                               @else
                               <a class="btn btn-info" role="button" href="sms:{{get_track($album->track_id,$country_from_ip)[$j]->rbt_sms_code}}{{$sign}}body={{get_track($album->track_id,$country_from_ip)[$j]->code}}">اشترك</a>
                               @endif

                              </div>
                              @endfor
                           </div>
                        </div>
                        @endif
                     </div>
                     <!--  =========================== End Video ===================================== -->
                     <div class="line">
                        <hr>
                     </div>
                     <!--  =========================== Start Video ===================================== -->
                     @endforeach

                  </div>
               </div>
            </div>
         </section>
      </div>
      <script type="text/javascript">
          //==============================
          // Close Popup
          //==============================
         $('.close').on("click", function () {
          $(this).parents('.content_operator').fadeOut();
         });


         //==============================
         // with ended video show popup
         //==============================
         $('video').on('ended',function(){
          $(this).parents('.img-size').next('.content_operator').fadeIn();

         });


         //==============================
         // Run one Video only
         //===============================
         $("video").on("play", function () {
         $("video").not(this).each(function (index, video) {
            video.pause();
         });
         });
      </script>
   </body>
</html>
