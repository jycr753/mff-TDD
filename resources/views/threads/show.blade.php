@extends('layouts.app')

@section('header')
    <link href="{{ asset('css/vendor/jquery.atwho.css') }}" rel="stylesheet">
@endsection

@section('content')
<thread-view :thread="{{ $thread }}" inline-template v-cloak>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                @include('threads._question')

                <replies @added="repliesCount++" @removed="repliesCount--"></replies>         
                
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <p>
                            This thread was published {{ $thread->created_at->diffForHumans() }} by
                            <a href="#">{{ $thread->creator->name }}</a>, and currently
                            has <span v-text="repliesCount"></span> {{ str_plural('comment', $thread->replies_count) }}
                        </p>

                        <p>
                            <subscribe-button :active="{{ json_encode($thread->isSubscribedTo) }}" v-if="signedIn"></subscribe-button>

                            <button class="btn btn-default ml-a" v-if="authorize('isAdmin')" @click="toggleLock">
                                <i :class="classes"></i>
                            </button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</thread-view>
@endsection
