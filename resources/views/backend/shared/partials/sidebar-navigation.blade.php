<aside id="sidebar" class="sidebar">
    <div class="profile-menu">
        <a href="">
            <div class="profile-info">
                {{ Auth::guard()->user()->display_name }}
                <div class="profile-triangle">
                <i class="zmdi zmdi-caret-down"></i>
                </div>
            </div>
        </a>
        <ul class="main-profile-menu">
	    <li @if (Route::is('admin.profile.index')) class="active" @endif class="sidebar-list">
		<a href="{!! route('admin.profile.index') !!}" class="sidebar-list__link"><i class="sidebar-list__link--icon zmdi zmdi-account"></i> Your Profile</a>
            </li>
	    <li class="sidebar-list">
		<a href="{{ route('logout') }}" name="logout" class="sidebar-list__link"><i class="sidebar-list__link--icon zmdi zmdi-power"></i> Sign out</a>
            </li>
        </ul>
    </div>

    <ul class="main-menu main-ul">
        <li @if (Route::is('admin.home')) class="active sidebar-list" @else class="sidebar-list" @endif><a href="{!! route('admin.home') !!}" class="sidebar-list__link"><i class="sidebar-list__link--icon zmdi zmdi-home"></i> Home</a></li>
        <li class="sidebar-list"><a href="{!! route('home') !!}" class="sidebar-list__link"><i class="sidebar-list__link--icon zmdi zmdi-home"></i> View Site</a></li>

        <li class="sub-menu @if (Route::is('admin.post.index') || Route::is('admin.post.create') || Route::is('admin.post.edit'))active toggled @endif sidebar-list">
            <a href="" class="sidebar-list__link submenu-toggle"><i class="sidebar-list__link--icon zmdi zmdi-collection-bookmark"></i> Posts                        <span><ion-icon name="arrow-dropdown"></ion-icon></span></a>
            <ul>
                <li><a href="{!! route('admin.post.index') !!}" @if (Route::is('admin.post.index') || Route::is('admin.post.edit')) class="active sub-menu__link" @else class="sub-menu__link" @endif>All Posts 
                        <span class="badge">{!! App\Models\Post::where('custom_code', 'blog')->count() !!}</span>
                    </a>
                </li>
                <li><a href="{!! route('admin.post.create') !!}" @if (Route::is('admin.post.create')) class="active sub-menu__link" @endif class="sub-menu__link">Add New
                </a></li>
            </ul>
        </li>

        <li class="sub-menu @if (Route::is('admin.tag.index') || Route::is('admin.tag.create') || Route::is('admin.tag.edit'))active toggled @endif sidebar-list">
            <a href="" data-ma-action="submenu-toggle" class="sidebar-list__link submenu-toggle"><i class="sidebar-list__link--icon zmdi zmdi-labels"></i> Tags
            <span><ion-icon name="arrow-dropdown"></ion-icon></span></a>
            <ul>
                <li><a href="{!! route('admin.tag.index') !!}" @if (Route::is('admin.tag.index') || Route::is('admin.tag.edit')) class="active" @endif class="sub-menu__link">All Tags <span class="badge">{!! App\Models\Tag::count() !!}</span></a></li>
                <li><a href="{!! route('admin.tag.create') !!}" @if (Route::is('admin.tag.create')) class="active sub-menu__link" @endif class="sub-menu__link">Add New</a></li>
            </ul>
        </li>

        <li @if (Request::is('admin/upload')) class="active sidebar-list" @endif><a href="{!! route('admin.upload') !!}" class="sidebar-list__link"><i class="sidebar-list__link--icon zmdi zmdi-collection-folder-image"></i> Media</a></li>

        @if(\App\Models\User::isAdmin(Auth::guard()->user()->role))
            <li class="sub-menu @if (Route::is('admin.user.index') || Route::is('admin.user.create') || Route::is('admin.user.edit'))active toggled @endif sidebar-list sidebar-toggle">
                <a href="" data-ma-action="submenu-toggle" class="sidebar-list__link submenu-toggle"><i class="sidebar-list__link--icon zmdi zmdi-accounts-alt"></i> Users
                <span id="xxx"><ion-icon name="arrow-dropdown"></ion-icon></span></a>
                <ul>
                    <li><a href="{!! route('admin.user.index') !!}" @if (Route::is('admin.user.index') || Route::is('admin.user.edit')) class="active sub-menu__link" @endif class="sub-menu__link">All Users <span class="badge">{!! App\Models\User::count() !!}</span></a></li>
                    <li><a href="{!! route('admin.user.create') !!}" @if (Route::is('admin.user.create')) class="active sub-menu__link" @endif class="sub-menu__link">Add New</a></li>
                </ul>
            </li>
            <li @if (Route::is('admin.setting.index')) class="active" @endif class="sidebar-list"><a href="{!! route('admin.setting.index') !!}" class="sidebar-list__link"><i class="sidebar-list__link--icon zmdi zmdi-settings"></i> Settings</a></li>
        @endif
    </ul>
</aside>
<!--
$("#xxx").html("<ion-icon name=\"arrow-dropdown\"></ion-icon>");
-->
