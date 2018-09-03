@if(Route::is('admin.post.create'))
    <form class="keyboard-save" role="form" method="POST" id="postCreate" action="{!! route('admin.post.store') !!}">
    <input type="hidden" name="user_id" value="{!! Auth::guard()->user()->id !!}">
    <input type="hidden" name="custom_code" value="blog">
@else
    <form class="keyboard-save" role="form" method="POST" id="postUpdate" action="{!! route('admin.post.update', $id) !!}">
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="user_id" value="{!! Auth::guard()->user()->id !!}">
@endif
        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
        <div class="card-container">
            <div class="card-main">
            <div class="card">
                <div class="card__header">
                    @include('backend.shared.partials.errors')
                    @include('backend.shared.partials.success')

                    @if(Route::is('admin.post.create'))
                        <ol class="breadcrumb">
                            <li class="breadcrumb__parent"><a href="{!! route('admin.home') !!}">Home</a></li>
                            <li class="breadcrumb__parent"><a href="{!! route('admin.post.index') !!}">Posts</a></li>
                            <li class="breadcrumb__active">New Post</li>
                        </ol>
                        <h2>Create a New Post</h2>
                    @else
                        <ol class="breadcrumb">
                            <li class="breadcrumb__parent"><a href="{!! route('admin.home') !!}">Home</a></li>
                            <li class="breadcrumb__parent"><a href="{!! route('admin.post.index') !!}">Posts</a></li>
                            <li class="breadcrumb__active">Edit Post</li>
                        </ol>
                        <h2>
                            Edit <em>{!! $data->title !!}</em>
                            <small>Last edited on {!! Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->updated_at)->format('Y-m-d H:i:s') !!}</small>
                        </h2>
                    @endif
                </div>
                <div class="card__body">
                    <br>
                    <div class="form-group">
                        <div class="fg-line">
                            <input type="text" class="form-control" name="title" id="title" value="{{ $data->title }}" placeholder="Title">
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <div class="fg-line">
                            <input type="text" class="form-control" name="slug" id="slug" value="{{ $data->slug }}" placeholder="Slug">
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <div class="fg-line">
                            <textarea id="editor" name="content_raw" placeholder="Content">{{ $data->content_raw }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <div class="card-sub">
            <div class="card">
                <div class="card__header">
                    <h2>Publishing</h2>
                    <hr>
                </div>
                <div class="card__body">
                    <br>
                    <label><i class="zmdi zmdi-eye"></i>&nbsp;&nbsp;Status</label>
                    <div class="form-group" style="padding-top: 10px">
                        <div class="" data-ts-color="blue">
                            <label for="is_published" class="info-label"><span class="info-label">Draft</span></label>
                            <input {{ $data->is_published ? 'checked' : '' }} type="checkbox" name="is_published" id="is_published">
                            <label for="is_published" class="toggle-label"></label>
                            <label for="is_published" class="info-label" style="margin-left: 20px; margin-right: 0"><span class="label label-primary">Published</span></label>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <div class="fg-line">
                            <label><i class="zmdi zmdi-calendar"></i>&nbsp;&nbsp;Published at</label>
                            <input class="form-control datetime-picker" name="published_at" id="published_at" type="text" value="{{ $data->published_at }}" placeholder="YYYY/MM/DD HH:MM:SS" data-mask="0000/00/00 00:00:00">
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <div class="fg-line">
                            <input type="hidden" name="layout" id="layout" value="{{ $data->layout }}" placeholder="Layout" disabled>
                        </div>
                    </div>
                    <br>
                    @if(!Route::is('admin.post.create'))
                        <div class="form-group">
                            <div class="fg-line">
                                <label class="fg-label"><i class="zmdi zmdi-link"></i>&nbsp;&nbsp;Permalink</label><br>
                                <a href="{!! route('front.post', $data->slug) !!}" target="_blank" name="permalink">{!! route('front.post', $data->slug) !!}</a>
                            </div>
                        </div>
                        <br>
                    @endif
                    <div class="form-group">
                        @if(Route::is('admin.post.create'))
                            <button type="submit" class="btn btn-primary btn-icon-text">
                                <i class="zmdi zmdi-floppy"></i> Publish
                            </button>
                            &nbsp;
                            <a href="{!! route('admin.post.index') !!}">
                                <button type="button" class="btn btn-link">Cancel</button>
                            </a>
                        @else
                            <button type="submit" class="btn btn-primary btn-icon-text" name="action" value="continue">
                                <i class="zmdi zmdi-floppy"></i> Update
                            </button>
                            &nbsp;
                            <button type="button" class="btn btn-danger btn-icon-text" data-toggle="modal" data-target="#modal-delete" id="confirmDelete">
                                <i class="zmdi zmdi-delete"></i> Delete
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card__header">
                    <h2>Featured Image</h2>
                    <hr>
                </div>
                <div class="card__body card-padding">
                    <br>
                    <div class="form-group">
                        <div class="fg-line">
                            <div class="input-group">
                                <input type="text" class="form-control" name="page_image" id="page_image" alt="Image thumbnail" placeholder="Page Image" v-model="pageImage">
                                <span class="input-group-btn" style="margin-bottom: 11px">
                                    <button style="margin-bottom: -5px" type="button" class="" onclick="openFromPageImage()">Select Image</button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="visible-sm space-10"></div>
                    <div>
                        <img v-if="pageImage" class="img img-responsive" id="page-image-preview" style="margin-top: 3px; max-height:100px;" :src="pageImage">
                        <span v-else class="text-muted small">No Image Selected</span>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card__header">
                    <h2>Tags</h2>
                    <hr>
                </div>
                <div class="card__body card-padding">
                    <br>
                    <div class="form-group">
                        <div class="fg-line">
                            @if (count($allTagIds) > 0)
                                <select name="tags[]" id="tags" class="selectpicker" multiple>
                                    <!-- 
                                        {{ var_dump($postTags)}}
-->
                                    @foreach ($allTagIds as $tag)
                                        <option @if (in_array($tag['id'], $postTags)) selected @endif value="{!! $tag['id'] !!}">{!! $tag['slug'] !!}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card__header">
                    <h2>SEO Description</h2>
                    <hr>
                </div>
                <div class="card__body card-padding">
                    <br>
                    <div class="form-group">
                        <div class="fg-line">
                            <textarea class="form-control auto-size" name="meta_description" id="meta_description" style="resize: vertical" placeholder="Meta Description">{!! $data->meta_description !!}</textarea>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
</form>

<script>
function openFromPageImage() {
    $(".post-media-modal").addClass("visible");
}
</script>
