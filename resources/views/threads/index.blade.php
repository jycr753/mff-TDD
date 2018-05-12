@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                @include('threads._list')

                {{ $threads->render() }}
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <div class="level">
                            <div class="flex">
                                Trending threads
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <article>
                            <div class="body">
                                @foreach ($trending as $thread)
                                    <div class="list-group">
                                        <a href="{{ $thread->path }}" class="list-group-item list-group-item-action">
                                            <small>{{ $thread->title }} </small>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </article>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
