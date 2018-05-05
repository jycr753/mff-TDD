@extends('layouts.app')

@section('content')
<thread-view :initial-replies-count="{{ $thread->replies_count }}" inline-template>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="level">
                            <span class="flex">
                                <a href="/profiles/{{ $thread->creator->name }}">{{ $thread->creator->name }}</a> posted by
                                {{ $thread->title }}
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

                <replies :data="{{ $thread->replies }}"
                            @added="repliesCount++" 
                            @removed="repliesCount--">

                </replies>

                <br>
                <!-- {{ $replies->links() }} -->           
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <p>
                            This thread was published {{ $thread->created_at->diffForHumans() }} by
                            <a href="#">{{ $thread->creator->name }}</a>, and currently
                            has <span v-text="repliesCount"></span> {{ str_plural('comment', $thread->replies_count) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</thread-view>
@endsection
