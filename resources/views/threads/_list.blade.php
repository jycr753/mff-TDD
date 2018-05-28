@forelse($threads as $thread)
    <div class="card">
        <div class="card-header">
            <div class="level">
                <div class="flex">
                    <h4>
                        <img src="{{ $thread->creator->avatar_path }}" 
                            alt="{{ $thread->creator->name }}" 
                            width="25" 
                            height="25" 
                            class="mr-1">
                            
                        <a href=" {{ $thread->path() }}">
                            @if ($thread->pinned)
                                <i class="fas fa-map-pin"></i>
                            @endif
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
            <div class="body">
                {!! $thread->body !!}
            </div>
        </div>
        <div class="card-footer">
            <div class="body">
                {{ $thread->visits()->count() }} Visits
            </div>
        </div>
    </div>
    <br>
@empty
    <p>No Results</p>
@endforelse
