<div class="card-half">
    <div class="card__header">
        <h2>Quick Draft
            <small>Save a quick draft post:</small>
        </h2>
    </div>

    <div class="quick-draft">
        @include('backend.shared.partials.errors')
        @include('backend.shared.partials.success')

        <form role="form" method="POST" id="postCreate" action="{{ route('admin.post.store') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            @include('backend.home.partials.form')

            <div class="form-group">
                <button type="submit" class="card__button"><i class="zmdi zmdi-floppy"></i> Save Draft</button>
            </div>
        </form>
    </div>
</div>
