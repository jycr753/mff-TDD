@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a href="#">{{ $thread->creator->name }}</a> posted by
                        {{ $thread->title }}
                    </div>

                    <div class="card-body">
                       {{ $thread->body }}
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                @foreach($thread->replies as $reply)
                    @include('threads.reply')
                @endforeach
            </div>
        </div>

        @if(auth()->check())
            <div class="row justify-content-center">
                <div class="col-md-8 col-md-offset-2">
                    <form method="POST" action="{{ $thread->path().'/replies' }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="body">Body</label>
                            <textarea name="body" id="body" class="form-control" placeholder="Have somethign to say!" rows="5"></textarea>
                        </div>
                        <button type="submit" class="btn btn-default">Submit</button>
                    </form>
                </div>
            </div>
        @else
            <p class="text-center">Please <a href="{{ route('login') }}">Sign in</a> to Reply</p>
        @endif
    </div>
@endsection
