function timer(duration, display) {
    setInterval(function () {

        display.textContent = duration;

        if (--duration < 0) {
            window.location.replace('../../Accueil/Presentation/presentation.php');
        }
    }, 1000);
}

function startTimer() {
        display = document.querySelector('#time');
    timer(2, display);
};