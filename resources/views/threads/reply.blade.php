<div id="reply-{{ $reply->id }}" class="card">
    <div class="card-header">
        <div class="level">
            <h5 class="flex">
                <a href="/profiles/{{ $reply->owner->name }}">
                    {{ $reply->owner->name }}</a> said
                {{ $reply->created_at->diffForHumans() }} ...
            </h5>
            <div>
                <form method="POST" action="/replies/{{ $reply->id }}/favorites">
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-default" {{ $reply->isFavorited() ? 'disabled' : '' }}>
                        <i class="fa fa-thumbs-up"></i>
                        {{ $reply->favorites_count }}
                        {{ str_plural('Like', $reply->favorites_count) }}
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="card-body">
        {{ $reply->body }}
    </div>
    @can('update', $reply)
        <div class="card-footer">
            <form method="POST" action="/replies/{{ $reply->id }}">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}

                <button type="submit" class="btn btn-default btn-danger btn-sm">
                    <i class="fa fa-trash"></i>
                </button>

            </form>
        </div>
    @endcan
</div>
<br>
