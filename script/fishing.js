function pindah(url) {
  window.location = url;
}

const bar = document.getElementById('bar');
const fish = document.getElementById('fish');
const startButton = document.getElementById('start-button');
const upButton = document.getElementById('up-button');
const downButton = document.getElementById('down-button');
const progressDisplay = document.getElementById('progress');
const messageDisplay = document.getElementById('message');
let barPosition = 120;
let fishPosition = 50;
let progress = 0;
let gameInterval, fishInterval;
let gameTimeout;

progressDisplay.textContent = "Ayo Memancing!";
messageDisplay.textContent = "";

function moveBar(direction) {
  if (direction === 'up') {
    barPosition -= 10;
  } else if (direction === 'down') {
    barPosition += 10;
  }

  if (barPosition < 0) barPosition = 0;
  if (barPosition > 240) barPosition = 240;

  bar.style.top = `${barPosition}px`;
}

function moveFish() {
  fishPosition += Math.random() * 80 - 40;

  if (fishPosition < 0) fishPosition = 0;
  if (fishPosition > 280) fishPosition = 280;

  fish.style.top = `${fishPosition}px`;
}

function checkCollision() {
  const barTop = barPosition;
  const barBottom = barPosition + 80;
  const fishTop = fishPosition;
  const fishBottom = fishPosition + 20;

  if (barBottom >= fishTop && barTop <= fishBottom) {
    progress += 1;
  } else {
    progress -= 0.5;
  }

  if (progress < 0) progress = 0;
  if (progress >= 100) {
    progress = 100;
    endGame(true);
  }

  progressDisplay.textContent = `Progress: ${Math.floor(progress)}%`;

  if (progress === 0) {
    endGame(false);
  }
}

function startGame() {
  progress = 30;
  progressDisplay.textContent = `Progress: ${progress}%`;
  messageDisplay.textContent = "";

  fishPosition = 50;
  barPosition = 120;
  bar.style.top = `${barPosition}px`;
  fish.style.top = `${fishPosition}px`;

  startButton.textContent = 'Fishing...';
  startButton.disabled = true;

  upButton.disabled = false;
  downButton.disabled = false;

  gameInterval = setInterval(checkCollision, 50);
  fishInterval = setInterval(moveFish, 200);

  clearTimeout(gameTimeout);
  gameTimeout = setTimeout(() => {
    if (progress < 100) {
      endGame(false);
    }
  }, 20000);
}


function endGame(success) {
  clearInterval(gameInterval);
  clearInterval(fishInterval);
  clearTimeout(gameTimeout);
  startButton.textContent = 'Start Fishing';
  startButton.disabled = false;

  upButton.disabled = true;
  downButton.disabled = true;

  if (success) {
    completeGame();
  } else {
    const failMessages = [
      "Yah.. Ikanmu lepas kawan!",
      "Sepertinya kau masih Pemula.",
      "Ayo coba lagi",
      "Tarik yang kuat dong!",
      "Bahkan ikan meninggalkanmu kawan."
    ];

    const randomMessage = failMessages[Math.floor(Math.random() * failMessages.length)];

    progressDisplay.textContent = randomMessage;
    messageDisplay.textContent = "";

    const failAudio = new Audio('assets/fail_sfx.mp3');
    failAudio.volume = 0.5;
    failAudio.loop = false;
    failAudio.autoplay = false;
    failAudio.hidden = true;
    failAudio.play();
  }
}

startButton.addEventListener('click', startGame);
upButton.addEventListener('click', () => moveBar('up'));
downButton.addEventListener('click', () => moveBar('down'));

const fishData = [
  "Carp", "Catfish", "Eel", "Lava Eel", "Octopus", "Pufferfish",
  "Salmon", "Sandfish", "Sardine", "Squid", "StoneFish", 
  "Super Cucumber", "Tuna"
];

function getRandomFish() {
  const randomIndex = Math.floor(Math.random() * fishData.length);
  return fishData[randomIndex];
}

function completeGame() {
  const caughtFish = getRandomFish();
  const fishImage = `assets/${caughtFish.replace(" ", "")}.png`;

  document.getElementById("fish-name").value = caughtFish;
  document.getElementById("fish-image").value = fishImage;

  const fishForm = document.getElementById("fish-form");
  const formData = new FormData(fishForm);
  fetch("fishing.php", {
    method: "POST",
    body: formData,
  }).then(() => {
    const successMessages = [
      `Yuhuu.. Kau dapat ${caughtFish}!`,
      `Lets Gooo! Kau dapat ${caughtFish}!`,
      `${caughtFish}? Boleh juga kau!`,
      `Kau mendapatkan ${caughtFish}`,
      `Iwak ${caughtFish} berhasil ditangkap!`
    ];

    const randomMessage = successMessages[Math.floor(Math.random() * successMessages.length)];

    progressDisplay.textContent = randomMessage;
    messageDisplay.textContent = "";

    const successAudio = new Audio('assets/success_sfx.mp3');
    successAudio.volume = 0.5;
    successAudio.loop = false;
    successAudio.autoplay = false;
    successAudio.hidden = true;
    successAudio.play();
  }).catch(() => {
    progressDisplay.textContent = "Ikanmu kabur kawan!";
  });
}

