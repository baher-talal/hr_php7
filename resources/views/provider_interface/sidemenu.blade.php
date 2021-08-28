<?php $sidebar = SiteHelpers::menus('sidebar'); ?>
<nav role="navigation" class="navbar-default navbar-static-side" style="background-color: #2c4052;height: 100%;">
    <div class="sidebar-collapse">
        <ul id="sidemenu" class="nav expanded-menu">
            <li class="logo-header" >
                <a style="  width: 100%;height: 100%;padding-top: 8px;" class="navbar-brand" href="{{ URL::to('dashboard')}}">
                    <h3 class="text-center">{{ CNF_APPNAME }} <br/><small> {{ CNF_APPDESC }} </small></h3>
                    <!--@if(file_exists(public_path().'/sximo/images/'.CNF_LOGO) && CNF_LOGO !='')
                    <img src="{{ asset('sximo/images/'.CNF_LOGO)}}" alt="{{ CNF_APPNAME }}" />
                    @else
                    <img src="{{ asset('sximo/images/logo.png')}}" alt="{{ CNF_APPNAME }}" />
                    @endif-->
                </a>
            </li>
            <li class="nav-header">
                <div class="dropdown profile-element" style="text-align:center;"> <span>
                        @if(Session::has('provider'))
                        <?php $user_image = Session::get('provider')  ?>
                         <img src="{{url('/uploads/user/'.$user_image->provider_logo)}}" class="img-circle" width="80px" height="80px" alt=""> 
                        @else
                        {!! SiteHelpers::avatar() !!}
                        @endif
                    </span>
                    <a href="{{ URL::to('user/profile') }}" >
                        <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{ Session::get('fid') }}</strong>   <br/>


                                <!--				{{ Lang::get('core.lastlogin') }} :  <br/>
                                                                <small>{{ date("H:i F j, Y", strtotime(Session::get('ll'))) }}</small>	 <br/> -->

                              Welcome  {{ Session::get('provider')->provider_name}}  <br/>

                            </span>
                        </span>
                    </a>
                </div>
                <div class="photo-header "> {!! SiteHelpers::avatar( 40 ) !!} </div>
            </li>
            <li class="active">
               <a href="{{url('provider/content')}}" class="expand level-closed">
                  <i class="fa  fa-bookmark"></i><span class="nav-label">Contents</span><span class="fa arrow"></span>
               </a>
          </li>
        </ul>
    </div>
</nav>
