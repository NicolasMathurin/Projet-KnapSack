@extends('layouts.default')
@section('title', 'item')
@section('content')
    @include("partials/head")
    <h1>Inventaire</h1>
    @include('partials/sidebar')

    @section('css',asset('./css/backPackStyles.css'))

    @foreach($tableauItems as $id => $item)
    <div class="sellMain" id="vendre"data-name="{{$item['type']}}" data-stars={{$item['etoiles']}}>
        <div class="flexTop d-flex flex-col ">
            <h2 class="sellTitle">Acide</h2>
            <button type="submit" id="fermer" onclick="closePopUp()" class="ri-delete-bin-2-line supp flex-shrink-0 " name="action"
                    value="delete">X
            </button>

        </div>
        <p>Combien de cet item voulez vous vendre ?</p>

        <div class="bottom">
            <div class="quantity">
                {{--<form action="{{route('modify.cart')}}" method="post">
                    @csrf
                    {{--<input type="hidden" name="id" value="{{ $id }}">--}}
                <button type="submit" class="decrement button" name="action" value="decrease">-</button>
                <input type="number" class="sellValue" value="1" min="1" max=""/>
                <button type="submit" class="increment button" name="action" value="increase">+</button>
                {{--</form>--}}
            </div>

            <div>
                <form action="{{ route('sell.backpack') }}" method="post">
                    @csrf
                    <button type="submit" class="sell">Vendre</button>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    <div class="main-container" id="main-container">
        @include('partials/userPanel')
        @include('partials/popUp')
        <div class="filter-section d-flex">

            <div class="d-flex align-items-center">
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
            </div>

        </div>
        <div class="listItem ">
            @foreach($tableauItems as $id => $item)
                <div class="items" data-name="{{$item['type']}}" data-stars={{$item['etoiles']}}>
                        <a href="/backpack/{{ $item['idItem'] }}">
                            @if (file_exists(public_path('image/image-' . $item['photo'] . '.png')))
                                <img class="imgArticles" src="{{ asset('image/image-' . $item['photo'] . '.png') }}"
                                     alt="Image de {{ $item['photo'] }}">
                            @else
                                <img class="imgArticles" src="{{ asset('image/image-acide.png') }}" alt="Image par défaut">
                            @endif
                        </a>

                    <h2 class="d-flex justify-content-center mt-4">{{$item['name']}}</h2>

                    <div class="d-flex justify-content-between">
                        <div class="typeItem"> Type: {{$item['type']}}</div>
                        <div class="weight d-flex justify-content-end flex-nowrap">{{$item['poids']}} lbs</div>
                    </div>

                    <div class="price mt-1 ">
                        <img class="imgCaps" src="{{ asset('image/image-cap.png') }}" alt="Image caps">
                        {{$item['prix']}}
                    </div>
                    <div class="buttonContainer d-flex gap-3 mt-4 ">
                            <input type="hidden" name="id" value="{{$id}}">
                            <button type="submit" onclick="openPopup()" class="details">Vendre</button>

                        @if($item['type'] === 'nourriture' || $item['type'] === 'medicament' )
                            <form action="{{route('consume.backpack')}}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{$id}}">
                                <button type="submit" class="details">Consommer</button>
                            </form>
                        @endif
                    </div>

                </div>
            @endforeach
        </div>
    </div>

        <script>


            {{--popUp de vente--}}
            let popup = document.getElementById('vendre')
            let background = document.getElementById('main-container')

            function openPopup(){
                popup.classList.add('open-Sellpopup')
                background.classList.add('hide')
            }

            function closePopUp() {
                popup.classList.remove('open-Sellpopup')
                background.classList.remove('hide')
            }

            document.querySelectorAll(".sellMain").forEach(vendreMain => {
                const decrementBtn = vendreMain.querySelector(".decrement");
                const incrementBtn = vendreMain.querySelector(".increment");
                const quantityDisplay = vendreMain.querySelector(".sellValue");

                let quantity = parseInt(quantityDisplay.value) || 1;

                // Initial state
                if (quantity <= 1) {
                    decrementBtn.style.color = "#130606";
                    decrementBtn.style.cursor = "not-allowed";
                }

                decrementBtn.addEventListener("click", () => {
                    let quantity = parseInt(quantityDisplay.value) || 1;

                    if (quantity > 1)
                        quantity--;
                    quantityDisplay.value = quantity;

                    if (quantity === 1) {
                        decrementBtn.style.color = "#130606";
                        decrementBtn.style.cursor = "not-allowed";
                    }
                });


                incrementBtn.addEventListener("click", () => {
                    let quantity = parseInt(quantityDisplay.value) || 1;
                    quantity++;
                    quantityDisplay.value = quantity;

                    if (quantity > 1) {
                        decrementBtn.style.color = "#999";
                        decrementBtn.style.cursor = "pointer";
                    }
                });

            });
            {{--Filtres--}}
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