@if (session('message-sucess') || session('message-error'))
    <div class="containerPop">
        <div class="popup" id="popup">
            @if (session('message-sucess'))
                <h2>{{ session('message-sucess') }}</h2>

            @elseif(session('message-error'))
                <h2> {{ session('message-error') }}</h2>
            @endif
        </div>
    </div>

<script>
    let popup = document.getElementById('popup')
    document.addEventListener('DOMContentLoaded', function () {
        if (popup) {
            popup.classList.add('open-popup')
            setTimeout(closePopUp,1500)
        }
    });

    function closePopUp() {
        popup.classList.remove('open-popup')
    }

</script>
@endif


