@extends('layouts.default')
@section('title', 'item')
@section('content')
    @include("partials/head")
    @include("partials/header")
    @include("partials/sidebar")
    @section('css',asset('./css/backPackStyles.css'))
    <div class="sellMain" id="vendre">
        <div class="flexTop d-flex flex-col">
            <h2 class="sellTitle" id="popup-item-name"></h2>
            <button type="submit" id="fermer" onclick="closePopUp()" class="ri-delete-bin-2-line supp flex-shrink-0"
                    name="action" value="delete">X
            </button>
        </div>
        <p>Combien de cet item voulez vous vendre ?</p>

        <div class="bottom">
            <div class="quantity">
                <button type="button" class="decrement button" onclick="decrementQuantity()">-</button>
                <input type="number" id="sellQuantity" class="sellValue" value="1" min="1" max=""/>
                <button type="button" class="increment button" onclick="incrementQuantity()">+</button>
            </div>

            <div>
                <form action="{{ route('sell.backpack') }}" method="post" id="sellForm">
                    @csrf
                    <input type="hidden" name="id" id="sell-item-id" value="">
                    <input type="hidden" name="quantity" id="sell-quantity" value="1">
                    <button type="submit" class="sell">Vendre</button>
                </form>
            </div>
        </div>
    </div>

    <div class="sellMain" id="consume-popup">
        <div class="flexTop d-flex flex-col">
            <h2 class="sellTitle" id="popup-item-name-consume"></h2>
            <button type="button" id="close-consume" onclick="closePopUp()" class="ri-delete-bin-2-line supp flex-shrink-0" aria-label="Fermer">×</button>
        </div>

        <p>Combien de cet item voulez-vous consommer ?</p>

        <div class="bottom">
            <div class="quantity">
                <button type="button" class="decrement-consume button" onclick="decrementConsumeQuantity()">–</button>
                <input type="number" id="consumeQuantity" class="sellValue" value="1" min="1" max=""/>
                <button type="button" class="increment-consume button" onclick="incrementConsumeQuantity()">+</button>
            </div>

            <div>
                <form action="{{ route('consume.backpack')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="consume-item-id" value="">
                    <input type="hidden" name="quantity" id="consume-quantity" value="1">
                    <button type="submit" class="sell">Consommer</button>
                </form>
            </div>
        </div>
    </div>


    <div class="main-container">
        @include('partials/userPanel')
        @include('partials/popUp')

        <h1>Inventaire</h1>
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
                        <button type="button" onclick="openPopup('{{$id}}', '{{$item['name']}}')" class="details">
                            Vendre
                        </button>


                        @if($item['type'] === 'nourriture' || $item['type'] === 'medicament' )
                            <input type="hidden" name="id" value="{{$id}}">
                            <button type="button" onclick="openPopupConsommer('{{$id}}', '{{$item['name']}}')"
                                    class="details">consommer
                            </button>
                        @endif

                        <form action="{{route('throw.backpack')}}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{$id}}">
                            <button type="submit" class="details">Jeter</button>
                        </form>
                    </div>

                </div>
            @endforeach
        </div>
        <script>
            let popup = document.getElementById('vendre');
            let background = document.getElementById('main-container');
            const consumePopup = document.getElementById('consume-popup');

            function openPopup(itemId, itemName) {
                document.getElementById('popup-item-name').textContent = itemName;
                document.getElementById('sell-item-id').value = itemId;
                document.getElementById('sellQuantity').value = 1;
                document.getElementById('sell-quantity').value = 1;

                const decrementBtn = popup.querySelector(".decrement");
                decrementBtn.style.color = "#130606";
                decrementBtn.style.cursor = "not-allowed";

                popup.style.display = 'block';
                popup.classList.add('open-Sellpopup');
                background.classList.add('hide');
            }

            function openPopupConsommer(itemId, itemName) {

                document.getElementById('popup-item-name-consume').textContent = itemName;

                document.getElementById('consume-item-id').value = itemId;
                document.getElementById('consumeQuantity').value = 1;
                document.getElementById('consume-quantity').value = 1;

                const decrementBtn = consumePopup.querySelector('.decrement-consume');
                decrementBtn.style.color = '#130606';
                decrementBtn.style.cursor = 'not-allowed';

                consumePopup.style.display = 'block';
                consumePopup.classList.add('open-Sellpopup');
                background.classList.add('hide');
            }

            function closePopUp() {
                popup.classList.remove('open-Sellpopup');
                background.classList.remove('hide');
                setTimeout(() => {
                    popup.style.display = 'none';
                    window.location.reload();
                }, 300);

            }

            function closePopUp() {
                consumePopup.classList.remove('open-Sellpopup');
                consumePopup.classList.remove('hide');
                setTimeout(() => {
                    consumePopup.style.display = 'none';
                    window.location.reload();
                }, 300);

            }


            function decrementQuantity() {
                const quantityDisplay = document.getElementById('sellQuantity');
                const decrementBtn = popup.querySelector(".decrement");
                let quantity = parseInt(quantityDisplay.value) || 1;

                if (quantity > 1) {
                    quantity--;
                    quantityDisplay.value = quantity;
                    document.getElementById('sell-quantity').value = quantity;
                }

                if (quantity <= 1) {
                    decrementBtn.style.color = "#130606";
                    decrementBtn.style.cursor = "not-allowed";
                } else {
                    decrementBtn.style.color = "#999";
                    decrementBtn.style.cursor = "pointer";
                }
            }

            function incrementQuantity() {
                const quantityDisplay = document.getElementById('sellQuantity');
                const decrementBtn = popup.querySelector(".decrement");
                let quantity = parseInt(quantityDisplay.value) || 1;

                quantity++;
                quantityDisplay.value = quantity;
                document.getElementById('sell-quantity').value = quantity;

                if (quantity > 1) {
                    decrementBtn.style.color = "#999";
                    decrementBtn.style.cursor = "pointer";
                }
            }

            document.getElementById('sellQuantity').addEventListener('change', function () {
                const quantity = parseInt(this.value) || 1;
                document.getElementById('sell-quantity').value = quantity;

                // Update decrement button style
                const decrementBtn = popup.querySelector(".decrement");
                if (quantity <= 1) {
                    decrementBtn.style.color = "#130606";
                    decrementBtn.style.cursor = "not-allowed";
                } else {
                    decrementBtn.style.color = "#999";
                    decrementBtn.style.cursor = "pointer";
                }
            });
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
