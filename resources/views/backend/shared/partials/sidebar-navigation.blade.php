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
        <li @if (Route::is('admin.home')) class="active" @endif><a href="{!! route('admin.home') !!}"><i class="zmdi zmdi-home"></i> Home</a></li>
        <li><a href="{!! route('home') !!}"><i class="zmdi zmdi-home"></i> View Site</a></li>
        <li class="sub-menu @if (Route::is('admin.post.index') || Route::is('admin.post.create') || Route::is('admin.post.edit'))active toggled @endif">
            <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-collection-bookmark"></i> Posts</a>
            <ul>
                <li><a href="{!! route('admin.post.index') !!}" @if (Route::is('admin.post.index') || Route::is('admin.post.edit')) class="active" @endif>All Posts <span class="label label-default label-totals">{!! App\Models\Post::where('custom_code', 'blog')->count() !!}</span></a></li>
                <li><a href="{!! route('admin.post.create') !!}" @if (Route::is('admin.post.create')) class="active" @endif>Add New</a></li>
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
            <li @if (Route::is('admin.setting.index')) class="active" @endif><a href="{!! route('admin.setting.index') !!}"><i class="zmdi zmdi-settings"></i> Settings</a></li>
        @endif
    </ul>
</aside>
