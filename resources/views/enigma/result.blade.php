@extends('layouts.default')
@section('title', 'enigma')
@section('content')
    @include("partials/headEnigma")

    @section('css',asset('./css/enigma.css'))
    <body>
    <main class="mainQuiz">

        <div class="containerQuiz">
            <section class="quiz-section">
                <div class="result-box">
                    <h2>Nico Quiz Resultat</h2>
                    <div class="percentage-container">
                        <span class="score-text">{{$messageResultat}}</span>
                    </div>
                    <div class="button">
                        <form action="{{route('enigma.index')}}">
                            <button class="exit-btn" type="submit">Quitter</button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </main>

    </body>
@endsection


