@forelse($threads as $thread)
    <div class="card">
        <div class="card-header">
            <div class="level">
                <div class="flex">
                    <h4>
                        <a href=" {{ $thread->path() }}">
                            @if (auth()->user() && $thread->hasUpdateFor(auth()->user()))
                                <strong>
                                    {{ $thread->title }}                                            
                                </strong>
                            @else
                                {{ $thread->title }}
                            @endif
                        </a>
                    </h4>
                    <small>Posted By: 
                        <a href="{{ route('profile', $thread->creator)}}">
                            {{ $thread->creator->name }}
                        </a>
                    </small>
                </div>
                <strong>
                    <a href="{{ $thread->path() }}">
                        {{ $thread->replies_count }}
                        {{ str_plural('reply', $thread->replies_count) }}
                    </a>
                </strong>
            </div>
        </div>
        <div class="card-body">
            <article>
                <div class="body">
                    {{ $thread->body }}
                </div>
            <hr>
        </div>
    </div>
    <br>
@empty
    <p>No Results</p>
@endforelse
