function pindah(url){
    window.location = url;
}

const bar = document.getElementById('bar');
const fish = document.getElementById('fish');
const startButton = document.getElementById('start-button');
const upButton = document.getElementById('up-button');
const downButton = document.getElementById('down-button');
const progressDisplay = document.getElementById('progress');
let barPosition = 110;
let fishPosition = 50;
let progress = 0;
let gameInterval, fishInterval;

function moveBar(direction) {
  if (direction === 'up') {
    barPosition -= 10; // Kecepatan gerakan bar
  } else if (direction === 'down') {
    barPosition += 10;
  }

  if (barPosition < 0) barPosition = 0;
  if (barPosition > 220) barPosition = 220; // Tinggi fishing area - bar height

  bar.style.top = `${barPosition}px`;
}

function moveFish() {
  // Dinamis: Ikan bergerak cepat dan acak
  fishPosition += Math.random() * 80 - 40; // Perubahan posisi ikan

  if (fishPosition < 0) fishPosition = 0;
  if (fishPosition > 280) fishPosition = 280; // Tinggi fishing area - fish height

  fish.style.top = `${fishPosition}px`;
}

function checkCollision() {
  const barTop = barPosition;
  const barBottom = barPosition + 80; // Tinggi bar
  const fishTop = fishPosition;
  const fishBottom = fishPosition + 20; // Tinggi ikan

  if (barBottom >= fishTop && barTop <= fishBottom) {
    progress += 1; // Tambah progres jika overlap
  } else {
    progress -= 0.5; // Kurangi progres jika tidak overlap
  }

  if (progress < 0) progress = 0;
  if (progress >= 100) {
    progress = 100;
    endGame(true);
  }

  progressDisplay.textContent = `${Math.floor(progress)}%`;
}

function startGame() {
  progress = 0;
  progressDisplay.textContent = `${progress}%`;

  fishPosition = 50;
  barPosition = 110;
  bar.style.top = `${barPosition}px`;
  fish.style.top = `${fishPosition}px`;

  startButton.textContent = 'Fishing...';
  startButton.disabled = true;

  gameInterval = setInterval(() => {
    checkCollision();
  }, 50);

  fishInterval = setInterval(() => {
    moveFish();
  }, 200); // Interval gerakan ikan
}

function endGame(won) {
  clearInterval(gameInterval);
  clearInterval(fishInterval);
  startButton.textContent = won ? 'You Win! Play Again' : 'Play Again';
  startButton.disabled = false;
}

startButton.addEventListener('click', () => {
  startGame();
});

upButton.addEventListener('click', () => {
  moveBar('up');
});

downButton.addEventListener('click', () => {
  moveBar('down');
});
