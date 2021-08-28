<div class="row" >
    <nav style="margin-bottom: 0;background-color: #2c4052;" role="navigation" class="navbar navbar-static-top nav-inside">
        <div class="navbar-header">
            <a href="javascript:void(0)" class="navbar-minimalize minimalize-btn btn btn-primary "><i class="fa fa-bars"></i> </a>

        </div>

        <ul class="nav navbar-top-links navbar-right">
            <li>

            </li>

            <style media="screen">
              .icons-right
              {
                max-height:400px !important;
                overflow-y:scroll !important;
              }
            </style>




            @if(CNF_MULTILANG ==1)
            <?php
            $lang = 'en';
            if (Session::get('lang') !== NULL) {
                Session::put('lang', Session::get('lang'));
                $lang = Session::get('lang');
            }
            ?>
            <li  class="user dropdown"><a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown"><img src="{{ asset('sximo/images/'.$lang.'.png')}}"><i class="caret"></i></a>
                <ul class="dropdown-menu dropdown-menu-right icons-right">
                    @foreach(SiteHelpers::langOption() as $lang)
                    <li><a href="{{ URL::to('home/lang/'.$lang['folder'])}}"><img class="flag-lang" src="{{ asset('sximo/images/'.strtolower($lang['name']).'.png')}}">{{  $lang['name'] }}</a></li>
                    @endforeach
                </ul>
            </li>
            @endif

            <li class="user dropdown"><a class="dropdown-toggle" href="javascript:void(0)"  data-toggle="dropdown"><i class="fa fa-user"></i> <span>{{ Lang::get('core.m_myaccount') }}</span><i class="caret"></i></a>
                <ul class="dropdown-menu dropdown-menu-right icons-right">
                    <li><a href="{{ URL::to('aggregator')}}"><i class="fa  fa-laptop"></i> {{ Lang::get('core.m_dashboard') }}</a></li>

                    <li><a href="{{ URL::to('aggregator/profile')}}"><i class="fa fa-user"></i> {{ Lang::get('core.m_profile') }}</a></li>


                    <li><a href="{{ URL::to('aggregator/logout')}}"><i class="fa fa-sign-out"></i> {{ Lang::get('core.m_logout') }}</a></li>
                </ul>
            </li>



        </ul>

    </nav>
</div>
