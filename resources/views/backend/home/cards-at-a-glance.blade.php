<div class="card half">
    <div class="card__header">
        <h2>At a Glance
            <small>Quick snapshot of your site:</small>
        </h2>
</div>
        <ul class="glance-list">
            <li>
                <i class="zmdi zmdi-collection-bookmark"></i> <a href="{!! route('admin.post.index') !!}">{!! count($data['posts']) !!}{!! str_plural(' Post', count($data['posts'])) !!}</a>
            </li>
            <li>
                <i class="zmdi zmdi-labels"></i> <a href="{!! route('admin.tag.index') !!}">{!! count($data['tags']) !!}{!! str_plural(' Tag', count($data['tags'])) !!}</a>
            </li>
            <li>
                <i class="zmdi zmdi-accounts-alt"></i> <a href="{!! route('admin.user.index') !!}">{!! count($data['users']) !!}{!! str_plural(' User', count($data['users'])) !!}</a>
            </li>
            <li>
                <i class="zmdi zmdi-globe-alt"></i> <a href="{!! route('admin.tools') !!}"><span class="label label-success">Status: {!! strtoupper('Active') !!}</span></a>
            </li>
            <li>
                @if(isset($data['analytics']) && strlen($data['analytics']))
                    <i class="zmdi zmdi-trending-up"></i> <a href="{!! route('admin.setting.index') !!}"><span class="label label-success">Google Analytics: {!! strtoupper('Enabled') !!}</span></a>
                @else
                    <i class="zmdi zmdi-trending-up"></i> <a href="{!! route('admin.setting.index') !!}"><span class="label label-danger">Google Analytics: {!! strtoupper('Disabled') !!}</span></a>
                @endif
            </li>
        </ul>
</div>
