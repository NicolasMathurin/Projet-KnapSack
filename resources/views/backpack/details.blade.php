@extends('layouts.default')
@section('title','Page de test')
@section('content')
    @include("partials/head")
    @include("partials/header")
    @include('partials/sidebar')
    @include('partials/popUp')

    {{--@section('css',asset('js/script.js'))--}}
    @section('css',asset('./css/detailsStyles.css'))
    <div class=" panel d-flex justify-content-end ">
        @include('partials/userPanel')
    </div>

    <div class="containerDetails d-flex" data-type="{{$item['type']}}">
        @include('partials/popUp')

        {{--Pour les images--}}
        <div class="imgContainer d-flex">
            @if (file_exists(public_path('image/image-' . $item['photo'] . '.png')))
                <img src="{{ asset('image/image-' . $item['photo'] . '.png') }}"
                     alt="Image de {{ $item['photo'] }}">
            @else
                <img src="{{ asset('image/image-acide.png') }}" alt="Image par défaut">
            @endif
        </div>

        {{--Pour les details --}}
        <div class="bigContainer">
            <div class="infosContainer mr-4">


                <h2 class="nom text-center mt-3">{{$item['name']}}</h2>
                @if($arme)
                    <div class="description d-flex mt-4 justify-content-center">
                        <p class=" mb-0"> {{$arme->description}} </p>
                    </div>
                @endif
                @if($ressource)
                    <div class="description d-flex mt-4 justify-content-center">
                        <p class=" mb-0"> {{$ressource->description}} </p>
                    </div>
                @endif
                <div class="price d-flex  align-items-center mt-3">
                    <img class="imgCaps mt-1" src="{{ asset('image/image-cap.png') }}" alt="Image caps">
                    {{$item['prix']}}
                </div>

                <div class="d-flex  justify-content-between mt-3 gap-5">
                    <div class="infosGenerales flex-col mb-3">
                        <div class="weight d-flex ml-2">
                            <p class="mr-1 fw-bold">Poids:</p>
                            <p class="text ml-2">{{ $item['poids'] }} lbs</p>
                        </div>
                        <div class="typeItem d-flex ml-2">
                            <p class="mr-1 fw-bold">Type:</p>
                            <p class="text ml-2">{{ $item['type'] }}</p>
                        </div>
                        <div class="quantite d-flex ml-2">
                            <p class="mr-1 fw-bold">Stock personnel:</p>
                            <p class="text ml-2 ">{{ $item['quantite'] }}</p>
                        </div>
                        <div class="utilite d-flex ml-2">
                            <p class="mr-1 fw-bold">Utilité:</p>
                            <p class="text ml-2">{{ $item['utilite'] }}</p>
                        </div>
                    </div>

                    <div class="infosSpecifiques flex-col mb-3 mr-3">
                        @if($munition)
                            <div class="utilite d-flex ml-5">
                                <p class="mr-1 fw-bold ">Type de munition:</p>
                                <p class="text">{{ $munition->genre }}</p>
                            </div>
                            <div class="utilite d-flex ml-5">
                                <p class="mr-1 fw-bold">Calibre:</p>
                                <p class="text">{{ $munition->calibre }}</p>
                            </div>
                        @endif

                        @if($nourriture)
                            <div class="utilite d-flex ml-5">
                                <p class="mr-1 fw-bold">Apport Calorique:</p>
                                <p class="text">{{ $nourriture->apportCalorique }}</p>
                            </div>
                            <div class="utilite d-flex ml-5">
                                <p class="mr-1 fw-bold">Composant nutritif:</p>
                                <p class="text">{{ $nourriture->composantNutritif }}</p>
                            </div>
                            <div class="utilite d-flex ml-5">
                                <p class="mr-1 fw-bold">Minéral principal:</p>
                                <p class="text">{{ $nourriture->mineralPrincipal }}</p>
                            </div>
                            <div class="utilite d-flex ml-5">
                                <p class="mr-1 fw-bold">Vie + :</p>
                                <p class="text">{{ $nourriture->gainVie }}</p>
                            </div>
                        @endif

                        @if($arme)
                            <div class="utilite d-flex ml-5">
                                <p class="mr-1 fw-bold">Efficacité:</p>
                                <p class="text">{{ $arme->efficacite }}</p>
                            </div>
                            <div class="utilite d-flex ml-5">
                                <p class="mr-1 fw-bold">Genre d’arme:</p>
                                <p class="text">{{ $arme->genre }}</p>
                            </div>
                        @endif

                        @if($armure)
                            <div class="utilite d-flex ml-5">
                                <p class="mr-1 fw-bold">Matière:</p>
                                <p class="text">{{ $armure->matiere }}</p>
                            </div>
                            <div class="utilite d-flex ml-5">
                                <p class="mr-1 fw-bold">Taille:</p>
                                <p class="text">{{ $armure->taille }}</p>
                            </div>
                        @endif

                        @if($medicament)
                            <div class="utilite d-flex ml-5">
                                <p class="mr-1 fw-bold">Effet attendu:</p>
                                <p class="text">{{ $medicament->effetAttendu }}</p>
                            </div>
                            <div class="utilite d-flex ml-5">
                                <p class="mr-1 fw-bold">Durée d’effet:</p>
                                <p class="text">{{ $medicament->dureeEffet }}</p>
                            </div>
                            <div class="utilite d-flex ml-5">
                                <p class="mr-1 fw-bold">Effet indésirable:</p>
                                <p class="text">{{ $medicament->effetIndesirable }}</p>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="buttonContainer d-flex  mr-5 mb-1 justify-content-between  ">

                    <a class="addCommentbutton d-flex justify-content-end " href="{{ url()->previous() }}"> Retour </a>

                </div>
            </div>
            <div class="commentSection">
                <h2 class="nom text-center mt-3">Commentaires</h2>
                <h2 class="nom text-center mt-3">Moyenne: {{$item['moyenneEtoiles']}}</h2>
                <i class="fa-regular fa-comment openAddComment" style="font-size: 1.5em; color: #a7c957;"></i>
                <div class="addComment">
                    <form  action="{{route('add.comment')}}" method="POST">
                        @csrf
                        <textarea
                                name="commentaire"
                                class="commentInput"
                                placeholder="Nouvelle participation ?"
                                required
                        ></textarea>

                        <div class="star-box">
                            <header>votre avis compte</header>
                            <div class="stars">
                                <i class="fa-solid fa-star" data-value="1"></i>
                                <i class="fa-solid fa-star" data-value="2"></i>
                                <i class="fa-solid fa-star" data-value="3"></i>
                                <i class="fa-solid fa-star" data-value="4"></i>
                                <i class="fa-solid fa-star" data-value="5"></i>
                            </div>
                            {{-- Champ cachÃ© pour la note --}}
                            <input type="hidden" name="nbEtoiles" value="0" class="star-rating-input">
                        </div>
                        <input type="hidden" name="idItem" value="{{$item['idItem']}}">
                        <button type="submit" class="addCommentbutton">Ajouter</button>
                    </form>
                </div>

                @if($evaluation->count())
                    @foreach($evaluation as $comment)
                        <div class="comment">
                            <div class="comment-header">
                                <span class="author">{{ $comment->alias }}</span>
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
                            @if($comment->alias == session()->get('joueur.alias'))
                                <form action="{{route('remove.comment')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="idEvaluation" value={{$comment->idEvaluation}}>
                                    <button type="submit" class="addCommentbutton">Suprimer</button>
                                </form>
                            @endif
                        </div>
                    @endforeach
                @else
                    <p class="text-center mt-3">Aucun commentaire pour l’instant, soyez le premier a en ajouter!</p>
                @endif
            </div>



        </div>
    </div>
    <script>
        // quand on clique sur l'icône pour afficher le form
        document.querySelector(".openAddComment")
            .addEventListener("click", () => {
                document.querySelector(".addComment").classList.toggle("activeComment");
            });

        const stars = document.querySelectorAll(".stars i");
        const hiddenInput = document.querySelector(".star-rating-input");

        stars.forEach(star => {
            star.addEventListener("click", () => {
                const val = parseInt(star.dataset.value);
                // mettre à jour l'affichage
                stars.forEach(s => {
                    s.classList.toggle("active", parseInt(s.dataset.value) <= val);
                });
                // stocker dans le champ caché
                hiddenInput.value = val;
            });
        });
    </script>

@endsection
