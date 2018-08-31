<div id="author-content">
    <h4 id="author-name">{{ $user->name }}</h4>
    <div class="author-description">
        {!! $user->bio !!}
    </div>
    <span class="small">
        @if (!empty($user->twitter))
            <a href="https://twitter.com/{{ $user->twitter }}" target="_blank" id="social"><i class="fa fa-fw fa-twitter text-muted"></i></a>
        @endif
        @if (!empty($user->facebook))
            <a href="https://facebook.com/{{ $user->facebook }}" target="_blank" id="social"><i class="fa fa-fw fa-facebook text-muted"></i></a>
        @endif
        @if (!empty($user->github))
            <a href="https://github.com/{{ $user->github }}" target="_blank" id="social"><i class="fa fa-fw fa-github text-muted"></i></a>
        @endif
    </span>
</div>
