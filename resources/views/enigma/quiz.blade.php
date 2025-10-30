@extends('layouts.default')
@section('title', 'enigma')
@section('content')
    @include("partials/headEnigma")

    @section('css',asset('./css/enigma.css'))
    <body>
    <main class="mainQuiz">

        <div class="containerQuiz">
            <section class="quiz-section">
                <div class="quiz-content">
                    <h1>Nico Quiz</h1>
                    <div class="quiz-header">
                        <span class="header-score">Caps gagner: 0</span>
                        <span class="header-time">Temps restant: 00:00</span>
                    </div>
                    <h2 class="question-text">{{$enigme[0]->enonce}}</h2>
                    <span class="question-difficulty">{{$enigme[0]->difficulte}}</span>
                    <form action="{{route('enigma.result')}}" method="POST">
                        @csrf
                        <div class="option-list">
                            @foreach($tableauReponses as $id => $reponse)
                                <input type="hidden" name="difficulty" value="{{$enigme[0]->difficulte}}" >
                                <input type="hidden" name="idEnigme" value="{{$enigme[0]->idEnigme}}">
                                <label>
                                    <input type="radio" name="reponse" value="{{$reponse['statut']}}" required>
                                    {{$reponse['reponse']}}
                                </label><br>
                            @endforeach
                        </div>
                        <div class="quiz-footer">
                            <span class="question-total"></span>
                            <button class="next-btn">Suivant</button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </main>

    </body>
@endsection


