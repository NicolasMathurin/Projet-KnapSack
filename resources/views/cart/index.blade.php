@extends('layouts.default')
@section('title','Page de test')
@section('content')
    @include("partials/head")
    @include("partials/header")
    @include('partials/sidebar')

    {{--@section('css',asset('js/script.js'))--}}
    @section('css',asset('./css/cartStyles.css'))
    <div class=" panel d-flex justify-content-end ">
        @include('partials/userPanel')
    </div>
    @include('partials/popUp')

    <div class="cartMain">


        <div class="articleContainer">
            @foreach($tableauItems as $id => $item)

                <div class="cartBox d-flex flex-row align-items-center gap-3">

                    @if (file_exists(public_path('image/image-' . $item['photo'] . '.png')))
                        <img class="imgContainer ml-2 mt-1" src="{{ asset('image/image-' . $item['photo'] . '.png') }}"
                             alt="Image de {{ $item['photo'] }}">
                    @else
                        <img class="imgContainer ml-2 mt-1" src="{{ asset('image/image-acide.png') }}"
                             alt="Image par défaut">
                    @endif

                    <div class="detailsArticles d-flex flex-column flex-grow-1">
                        <h2 class="ml-3 ">{{$item['name']}}</h2>
                        <div class=" d-flex align-items-center ml-3 mt-3 mb-2 ">{{$item['poids']}} lb</div>
                        <div class="price d-flex align-items-center ml-2">
                            <img
                                    class="imgCaps mb-1"
                                    src="{{ asset('image/image-cap.png') }}"
                                    alt="Image caps">
                            <span class=" ml-2">{{$item['prix']}}</span>
                        </div>
                    </div>
                    <div class="quantity  gap-2 ">
                        <form action="{{route('modify.cart')}}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $id }}">
                            <button type="submit" class="decrement button" name="action" value="decrease">-</button>
                            <span class="value">{{$item['quantite']}}</span>
                            <button type="submit" class="increment button" name="action" value="increase">+</button>
                            <button type="submit" class="ri-delete-bin-2-line supp ml-3 flex-shrink-0" name="action"
                                    value="delete">X
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="total d-flex flex-column gap-3  ">
            <div class="d-flex flex-row">
                <div class="total-title ">Prix total:</div>
                <div class="totalprix ml-3">{{$prixTotal}}
                    <img class="imgCaps" src="{{ asset('image/image-cap.png') }}" alt="Image caps">
                </div>
            </div>

            <div class="totalprix d-flex flex-row">
                <div class="total-title ">Poids total:</div>
                <div class=" totalprix ml-3">{{$poidsTotal}}
                    <img class="imgCaps" src="{{ asset('image/weight-hanging-solid.svg') }}" alt="Image poids">
                </div>
            </div>
        </div>
        <div class=" buttonCart ">
            <form action="{{route('empty.cart')}}" method="post">
                @csrf
                <button type="submit" class="buy">Vider Panier</button>
            </form>
            <form action="{{route('pay.cart')}}" method="post">
                @csrf
                <input type="hidden" name="prixTotal" value="{{$prixTotal}}">
                <input type="hidden" name="poidsTotal" value="{{$poidsTotal}}">
                <button type="submit" class="buy">Acheter</button>
            </form>
        </div>


    </div>
    <script>
        let popup = document.getElementById('popup')
        document.addEventListener('DOMContentLoaded', function () {


            if (popup) {
                popup.classList.add('open-popup')
            }
        });


        function closePopUp() {
            popup.classList.remove('open-popup')

        }

        document.querySelectorAll(".cartBox").forEach(cartBox => {
            const decrementBtn = cartBox.querySelector(".decrement");
            const incrementBtn = cartBox.querySelector(".increment");
            const quantityDisplay = cartBox.querySelector(".value");

            let quantity = parseInt(quantityDisplay.textContent);

            // Initial state
            if (quantity <= 1) {
                decrementBtn.style.color = "#130606";
                decrementBtn.style.cursor = "not-allowed";
            }

            decrementBtn.addEventListener("click", () => {
                if (quantity > 1)
                    quantity--;
                quantityDisplay.textContent = quantity;

                if (quantity === 1) {
                    decrementBtn.style.color = "#130606";
                    decrementBtn.style.cursor = "not-allowed";
                }
            });


            incrementBtn.addEventListener("click", () => {
                quantity++;
                quantityDisplay.textContent = quantity;

                if (quantity > 1) {
                    decrementBtn.style.color = "#999";
                    decrementBtn.style.cursor = "pointer";
                }
            });

        });

    </script>
@endsection
