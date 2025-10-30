<nav class="sidebar">
    <div class="logo-menu">
        <h2 class="logo">@yield('titleSideBar', 'KNAPSACK')</h2>
        <i class='bx bx-menu toggle-btn'></i>
    </div>
    <ul class="list">
        <li class="list-item {{ session()->has('joueur') ? '' : 'disabled' }}">
            <a href="#">
                <i class='bx bx-user'></i>
                <span class="link-name">Profil</span>
            </a>
        </li>
        <li class="list-item {{ session()->has('joueur') ? '' : 'disabled' }}">
            <a href="{{route('backpack.index')}}">
                <i class='bx bxs-backpack'></i>
                <span class="link-name">Sac A Dos</span>
            </a>
        </li>
        <li class="list-item {{ session()->has('joueur') ? '' : 'disabled' }}">
            <a href="{{route('item.index')}}">
                <i class='bx bxs-store'></i>
                <span class="link-name">Magasin</span>
            </a>
        </li>
        <li class="list-item {{ session()->has('joueur') ? '' : 'disabled' }}">
            <a href="{{route('enigma.index')}}">
                <i class='bx bx-search-alt'></i>
                <span class="link-name">Enigma</span>
            </a>
        </li>
        <li class="list-item {{ session()->has('joueur') ? '' : 'disabled' }}">
            <a href="{{route('cart.index')}}">
                <i class='bx bx-cart'></i>
                <span class="link-name">Panier</span>
            </a>
        </li>
    </ul>
</nav>

