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
                                Search
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <article>
                            <div class="body level">
                                <form method="GET" action="/threads/search">
                                    <div class="col-md-8 form-group">
                                        <input name="q" type="text" class="form-control" placeholder="Search">
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <button class="btn btn-default">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </article>
                    </div>
                </div>
                <br>
                @if (count($trending))
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
                @endif
            </div>
        </div>
    </div>
@endsection
