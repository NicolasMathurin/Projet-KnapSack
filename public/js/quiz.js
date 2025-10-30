document.addEventListener('DOMContentLoaded', function() {

startTimer(180);

showQuestions(questionsCount);

//----------------------------------------Timer--------------------------------//

    const timerDisplay = document.querySelector('.header-time');

    let timer; // pour pouvoir l'arrêter si besoin
    let timeLeft = 30; // par exemple, 30 secondes par question

    function startTimer(duration) {
        timeLeft = duration;
        updateTimerDisplay();

        timer = setInterval(() => {
            timeLeft--;
            updateTimerDisplay();

            if (timeLeft <= 0) {
                clearInterval(timer);

                alert("Temps écoulé !");
            }
        }, 1000);
    }

    function updateTimerDisplay() {
        let minutes = Math.floor(timeLeft / 60).toString().padStart(2, '0');
        let seconds = (timeLeft % 60).toString().padStart(2, '0');
        timerDisplay.textContent = `Temps restant: ${minutes}:${seconds}`;
    }

    function showQuestions(index) {
        const questionText = document.querySelector('.question-text');
        questionText.textContent = `Question ${questions[index].numero}: ${questions[index].question}`;

        let optionsTag = `<div class="option"><span>${questions[index].options[0]}</span></div>
            <div class="option"><span>${questions[index].options[1]}</span></div>
            <div class="option"><span>${questions[index].options[2]}</span></div>
            <div class="option"><span>${questions[index].options[3]}</span></div>`;

        optionsList.innerHTML = optionsTag;

        const option = optionsList.querySelectorAll('.option');
        console.log(option.length);
        for (let i = 0; i < option.length; i++) {
            console.log(option[i]);
            option[i].addEventListener('click', function () {
                console.log("lol");
                optionSelected(this);
            });
        }
    }

});
//----------------------------------------Questions--------------------------------//
let questions = [
    {
        "numero": 1,
        "question": "Quelle est la capitale de l'Espagne ?",
        "reponse": "Madrid",
        "options": ["Madrid", "Barcelone", "Séville", "Valence"]
    },
    {
        "numero": 2,
        "question": "Qui a écrit 'Le Petit Prince' ?",
        "reponse": "Antoine de Saint-Exupéry",
        "options": ["Victor Hugo", "Antoine de Saint-Exupéry", "Molière", "Albert Camus"]
    },
    {
        "numero": 3,
        "question": "Quelle est la formule chimique de l'eau ?",
        "reponse": "H2O",
        "options": ["CO2", "O2", "H2O", "CH4"]
    },
    {
        "numero": 4,
        "question": "Combien de continents y a-t-il sur Terre ?",
        "reponse": "7",
        "options": ["5", "6", "7", "8"]
    },
    {
        "numero": 5,
        "question": "Quel est l'animal terrestre le plus rapide ?",
        "reponse": "Guépard",
        "options": ["Guépard", "Lion", "Gazelle", "Léopard"]
    }
]
