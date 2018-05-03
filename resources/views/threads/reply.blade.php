<reply :attributes="{{ $reply }}" inline-template v-cloak>
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
                        <button type="submit" class="btn btn-outline-success btn-sm" {{ $reply->isFavorited() ? 'disabled' : '' }}>
                            <i class="fa fa-thumbs-up"></i>
                            {{ $reply->favorites_count }}
                            {{ str_plural('Like', $reply->favorites_count) }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" id="" cols="30" rows="3" v-model="body"></textarea>
                </div>
                <button class="btn btn-default btn-outline-success btn-sm mr-1" @click="update">
                    <i class="fa fa-save"></i>
                </button>
                <button class="btn btn-default btn-outline-danger btn-sm mr-1" @click="editing = false">
                    <i class="fa fa-close"></i>
                </button>
            </div>
            <div v-else v-text="body"></div>
        </div>
        @can('update', $reply)
            <div class="card-footer level">
                <button class="btn btn-default btn-info btn-sm mr-1" @click="editing = true">
                    <i class="fa fa-edit"></i>
                </button>

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
</reply>
