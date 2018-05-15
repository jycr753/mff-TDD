@extends('layouts.app')

@section('header')
    <link href="{{ asset('css/vendor/jquery.atwho.css') }}" rel="stylesheet">
@endsection

@section('content')
<thread-view :data-replies-count="{{ $thread->replies_count }}" :data-locked="{{ $thread->locked }}" inline-template>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="level">
                            <span class="flex">                 
                                Posted by 
                                <a href="/profiles/{{ $thread->creator->name }}">
                                    {{ $thread->creator->name }}
                                    <img src="{{ $thread->creator->avatar_path }}" 
                                        alt="{{ $thread->creator->name }}" 
                                        width="15" 
                                        height="15" 
                                        class="mr-1">    
                                </a> <br>
                                <small><strong>{{ $thread->title }}</strong></small>
                            </span>
                            
                            <div>
                                @can('update', $thread)
                                    <form method="POST" action="{{ $thread->path() }}">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}

                                        <button type="submit" class="btn btn-default btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </button>

                                    </form>
                                @endcan
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                       {{ $thread->body }}
                    </div>
                </div>

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

                            <button class="btn btn-default ml-a" v-if="authorize('isAdmin') && ! locked" @click="locked = true">
                                <i class="fa fa-unlock"></i>
                            </button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</thread-view>
@endsection
