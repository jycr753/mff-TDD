{{-- edit --}}
<div class="card" v-if="editing">
    <div class="card-header">
        <div class="level">
            <span class="flex">                 
                <input class="form-control" value="{{ $thread->title }}">
            </span>
        </div>
    </div>

    <div class="card-body">
        <textarea class="form-control">{{ $thread->body }}</textarea>
    </div>

    <div class="card-footer level">
        <div>
            <button class="btn btn-default btn-success btn-sm mr-1" @click="editing = true">
                <i class="fa fa-save"></i>
            </button>
        </div>
        <div>
            <button class="btn btn-default btn-danger btn-sm mr-1" @click="editing = false">
                <i class="fa fa-close"></i>
            </button>
        </div>
            @can('update', $thread)
                <form method="POST" action="{{ $thread->path() }}" class="ml-a">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}

                    <button type="submit" class="btn btn-default btn-danger btn-sm ml-2">
                        <i class="fa fa-trash"></i>
                    </button>

                </form>
            @endcan
    </div>
</div>

{{-- show --}}
<div class="card" v-else>
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
        </div>
    </div>

    <div class="card-body">
        {{ $thread->body }}
    </div>

    <div class="card-footer level">
        <div>
            <button class="btn btn-default btn-info btn-sm mr-1" @click="editing = true">
                <i class="fa fa-edit"></i>
            </button>
        </div>
    </div>
</div>