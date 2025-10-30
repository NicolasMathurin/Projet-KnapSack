<nav class="d-flex mt-4" id="user-panel">

    @if(session()->has('joueur'))
        <div style="position: relative;">
            <a class="button-user">
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

    @endif
</nav>
