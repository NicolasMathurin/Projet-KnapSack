@extends('layouts.default')
@section('title','Page de test')
@section('content')
    @include("partials/head")
    {{--@section('css',asset('js/script.js'))--}}
    @section('css',asset('./css/adminStyles.css'))
    <header class="headerStyle">
        <h1> Gestion </h1>
    </header>

    <div class="main-table">
        <nav class="nav-panel ">
            <div class=" d-flex ml-5">

                <a class="admin-button " id="gestionCommentaires" href="{{route('admin.comment')}}">
                    Commentaires
                </a>
            </div>

            <div>
                <a class="admin-button" id="gestionUsager">
                    Gestions Usagers
                </a>
            </div>

            <div>
                <a class="admin-button">
                    Ajouter un Item
                </a>
            </div>
            <div>
                <form action="{{route('logout')}}" method="POST">
                    @csrf
                    <button type="submit" class="admin-deconnexion"> Deconnexion</button>
                </form>
            </div>

        </nav>
        <table class="userTable">
            <thead>
            <tr>
                <th>Utilisateur</th>
                <th>Santé</th>
                <th>Caps</th>
                <th>Poids</th>
                <th>Dextérité</th>
            </tr>
            </thead>
            <tbody>
            @foreach($players as $player)
                <tr>
                    <td class="user">{{ $player->userName }}</td>
                    <td>{{ $player->pointsVie }}</td>
                    <td>
                        <img src="{{ asset('image/image-cap.png') }}" alt="Caps" class="imgCaps">
                        {{ $player->caps }}
                    </td>
                    <td>{{ $player->poids }}</td>
                    <td>{{ $player->dexterite }}</td>

                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <template id="tplActionCell">
        <td class="action-col">
            <form method="post" action="">
                @csrf
                <button type="submit" class="adjust">Enrichir</button>
            </form>
        </td>
    </template>

    <script>
        document.getElementById('gestionUsager').addEventListener('click', function (e) {
            e.preventDefault();

            const table = document.querySelector('.userTable');
            const headerRow = table.querySelector('thead tr');
            const tplCell = document.getElementById('tplActionCell').content.firstElementChild;

            if (!headerRow.querySelector('th.action-col')) {
                const th = document.createElement('th');
                th.textContent = 'Action';
                th.classList.add('action-col');
                headerRow.appendChild(th);

                table.querySelectorAll('tbody tr').forEach(tr => {
                    const newTd = tplCell.cloneNode(true);
                    tr.appendChild(newTd);
                });
            }
        });
    </script>
@endsection


