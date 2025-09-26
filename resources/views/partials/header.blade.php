<link rel="stylesheet" href="{{ asset('css/left_bar.css') }}">

<header class="site-header">
    <div class="header-content">
        <div>
            <a href="{{ url('/') }}" class="logo">Les reviews étoilées </a>
        </div>

        <nav>
            <div class="nav-top">
                <a href="{{ url('/') }}">Accueil</a>

                @auth
                    @if(auth()->user()->admin == 1)
                        <a href="{{ route('articles.index') }}" class="btn btn-sm btn-outline-secondary">Dashboard</a>
                    @endif
                @endauth
            </div>

            
            <div class="nav-bottom">
                <hr class="nav-separator">
                {{-- Avatar utilisateur et username --}}
                @auth
                    <div class="user-info">
                        @if(Auth::user()->avatar)
                            <img src="{{ Auth::user()->avatar }}" alt="Avatar">
                        @else
                            <img src="/images/default-avatar.png" alt="Avatar">
                        @endif
                        <span class="username">{{ Auth::user()->name }}</span>
                    </div>
                @else
                    <img src="/images/default-avatar.png" alt="Avatar"
                         class="rounded-full w-10 h-10 object-cover">
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary">Connexion</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-sm btn-primary">Inscription</a>
                    @endif
                @endguest

                @auth
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger">Déconnexion</button>
                    </form>
                @endauth
            </div>
        </nav>
    </div>

    {{-- La barre verticale --}}
    <div class="header-bar"></div>
</header>