<nav class="navbar navbar-expand-md navbar-light navbar-laravel">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{{ asset('img/favicon.png') }}}" width="25" height="25">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Browse
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/threads">All Threads</a>
                        @if(auth()->check())
                            <a class="dropdown-item" href="/threads?by={{ auth()->user()->name }}">{{ auth()->user()->name }}</a>
                        @endif
                        <a class="dropdown-item" href="/threads?popular=1">Popular Threads</a>
                        <a class="dropdown-item" href="/threads?unanswered=1">Unanswered Threads</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/threads/create">New Threads</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Channels
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @foreach($channels as $channel)
                            <a class="dropdown-item" href="/threads/{{ $channel->slug }}">{{ $channel->name }}</a>
                        @endforeach
                    </div>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <form method="GET" action="/threads/search">
                        <input name="q" type="text" class="form-control" placeholder="Search">
                    </form>
                </li>
            </ul>
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                    <li><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                @else

                    <user-notifications></user-notifications>

                    @if (Auth::user()->isAdmin())
                        <li><a href="/admin"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span></a></li>
                    @endif

                    <li class="nav-item dropdown">
                        
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <img src="{{ Auth::user()->avatar_path }}" 
                                alt="{{ Auth::user()->name }}" 
                                width="25" 
                                height="25" 
                                class="mr-1">
                            
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('profile', Auth::user()) }}">
                                My Profile
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
