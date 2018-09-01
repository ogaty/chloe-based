<br>

  <div class="form-group">
      <div class="fg-line">
        <label class="fg-label">Tag Name</label>
        <input type="text" class="form-control" name="name" id="name" value="{{ $data['name'] }}" placeholder="Tag Name">
      </div>
  </div>

  <br>

<div class="form-group">
    <div class="fg-line">
      <label class="fg-label">Slut</label>
      <input type="text" class="form-control" name="slug" id="slug" value="{{ $data['slug'] }}" placeholder="Slug">
    </div>
</div>

<br>

<div class="form-group">
    <div class="fg-line">
        <label class="fg-label">Meta Description</label>
        <textarea class="form-control auto-size" id="meta_description" name="meta_description" placeholder="Meta Description">{{ $data['meta_description'] }}</textarea>
    </div>
</div>

<br>

<div class="form-group">
    <div class="fg-line">
        <label class="fg-label">Layout</label>
        <input type="text" class="form-control" name="layout" id="layout" value="{{ $data['layout'] }}" placeholder="Layout" disabled>
    </div>
</div>

<br>

<div class="form-group">
    <label class="radio radio-inline m-r-20">
        <input type="radio" name="reverse_direction" id="reverse_direction" @if (! $data['reverse_direction']) checked="checked" @endif value="0">
        <i class="input-helper"></i>
        Normal
    </label>

    <label class="radio radio-inline m-r-20">
        <input type="radio" name="reverse_direction" @if ($data['reverse_direction']) checked="checked" @endif value="1">
        <i class="input-helper"></i>
        Reverse
    </label>
</div>

<br>
