@extends('layouts.app')

@section('content')
    <ais-index
        app-id="{{ config('scout.algolia.id') }}"
        api-key="{{ config('scout.algolia.key') }}"
        index-name="threads"
        query={{ request('q') }}>

    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <ais-results>
                        <template scope="{ result }">
                            <div class="card-header">
                                <div class="level">
                                    <div class="flex">
                                        <h4>
                                            <a :href="result.path">
                                                <ais-highlight :result="result" attribute-name="title"></ais-highlight>
                                            </a>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="body" v-text="result.body"></div>
                            </div>
                            <br>
                        </template>
                    </ais-results>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <div class="level">
                            <div class="flex">
                                Search
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <article>
                            <div class="body">
                                <div class="form-group">
                                    <ais-search-box>
                                        <ais-input placeholder="Find a thread..." autofocus="true" class="form-control"></ais-input>
                                    </ais-search-box>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
                <br>
                <div class="card">
                    <div class="card-header">
                        <div class="level">
                            <div class="flex">
                                Different channel
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <article>
                            <div class="body">
                                <div class="form-group">
                                    <ais-refinement-list attribute-name="channel.name"></ais-refinement-list>
                                </div>
                            </div>
                        </article>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </ais-index>
@endsection
