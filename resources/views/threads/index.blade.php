@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                @forelse($threads as $thread)
                <div class="card">
                    <div class="card-header">
                        <div class="level">
                            <h4 class="flex">
                                <a href=" {{ $thread->path() }}">
                                    {{ $thread->title }}
                                </a>
                            </h4>
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
                @empty
                    <p>No Results</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
