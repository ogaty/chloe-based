<input type="hidden" name="user_id" value="{{ Auth::guard()->user()->id }}">

<div class="form-group">
    <div class="fg-line">
        <input type="text" class="form-control" name="title" id="title"  placeholder="Title">
    </div>
</div>

<div class="form-group hidden">
    <div class="fg-line">
        <input type="text" class="form-control" name="slug" id="slug" placeholder="Post Slug">
    </div>
</div>

<div class="form-group">
    <div class="fg-line">
        <input type="text" class="form-control" name="subtitle" id="subtitle" placeholder="Subtitle">
    </div>
</div>

<div class="form-group">
    <div class="fg-line">
        <textarea class="form-control auto-size" id="editor" name="content" placeholder="What's on your mind?"></textarea>
    </div>
</div>

<input name="published_at" id="published_at" type="hidden" value="{{ date('Y-m-d G:i:s') }}">

<input type="hidden" name="is_published" value="0">

<input type="hidden" name="layout" id="layout" value="{{ config('blog.post_layout') }}">
