function pindah(url){
    window.location = url;
}


// Fishing Game
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
let gameTimeout;

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

  // Set timeout untuk kegagalan permainan
  clearTimeout(gameTimeout);
  gameTimeout = setTimeout(() => {
  if (progress < 100) {
    endGame(false);
  }
 }, 20000); // Misalnya, permainan gagal jika tidak selesai dalam 30 detik
}

function endGame(success) {
  clearInterval(gameInterval);
  clearInterval(fishInterval);
  clearTimeout(gameTimeout);
  startButton.textContent = 'Start Fishing';
  startButton.disabled = false;

  if (success) {
    completeGame();
  } else {
    alert("Game Over! Try again.");
  }

  // Reset posisi bar dan ikan
  barPosition = 110;
  fishPosition = 50;
  bar.style.top = `${barPosition}px`;
  fish.style.top = `${fishPosition}px`;
  progress = 0;
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

// Data ikan
const fishData = [
  "Carp",
  "Catfish",
  "Eel",
  "Lava Eel",
  "Octopus",
  "Pufferfish",
  "Salmon",
  "Sandfish",
  "Sardine",
  "Squid",
  "StoneFish",
  "Super Cucumber",
  "Tuna"
];

// Fungsi untuk mendapatkan ikan secara acak
function getRandomFish() {
  const randomIndex = Math.floor(Math.random() * fishData.length);
  return fishData[randomIndex];
}

// Fungsi untuk menyelesaikan game
function completeGame() {
  const caughtFish = getRandomFish();
  alert(`Congratulations! You caught a ${caughtFish}!`);
}