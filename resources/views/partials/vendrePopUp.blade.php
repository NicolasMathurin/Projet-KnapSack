@extends('layouts.default')
@section('title', 'item')
@section('content')

    {{--@section('css',asset('js/script.js'))--}}
    @section('css',asset('./css/vendreStyles.css'))

    <div class="sellMain" id="vendre">
                <div class="flexTop d-flex flex-col ">
                    <h1 class="titre">Acide</h1>
                    <button type="submit" id="fermer" class="ri-delete-bin-2-line supp flex-shrink-0 " name="action"
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
                            <input type="number" class="value" value="1" min="1" max=""/>
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
    <script>
        let popup = document.getElementById('vendre')
        document.addEventListener('DOMContentLoaded', function () {
            if (popup) {
                popup.classList.add('open-popup')
            }
        });

        function closePopUp() {
            popup.classList.remove('open-popup')
        }

        document.querySelectorAll(".sellMain").forEach(vendreMain => {
            const decrementBtn = vendreMain.querySelector(".decrement");
            const incrementBtn = vendreMain.querySelector(".increment");
            const quantityDisplay = vendreMain.querySelector(".value");

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

    </script>
@endsection
