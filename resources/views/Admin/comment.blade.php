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
            <a class="admin-button" id="gestionUsager" href="{{route('admin.index')}}">
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


    <div class="commentSection">
        @foreach($evaluations as $comment)
            <div class="comment">
                <div class="comment-header">
                    <div>
                        <span class="author">{{ $comment->alias }}</span>

                    </div>
                    <form action="{{route('remove.comment')}}" method="post">
                        @csrf
                        <input type="hidden" name="idEvaluation" value={{$comment->idEvaluation}}>
                        <button class="btn-delete" data-id="{{ $comment->idEvaluation }}">×</button>
                    </form>
                </div>
                <div class="comment-body">
                    <p>{{ $comment->commentaire }}</p>
                </div>
                <div class="comment-rating">
                    @for($i = 0; $i < 5; $i++)
                        @if($i < $comment->nbEtoiles)
                            <span class="star full">★</span>
                        @else
                            <span class="star empty">☆</span>
                        @endif
                    @endfor
                </div>
            </div>
        @endforeach
    </div>
</div>

