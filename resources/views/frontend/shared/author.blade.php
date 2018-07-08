<div id="author-content">
    <h4 id="author-name">オガティ</h4>
    <div class="author-description">
    フリーのシステムエンジニア。エンジニア占星術師という肩書を持ってフリーランス活動を行う。
    </div>
    <span class="small">
        {{ $user->bio }}
        <br>
        @if (!empty($user->twitter))
            <a href="https://twitter.com/{{ $user->twitter }}" target="_blank" id="social"><i class="fa fa-fw fa-twitter text-muted"></i></a>
        @endif
        @if (!empty($user->facebook))
            <a href="https://facebook.com/{{ $user->facebook }}" target="_blank" id="social"><i class="fa fa-fw fa-facebook text-muted"></i></a>
        @endif
        @if (!empty($user->github))
            <a href="https://github.com/{{ $user->github }}" target="_blank" id="social"><i class="fa fa-fw fa-github text-muted"></i></a>
        @endif
        @if(!empty($user->linkedin))
            <a href="https://linkedin.com/in/{{ $user->linkedin }}" target="_blank" id="social"><i class="fa fa-fw fa-linkedin text-muted"></i></a>
        @endif
    </span>
</div>
