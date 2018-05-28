@extends('admin.layout.app')

@section('administration-content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit {{$channel->slug}} channel</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.channels.update', ['channel' => $channel->slug]) }}">
                            {{ method_field('PATCH') }}
                            @include ('admin.channels._form', ['btnText' => 'Update'])
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
