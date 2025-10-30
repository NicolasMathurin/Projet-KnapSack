@extends('layouts.default')
@section('title', 'enigma')
@section('content')
    @include("partials/headEnigma")
    @include('partials/sidebar')
    @include('partials/popUp')

    @section('css',asset('./css/enigma.css'))
    <body>
    <main class="mainQuiz">
        <div class=" panel d-flex justify-content-end ">
            @include('partials/EnigmaPanel')
        </div>
        <div class="containerQuiz">

            <section class="home">
                <div class="home-content">
                    <h1>Enigma</h1>
                    <p>Veuiller noter que tout argent ramasser dans le jeux ne peut pas etre changer en vrai dollar</p>
                    <button class="start-btn">Commencer</button>
                </div>
            </section>
        </div>
    </main>

    <div class="popup-difficulty">
        <form action="{{route('enigma.quiz')}}" method="Post">
            @csrf
            <h2>Choisissez la difficulté</h2>
            <label class="info">
                <input type="checkbox" name="difficulty1" value="facile"> 1. Facile
            </label>
            <br>
            <label class="info">
                <input type="checkbox" name="difficulty2" value="moyenne"> 2. Moyen
            </label>
            <br>
            <label class="info">
                <input type="checkbox" name="difficulty3" value="difficile"> 3. Difficile
            </label>

            <div class="btn-group">
                <button class="info-btn exit-btn" type="button">Retour</button>
                <button class="info-btn continue-btn" type="submit">Continuer</button>
            </div>
        </form>
    </div>
    </body>
@endsection
