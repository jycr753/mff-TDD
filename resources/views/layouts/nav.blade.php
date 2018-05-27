<nav class="navbar is-transparent">
  <div class="navbar-brand">
    <a class="navbar-item" href="{{ url('/') }}">
      <img src="{{{ asset('img/mff.png') }}}" alt="My Financial Forecast">
    </a>
    <div class="navbar-burger burger" data-target="navbarExampleTransparentExample">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>

  <div id="navbarExampleTransparentExample" class="navbar-menu">
    <div class="navbar-start">
      <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link">
          Browse
        </a>
        <div class="navbar-dropdown is-boxed">
            <a class="dropdown-item" href="/threads">All Threads</a>
            @if(auth()->check())
                <a class="dropdown-item" href="/threads?by={{ auth()->user()->name }}">{{ auth()->user()->name }}</a>
            @endif
            <a class="dropdown-item" href="/threads?popular=1">Popular Threads</a>
            <a class="dropdown-item" href="/threads?unanswered=1">Unanswered Threads</a>
        </div>
      </div>
      <a class="navbar-item" href="/threads/create">
        New Threads
      </a>
      <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link">
          Channels
        </a>
        <div class="navbar-dropdown is-boxed">
            @foreach($channels as $channel)
                <a class="dropdown-item" href="/threads/{{ $channel->slug }}">{{ $channel->name }}</a>
            @endforeach
        </div>
      </div>
      
    </div>
    <div class="navbar-middle pad-top">
        <form method="GET" action="/threads/search">
            <input name="q" type="text" class="form-control" placeholder="Search">
        </form>
    </div>
    <div class="navbar-end">
      <div class="navbar-item">
        <div class="field is-grouped">
          <p class="control">
            @guest
              {{-- Show naathing for now --}}
            @else
            

                <user-notifications></user-notifications>

                <a href="/admin">
                    <img src="{{{ asset('img/setting.png') }}}" width="25" height="25">
                </a>
              <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">
                    <img src="{{ Auth::user()->avatar_path }}" 
                                alt="{{ Auth::user()->name }}" 
                                width="25" 
                                height="25" 
                                class="mr-1">
                    {{ Auth::user()->name }}
                </a>
                <div class="navbar-dropdown is-boxed">
                    <a class="dropdown-item" href="{{ route('profile', Auth::user()) }}">
                        My Profile
                    </a>
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
            @endguest
          </p>
        </div>
      </div>
    </div>
  </div>
</nav>
