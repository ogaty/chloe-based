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
      <label class="fg-label">Slug</label>
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
    <label for="reverse_direction" class="info-label"><span class="info-label">Normal</span></label>
    <input {{ $data['reverse_direction'] ? 'checked' : '' }} type="checkbox" name="reverse_direction" id="reverse_direction">
    <label for="reverse_direction" class="toggle-label"></label>
    <label for="reverse_direction" class="info-label" style="margin-left: 20px; margin-right: 0"><span class="label label-primary">Reverse</span></label>
</div>

<br>
