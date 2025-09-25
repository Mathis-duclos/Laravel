<header style="padding:10px 16px; border-bottom:1px solid #ddd;">
    <div style="display:flex; align-items:center; justify-content:space-between; gap:12px;">
        <div>
            <a href="{{ url('/') }}" style="text-decoration:none; font-weight:700;">Nintenga</a>
        </div>

        <nav style="display:flex; align-items:center; gap:8px;">
            {{-- Liens publics utiles (optionnels) --}}
            <a href="{{ url('/') }}">Accueil</a>

            @guest
                <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary">Connexion</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-sm btn-primary">Inscription</a>
                @endif
            @endguest

            @auth
                <span style="margin-left:8px;">{{ Auth::user()->name }}</span>

                {{-- Liens privés (optionnels) --}}
                <a href="{{ route('articles.index') }}" class="btn btn-sm btn-outline-secondary">Dashboard</a>
                {{-- Déconnexion (POST) --}}
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-danger">Déconnexion</button>
                </form>
            @endauth
        </nav>
    </div>
</header>
