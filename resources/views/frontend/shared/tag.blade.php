{{-- displayed in top of index, this is not in each post. --}}
@if (isset($tag->title))
    <hr style="width: 60%">
    <p class="tag-link"><i class="fa fa-fw fa-tag"></i> Tagged in <a href="#">{{ $tag->title or '' }}</a></p>
    <p class="tag-subtitle">" {{ $tag->subtitle }} "</p>
    <hr style="width: 60%">
@endif
