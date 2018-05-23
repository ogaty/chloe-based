<div id="header-top">
    <div class="container clearfix">
        <form id="header-top--search" role="search" method="get" action="/search/">
            <button type="submit" id="submit-button">
                 <i class="fa fa-search"></i>
            </button>
            <input type="text" name="query" placeholder="Type to Search..." class="">
        </form>
        <ul class="header-top--social">
            @if (!empty($socialHeaderIconsUser->twitter))
                <li>
                    <a href="http://twitter.com/{{ $socialHeaderIconsUser->twitter }}" target="_blank" id="social"><i class="fa fa-twitter"></i></a>
                </li>
            @endif
            @if (!empty($socialHeaderIconsUser->facebook))
                <li>
                    <a href="http://facebook.com/{{ $socialHeaderIconsUser->facebook }}" target="_blank" id="social"><i class="fa fa-facebook"></i></a>
                </li>
            @endif
            @if (!empty($socialHeaderIconsUser->github))
                <li>
                    <a href="http://github.com/{{ $socialHeaderIconsUser->github }}" target="_blank" id="social"><i class="fa fa-github"></i></a>
                </li>
            @endif
        </ul>
    </div>
</div>
