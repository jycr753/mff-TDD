@extends('admin.layout.app')

@section('administration-content')   
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a class="button is-link is-rounded is-small" href="{{ route('admin.channels.create') }}">
                            <span class="icon">
                            <i class="fas fa-plus"></i>
                            </span>
                            <span>New Channel</span>
                        </a>
                        <a class="button is-link is-rounded is-small {{ Route::is('admin.dashboard.index') ? 'text-blue font-bold' : '' }}" href="{{ route('admin.dashboard.index') }}">
                                <span class="icon">
                                <i class="fas fa-tachometer-alt"></i>
                                </span>
                                <span>Dashboard</span>
                            </a>
                    </div>

                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Description</th>
                                <th>Threads</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($channels as $channel)
                                <tr>
                                    <td>{{$channel->name}}</td>
                                    <td>{{$channel->slug}}</td>
                                    <td>{{$channel->description}}</td>
                                    <td>{{ $channel->threads()->count() }}</td>
                                    <td>
                                        <a class="button is-danger is-rounded is-small">
                                            <span class="icon">
                                            <i class="fas fa-trash-alt"></i>
                                            </span>
                                            <span>Delete</span>
                                        </a>
                                        <a class="button is-success is-rounded is-small" href="/admin/channels/{{ $channel->slug }}/edit">
                                            <span class="icon">
                                            <i class="fas fa-pencil-alt"></i>
                                            </span>
                                            <span>Edit</span>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td>Nothing here.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <footer class="card-footer">
                        <a href="#" class="card-footer-item">Save</a>
                        <a href="#" class="card-footer-item">Edit</a>
                        <a href="#" class="card-footer-item">Delete</a>
                    </footer>
                </div>
            </div>
        </div>
    </div>
@endsection
