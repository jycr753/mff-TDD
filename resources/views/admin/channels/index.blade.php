@extends('admin.layout.app')

@section('administration-content')   
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Channel
                    <a class="btn btn-sm btn-default" href="{{ route('admin.channels.create') }}">
                        New Channel 
                        <span class="glyphicon glyphicon-plus"></span>
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
                                    <td>{{ count($channel->threads) }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-danger mr-1" @click="destroy">Delete</button>
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
                </div>
            </div>
        </div>
    </div>
@endsection
