<link rel="stylesheet" href="{{ asset('css/left_bar.css') }}">

<header class="site-header">
    <div class="header-content">
        <div>
            <a href="{{ url('/') }}" class="logo">Nom du site</a>
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
                @guest
                    <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary">Connexion</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-sm btn-primary">Inscription</a>
                    @endif
                @endguest

                @auth
                    <span class="username">{{ Auth::user()->name }}</span>

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
