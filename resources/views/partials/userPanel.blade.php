<nav class="d-flex mt-4" id="user-panel">

    @if(session()->has('joueur'))
        <div style="position: relative;">
            <a class="button-user" id="userName">
                {{session('joueur')->userName}}
            </a>
        </div>
        <div style="position: relative;">
            <a class="button-user">
                Santé: {{session('joueur')->pointsVie}}
            </a>
        </div>

        <div style="position: relative;">
            <a class="button-user">
                Caps: {{session('joueur')->caps}}
            </a>
        </div>

        <div style="position: relative;">
            <a class="button-user">
                Poids : {{session('joueur')->poids}}
            </a>
        </div>

        <div style="position: relative;">
            <a class="button-user">
                Poids Maximal : {{session('joueur')->poidsMax}}
            </a>
        </div>

        <div style="position: relative;">
            <a class="button-user">
                Dexterite : {{session('joueur')->dexterite}}
            </a>
        </div>
    @endif
    @if(session()->has('joueur'))
        <div class="d-flex mt-1">
            <form action="{{route('logout')}}" method="POST">
                @csrf
                <button type="submit" class="button-deconnexion"> Deconnexion</button>
            </form>
        </div>
    @else
        <div>
            <a class="button-connexion " href="{{route('show.login')}}"> Connexion</a>
        </div>
    @endif
</nav>
