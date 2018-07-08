<div class="card">
    <div class="card-header">
        <h2>Welcome!
            <small>Here are some helpful links we've gathered to get you started:
            </small>
        </h2>
    </div>
    <div class="card-body card-padding">
        <div class="row">
            <div class="col-sm-4">
                <h5>Getting Started</h5>
                <br>
                <a href="{!! route('admin.profile.index') !!}" class="btn btn-primary btn-icon-text"><i class="zmdi zmdi-account"></i> Update your Profile</a>
                <br>
                <br>
                <a href="{!! route('admin.setting.index') !!}" class="btn btn-primary btn-icon-text"><i class="zmdi zmdi-settings"></i> Configure your Settings</a>
                <br>
                <br>
            </div>
            <div class="col-sm-4">
                <h5>Next Steps</h5>
                <ul class="getting-started">
                    <li><i class="zmdi zmdi-comment-edit"></i> <a href="{!! route('admin.post.create') !!}">Write your first blog post</a></li>
                    <li><i class="zmdi zmdi-plus-circle"></i> <a href="{!! route('admin.tag.create') !!}">Create a new tag</a></li>
                    <li><i class="zmdi zmdi-view-web"></i> <a href="{!! route('home') !!}" target="_blank">View your site</a></li>
                </ul>
                <br>
            </div>
            <div class="col-sm-4">
                <h5>More Actions</h5>
                <ul class="getting-started">
                </ul>
                <br>
            </div>
        </div>

    </div>
</div>
