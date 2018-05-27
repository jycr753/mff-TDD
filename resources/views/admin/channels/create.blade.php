@extends('admin.layout.app')

@section('administration-content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create new channel</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.channels.store') }}">
                            @include ('admin.channels._form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
