var music = document.getElementById('bgMusic');

window.onload = function() {
    if (sessionStorage.getItem('isMusicPlaying') === 'true') {
        music.play();
    }
};

window.addEventListener('click', function() {
    music.play();
    sessionStorage.setItem('isMusicPlaying', 'true');
});

window.addEventListener('keydown', function(event) {
    if (event.key === 'p') {
        music.pause();
        sessionStorage.setItem('isMusicPlaying', 'false');
    }
});