document.addEventListener('DOMContentLoaded', function () {
    const startBtn = document.querySelector('.start-btn');
    const pupupDifficulty = document.querySelector('.popup-difficulty');
    const exitBtn = document.querySelector('.exit-btn');
    const main = document.querySelector('.home');
    const continueBtn = document.querySelector('.continue-btn');
    const quizSection = document.querySelector('.quiz-section');
    const quizContent = document.querySelector('.quiz-content');
    const resultBox = document.querySelector('.result-box');


    startBtn.onclick = () => {
        pupupDifficulty.classList.add('active');
        main.classList.add('active');
    }
    exitBtn.onclick = () => {
        pupupDifficulty.classList.remove('active');
        main.classList.remove('active');
    }
    continueBtn.onclick = () => {
        quizSection.classList.add('active');
        quizContent.classList.add('active');
        pupupDifficulty.classList.remove('active');
        main.classList.remove('active');

        startTimer(30);
    }

    let questionsCount = 0;
    let questionNumb = 1;
    let userScore = 0;

    const optionsList = document.querySelector('.option-list');

    function optionSelected(answer) {
        let userAnswer = answer.textContent;
        let correctAnswer = questions[questionsCount].reponse;
        if (userAnswer === correctAnswer) {
            answer.classList.add('correct');
            userScore += 1;
            headerScore();
        } else {
            answer.classList.add('incorrect');
            for (let i = 0; i < optionsList.children.length; i++) {
                if (optionsList.children[i].textContent == correctAnswer) {
                    optionsList.children[i].setAttribute('class', 'option correct');
                }
            }
        }
        for (let i = 0; i < optionsList.children.length; i++) {
            optionsList.children[i].classList.add('disabled');
        }

        nextBtn.classList.add('active');
    }

//----------------------------------------Timer--------------------------------//

    const timerDisplay = document.querySelector('.header-time');

    let timer;
    let timeLeft = 30;

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

});
