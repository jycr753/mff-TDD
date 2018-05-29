@extends('layouts.app')

@section('content')
<dashboard-view inline-template v-cloak>
    <div class="container">
        <div class="section">
            <div class="columns">
                <aside class="column is-2">
                    {{-- <dashboard-menu></dashboard-menu> --}}
                </aside>

                <main class="column">
                    <div class="level">
                        <div class="level-left">
                        <div class="level-item">
                            <div class="title">Dashboard</div>
                        </div>
                        </div>
                        <div class="level-right">
                        <div class="level-item">
                            <button type="button" class="button is-small">
                            March 8, 2017
                            </button>
                        </div>
                        </div>
                    </div>
            
                    <div class="columns is-multiline">
                        <div class="column">
                            <incomes></incomes> 
                        </div>
                        
                        <div class="column">
                        
                        </div>
                        <div class="column">
                        
                        </div>
                        <div class="column">
                        
                        </div>
                    </div>
                    
                    <div class="columns is-multiline">
                        <div class="column is-6">
                        <monthly-expenses-chart></monthly-expenses-chart>
                        </div>
                        <div class="column is-6">
                        
                        </div>
                        <div class="column is-6">
                        
                        </div>
                        <div class="column is-6">
                        
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</dashboard-view>
@endsection
