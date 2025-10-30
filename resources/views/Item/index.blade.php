@extends('layouts.default')
@section('title', 'item')
@section('content')
    @include("partials/head")
    @include("partials/header")
    @include('partials/sidebar')
    @section('css',asset('./css/stylesItems.css'))
    <div class=" panel d-flex justify-content-end ">
        @include('partials/userPanel')
    </div>

    <div class="main-container">
        @include('partials/popUp')
        <div class="filter-section d-flex">

                <div class="d-flex align-items-center">
                    <select id="dropdownMenu" class="form-select w-auto">
                        <option value="none" selected>Tous les items</option>
                        <option value="etoiles">Etoiles</option>
                    </select>
                </div>

                <p class="mb-0 ms-3">Trier par : </p>

                <div class="d-flex align-items-center gap-3 filter_checkbox" id="checkboxFiltre">

                    <div>
                        <input type="checkbox" id="checkboxArmes" name="arme" value="Armes">
                        <label for="checkboxArmes" class="mb-0">Armes</label>
                    </div>

                    <div>
                        <input type="checkbox" id="checkboxArmures" name="armure" value="Armures">
                        <label for="checkboxArmures" class="mb-0">Armures</label>
                    </div>

                    <div>
                        <input type="checkbox" id="checkboxMedicaments" name="medicament" value="Medicaments">
                        <label for="checkboxMedicaments" class="mb-0">Medicaments</label>
                    </div>

                    <div>
                        <input type="checkbox" id="checkboxMunitions" name="munition" value="Munitions">
                        <label for="checkboxMunitions" class="mb-0">Munitions</label>
                    </div>

                    <div>
                        <input type="checkbox" id="checkboxNourritures" name="nourriture" value="Nourritures">
                        <label for="checkboxNourritures" class="mb-0">Nourritures</label>
                    </div>

                    <div>
                        <input type="checkbox" id="checkboxRessources" name="ressource" value="Ressources">
                        <label for="checkboxRessources" class="mb-0">Ressources</label>
                    </div>

                </div>
            @include('partials/popUp')

        </div>
        <div class="listItem ">
            @foreach($tableauItems as $id => $item)
                <div class="items d-flex-col" data-name="{{$item['type']}}" data-stars={{$item['etoiles']}}>

                    @if (file_exists(public_path('image/image-' . $item['photo'] . '.png')))
                        <img class="imgArticles" src="{{ asset('image/image-' . $item['photo'] . '.png') }}"
                             alt="Image de {{ $item['photo'] }}">
                    @else
                        <img src="{{ asset('image/image-acide.png') }}" alt="Image par défaut">
                    @endif

                    <h2 class="d-flex justify-content-center mt-4">{{$item['name']}}</h2>
                    <div class="d-flex justify-content-between">
                        <div class="typeItem"> Type: {{$item['type']}}</div>
                        <div class="weight d-flex justify-content-end flex-nowrap">{{$item['poids']}} lbs</div>
                    </div>

                    <div class="price mt-1 ">
                        <img class="imgCaps" src="{{ asset('image/image-cap.png') }}" alt="Image caps">
                        <span>{{$item['prix']}} </span>
                    </div>

                    <div class="buttonContainer d-flex gap-3 mt-4 ">
                        <form action="{{route('add.cart')}}" method="POST">
                            @csrf
                            <input type="hidden" name="idItem" value="{{$item['idItem']}}">
                            <button class="cart" type="submit"> Ajouter au panier</button>
                        </form>
                        <a class="details" href="/item/{{$item['idItem']}}">Details</a>
                    </div>

                </div>
            @endforeach

        </div>

    </div>
    <script>
        const filterableCards = document.querySelectorAll('.listItem .items');
        const filterCheckboxes = document.querySelectorAll('.filter_checkbox div input');
        const orderMenu = document.querySelector('#dropdownMenu');
        orderMenu.addEventListener('change', () => {
            if (orderMenu.value === "none") {
                filterableCards.forEach(card => {
                    card.style.order = "0";
                });
            }
            if (orderMenu.value === "etoiles") {
                filterableCards.forEach(card => {
                    card.style.order = -card.dataset.stars.toString();
                });
            }
        });
        const filter = (e) => {
            //regarder si seulement un checkbox qui est coché

            //si coché
            if (e.target.checked) {
                if (checkIfOneChecked(e)) {
                    filterableCards.forEach(card => {
                        console.log(card.dataset.stars);
                        if (card.dataset.name === e.target.name) {
                            card.classList.remove("hide");
                        }
                    });
                } else {
                    removeAll();
                    filterableCards.forEach(card => {
                        if (card.dataset.name === e.target.name) {
                            card.classList.remove("hide");
                        }
                    });
                }
            }
            //si non coché
            else {
                if (checkIfOneChecked(e)) {
                    filterableCards.forEach(card => {
                        if (card.dataset.name === e.target.name) {
                            card.classList.add("hide");
                        }
                    });
                } else {
                    showAll();
                }
            }
        }

        const checkIfOneChecked = (e) => {
            var oneAlreadyCheck = false;
            filterCheckboxes.forEach(checkbox => {
                if (checkbox.checked && checkbox.name !== e.target.name) {
                    return oneAlreadyCheck = true;

                }
            });
            return oneAlreadyCheck;
        }

        const removeAll = () => {
            filterableCards.forEach(card => {
                card.classList.add("hide");
                console.log(card);
            });
        }

        const showAll = () => {
            filterableCards.forEach(card => {
                card.classList.remove("hide");
            });
        }


        filterCheckboxes.forEach(checkbox => checkbox.addEventListener('change', filter
        ));
    </script>
@endsection
