@extends('admin.layout.app')

@section('administration-content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Administrator</div>

                <div class="card-body">
                    <div class="columns is-mobile">
                        <div class="column">
                            <a class="button is-link is-rounded {{ Route::is('admin.dashboard.index') ? 'text-blue font-bold' : '' }}" href="{{ route('admin.dashboard.index') }}">
                                <span class="icon">
                                <i class="fas fa-tachometer-alt"></i>
                                </span>
                                <span>Dashboard</span>
                            </a>
                        </div>
                        <div class="column">
                            <a class="button is-link is-rounded {{ Route::is('admin.channels.index') ? 'text-blue font-bold' : '' }}" href="{{ route('admin.channels.index') }}">
                                <span class="icon">
                                <i class="fab fa-audible"></i>
                                </span>
                                <span>Channels</span>
                            </a>
                        </div>
                        <div class="column">3</div>
                        <div class="column">4</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection