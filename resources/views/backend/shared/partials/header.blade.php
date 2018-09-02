<div class="header clearfix">
    <div class="header__logo--pc">
        <a href="{!! route('admin.home') !!}">
            <img src="/chloe.png">
        </a>
    </div>
    <div id="menu-trigger">
        <ion-icon name="menu" onclick="sideToggle()"></ion-icon>
    </div>
    <div class="header__logo--sm">
        <a href="{!! route('admin.home') !!}">
            <img src="/chloe.png">
        </a>
    </div>
    <div class="header__right">
        <div class="user-wrap">
            <ion-icon name="more" onclick="userMenu()"></ion-icon>
        </div>
        <div class="search-wrap">
            <ion-icon name="search" onclick="searchMenu()"></ion-icon>
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

