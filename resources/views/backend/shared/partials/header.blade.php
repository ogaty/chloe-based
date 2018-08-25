<div class="header clearfix">
    <div class="header__logo--pc">
        <a href="{!! route('admin.home') !!}">
            <img src="logo.png">
        </a>
    </div>
    <!--
    <li id="menu-trigger" data-trigger="#sidebar">
        <div class="line-wrap">
            <div class="line top"></div>
            <div class="line center"></div>
            <div class="line bottom"></div>
        </div>
    </li>
    <div class="header__logo--sm">
        <a href="{!! route('admin.home') !!}">
            <img src="logo.png">
        </a>
    </div>
    -->
    <div class="header__right">
        <div class="user-wrap">
            <img src="logo.png" onclick="userMenu()">
        </div>
        <div class="search-wrap">
            <img src="logo.png" onclick="searchMenu()">
        </div>
        <div class="user-menu">
            <div>{{ Auth::guard()->user()->display_name }}</div>
            <div>{{ Auth::guard()->user()->email }}</div>
            <hr>
            <div><a href="{!! route('home') !!}">view site</a></div>
            <div><a href="{!! route('admin.profile.index') !!}">Profile</a></div>
            <div><a href="{{ route('logout') }}">logout</a></div>
        </div>
        <div class="search-menu">
            <form method="get">
                <div>
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <input type="button" name="back" value="back">
                    <input type="text" name="query">
                    <input type="submit">
                </div>
            </form>
        </div>
    </div>
</div>


<header id="header" class="clearfix" data-current-skin="blue">
    <a href="{!! route('admin.home') !!}"><img src="" class="cl-center" style="width: 100px" alter="canvas"></a>
    <ul class="header-inner">
        <li id="menu-trigger" data-trigger="#sidebar">
            <div class="line-wrap">
                <div class="line top"></div>
                <div class="line center"></div>
                <div class="line bottom"></div>
            </div>
        </li>
        <li class="logo">
            <a href="{!! route('admin.home') !!}"><img src="" alter="canvas" class="cl hidden-xs" style="width: 100px"></a>
        </li>
        <li class="pull-right">
            <ul class="top-menu">
                <li id="top-search">
                    <a href=""><i class="tm-icon zmdi zmdi-search"></i></a>
                </li>
                <li class="dropdown hidden-xs">
                    <a data-toggle="dropdown" href="javascript:void(0)"><i class="tm-icon zmdi zmdi-more-vert"></i></a>
                    <ul class="dropdown-menu dm-icon pull-right">
                        <li class="hidden-xs">
                            <a href="{!! route('admin.profile.index') !!}"><i class="zmdi zmdi-account"></i> Your Profile</a>
                        </li>
                        <li class="hidden-xs">
                            <a target="_blank" href="{!! route('home') !!}"><i class="zmdi zmdi-view-web"></i> View Site</a>
                        </li>
                        <li class="hidden-xs">
                            <a data-action="fullscreen" href=""><i class="zmdi zmdi-fullscreen"></i> Toggle Fullscreen</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="{{ route('logout') }}"><i class="zmdi zmdi-power"></i> Sign out</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
    </ul>


    <!-- Top Search Content -->
    <form role="form" method="GET" id="search" name="search" action="{!! route('admin.search.index') !!}">
        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
        <div id="top-search-wrap">
            <div class="tsw-inner">
                <i id="top-search-close" class="zmdi zmdi-arrow-left"></i>
                <input type="text" placeholder="Search" name="search">
            </div>
        </div>
    </form>
</header>

