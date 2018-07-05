<aside id="sidebar" class="sidebar c-overflow">
    <div class="profile-menu">
        <a href="">
            <div class="profile-pic">
                <img src="https://www.gravatar.com/avatar/{!! md5(Auth::guard()->user()->email) !!}?d=identicon">
            </div>
            <div class="profile-info">
                {{ Auth::guard()->user()->display_name }}
                <i class="zmdi zmdi-caret-down"></i>
            </div>
        </a>
        <ul class="main-menu profile-ul">
            <li @if (Route::is('admin.profile.index')) class="active" @endif><a href="{!! route('admin.profile.index') !!}"><i class="zmdi zmdi-account"></i> Your Profile</a></li>
            <li><a href="/auth/logout" name="logout"><i class="zmdi zmdi-power"></i> Sign out</a></li>
        </ul>
    </div>
    <ul class="main-menu main-ul">
        <li @if (Route::is('admin')) class="active" @endif><a href="{!! route('admin') !!}"><i class="zmdi zmdi-home"></i> Home</a></li>
        <li><a href="{!! route('home') !!}"><i class="zmdi zmdi-home"></i> View Site</a></li>
        <li class="sub-menu @if (Route::is('admin.post.index') || Route::is('admin.post.create') || Route::is('admin.post.edit'))active toggled @endif">
            <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-collection-bookmark"></i> Posts</a>
            <ul>
                <li><a href="{!! route('admin.post.index') !!}" @if (Route::is('admin.post.index') || Route::is('admin.post.edit')) class="active" @endif>All Posts <span class="label label-default label-totals">{!! App\Models\Post::where('custom_code', 'blog')->count() !!}</span></a></li>
                <li><a href="{!! route('admin.post.create') !!}" @if (Route::is('admin.post.create')) class="active" @endif>Add New</a></li>
            </ul>
        </li>
        <li class="sub-menu @if (Route::is('admin.techs.index') || Route::is('admin.techs.create') || Route::is('admin.techs.edit'))active toggled @endif">
            <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-collection-bookmark"></i> Techs</a>
            <ul>
                <li><a href="{!! route('admin.techs.index') !!}" @if (Route::is('admin.techs.index') || Route::is('admin.techs.edit')) class="active" @endif>All Techs <span class="label label-default label-totals">{!! App\Models\Post::where('custom_code', 'techs')->count() !!}</span></a></li>
                <li><a href="{!! route('admin.techs.create') !!}" @if (Route::is('admin.techs.create')) class="active" @endif>Add New</a></li>
            </ul>
        </li>
        <li class="sub-menu @if (Route::is('admin.games.index') || Route::is('admin.games.create') || Route::is('admin.games.edit'))active toggled @endif">
            <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-collection-bookmark"></i> Games</a>
            <ul>
                <li><a href="{!! route('admin.games.index') !!}" @if (Route::is('admin.games.index') || Route::is('admin.games.edit')) class="active" @endif>All Games <span class="label label-default label-totals">{!! App\Models\Post::where('custom_code', 'games')->count() !!}</span></a></li>
                <li><a href="{!! route('admin.games.create') !!}" @if (Route::is('admin.games.create')) class="active" @endif>Add New</a></li>
            </ul>
        </li>
        <li class="sub-menu @if (Route::is('admin.sabian.index') || Route::is('admin.sabian.create') || Route::is('admin.sabian.edit'))active toggled @endif">
            <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-collection-bookmark"></i> Sabian</a>
            <ul>
                <li><a href="{!! route('admin.sabian.index') !!}" @if (Route::is('admin.sabian.index') || Route::is('admin.sabian.edit')) class="active" @endif>All Sabians <span class="label label-default label-totals">{!! App\Models\Post::where('custom_code', 'sabian')->count() !!}</span></a></li>
                <li><a href="{!! route('admin.sabian.create') !!}" @if (Route::is('admin.sabian.create')) class="active" @endif>Add New</a></li>
            </ul>
        </li>
        <li class="sub-menu @if (Route::is('admin.tag.index') || Route::is('admin.tag.create') || Route::is('admin.tag.edit'))active toggled @endif">
            <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-labels"></i> Tags</a>
            <ul>
                <li><a href="{!! route('admin.tag.index') !!}" @if (Route::is('admin.tag.index') || Route::is('admin.tag.edit')) class="active" @endif>All Tags <span class="label label-default label-totals">{!! App\Models\Tag::count() !!}</span></a></li>
                <li><a href="{!! route('admin.tag.create') !!}" @if (Route::is('admin.tag.create')) class="active" @endif>Add New</a></li>
            </ul>
        </li>
        <li @if (Request::is('admin/upload')) class="active" @endif><a href="{!! route('admin.upload') !!}"><i class="zmdi zmdi-collection-folder-image"></i> Media</a></li>
        @if(\App\Models\User::isAdmin(Auth::guard()->user()->role))
            <li class="sub-menu @if (Route::is('admin.user.index') || Route::is('admin.user.create') || Route::is('admin.user.edit'))active toggled @endif">
                <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-accounts-alt"></i> Users</a>
                <ul>
                    <li><a href="{!! route('admin.user.index') !!}" @if (Route::is('admin.user.index') || Route::is('admin.user.edit')) class="active" @endif>All Users <span class="label label-default label-totals">{!! App\Models\User::count() !!}</span></a></li>
                    <li><a href="{!! route('admin.user.create') !!}" @if (Route::is('admin.user.create')) class="active" @endif>Add New</a></li>
                </ul>
            </li>
            <li @if (Route::is('admin.tools')) class="active" @endif><a href="{!! route('admin.tools') !!}"><i class="zmdi zmdi-wrench"></i> Tools</a></li>
            <li @if (Route::is('admin.settings')) class="active" @endif><a href="{!! route('admin.settings') !!}"><i class="zmdi zmdi-settings"></i> Settings</a></li>
        @endif
        <li @if (Route::is('admin.help')) class="active" @endif><a href="{!! route('admin.help') !!}"><i class="zmdi zmdi-help"></i> Help</a></li>
    </ul>
</aside>
