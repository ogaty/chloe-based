<div class="container">
    <div class="footer-wrap">
        <div class="">
            <div class="">
                <hr>
                <p class="small">project ogatism</p>
            </div>
        </div>
    </div>
</div>

<!-- scroll to top button -->
@if (isset($posts) && count($posts) > 1)
<span id="top-link-block" class="hidden hover-button affix-top">
    <a id="scroll-to-top" href="#top">SCROLL TO TOP</a>
</span>
@endif

@if (!empty(\App\Models\Settings::gaId()))
    @include('frontend.shared.analytics')
@endif
