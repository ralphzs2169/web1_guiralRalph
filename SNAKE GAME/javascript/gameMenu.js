import { updateDifficulty, canvas ,renderGame, startGame, generateObstacles, modifyCanvas, playSound, gameDifficulty, restartGame} from "./gameManager.js";
import { resetSnake } from "./snake.js";

export let previewDifficulty = 0; // The difficulty currently shown in the menu
export const selectedDifficulty = document.getElementById('selected-difficulty');

const title = document.getElementsByTagName('h1')[0];
const start = document.getElementById('start-btn');
const mainMenu = document.querySelector('.main-menu-container');
const tryAgainButton = document.getElementById('try-again-btn');
const backToMenuButtons = document.querySelectorAll('.back-to-menu');
const prevDifficulty = document.getElementById('prev-difficulty-btn');
const nxtDifficulty = document.getElementById('nxt-difficulty-btn');

const instructionsBtn = document.getElementById('instructions-btn');
const instructions = document.querySelector('.instructions-container');

export let displayScoreToBeat = document.getElementById('score-to-beat');

const canvasHeader = document.querySelector('.canvas-header');
const gameoverLabel = document.querySelector('.gameover-header');

export const eatSound = new Audio('audio/eat-sound.mp3');
export const buttonClickSound = new Audio("audio/button-click.mp3");
const newHighscoreSound = new Audio("audio/new-highscore.wav");
const gameOversound = new Audio("audio/gameover1.wav");

window.onload = () => {
    let bgImage = new Image();
    bgImage.src = "images/bg.jpg"; 

    bgImage.onload = function() {
        document.querySelector(".main-container").style.backgroundImage = `url('${bgImage.src}')`;
        document.querySelector(".loader-container").style.display = "none";
    };
};

prevDifficulty.addEventListener('click', (e) => {
    if(--previewDifficulty === -1) previewDifficulty = 3
    playSound(buttonClickSound);
    updateDifficulty(previewDifficulty);
});

nxtDifficulty.addEventListener('click', (e) => {
    if(++previewDifficulty === 4) previewDifficulty = 0
  
    playSound(buttonClickSound);
    updateDifficulty(previewDifficulty);
});

start.addEventListener('click', (e) => {
    playSound(buttonClickSound);
    mainMenu.style.display = 'none';
    canvas.style.display = 'block';
    canvasHeader.style.display = 'flex';
    title.style.fontSize = '4rem';

    const snakeSpeed = updateDifficulty(previewDifficulty);
    modifyCanvas();
    if (previewDifficulty === 3) generateObstacles();

    resetSnake();
    renderGame();
    startGame(e, snakeSpeed);
})

instructionsBtn.addEventListener('click', (e) => {
    playSound(buttonClickSound);
    mainMenu.style.display = 'none';
    instructions.style.display = 'block';
})

tryAgainButton.addEventListener('click', restartGame);

backToMenuButtons[0].addEventListener('click', handleBackToMainMenu);
backToMenuButtons[1].addEventListener('click', handleBackToMainMenu);

function handleBackToMainMenu(){
    playSound(buttonClickSound);
    popupGameover.remove();

    mainMenu.style.display = 'block';
    instructions.style.display = 'none';
    canvas.style.display = 'none';
    canvasHeader.style.display = 'none';
    title.style.fontSize = '5rem';

    document.removeEventListener("keydown", handleEnterPress);
}

function handleEnterPress(event){
    if (event.key === "Enter") {
        restartGame();
        document.removeEventListener("keydown", handleEnterPress);
    }
}

export const popupGameover = {
    popupbackground : document.querySelector('.popup-background'),
    popup : document.querySelector('.popup-gameover'),
    finalScore: document.getElementById('final-score'),
    finalScoreContainer: document.querySelector('.final-score-container'),
    newHighscoreLabel: document.getElementById('new-highscore-label'),
    currentDifficulty: document.getElementById('current-difficulty'),
    
    show() {
        playSound(gameOversound);
        gameoverLabel.textContent = 'GAME OVER'
        gameoverLabel.style.paddingInline = '0';

        styleFinalScore('white', '6rem', '2px', 'black');

        this.popupbackground.style.display = 'block';
        this.popup.style.display = 'flex';
        displayScoreToBeat.style.display = 'block';
       

        document.addEventListener("keydown", handleEnterPress);
    },

    showNewHighscore(){
        playSound(newHighscoreSound);
        gameoverLabel.textContent = 'NEW HIGHSCORE'
        gameoverLabel.style.paddingInline = '.3em';

        const difficulty = (gameDifficulty[previewDifficulty].name);

        this.currentDifficulty.textContent = `${difficulty.charAt(0).toUpperCase().concat(difficulty.substring(1))}`
        this.newHighscoreLabel.style.display = 'block';

        styleFinalScore('#55bb00', '8rem', '4px', 'white');

        this.popupbackground.style.display = 'block';
        this.popup.style.display = 'flex';

        document.addEventListener("keydown", handleEnterPress);
    },

    remove() {
        displayScoreToBeat.style.display = 'none';
        this.newHighscoreLabel.style.display = 'none';
        this.popupbackground.style.display = 'none';
        this.popup.style.display = 'none';  
    }
}

function styleFinalScore (fontColor, fontSize, px, color){
    const textShadow = `-${px} -${px} 0 ${color}, 
                         ${px} -${px} 0 ${color}, 
                        -${px}  ${px} 0 ${color}, 
                         ${px}  ${px} 0 ${color}`
    popupGameover.finalScore.style.color = fontColor;
    popupGameover.finalScore.style.fontSize = fontSize;
    popupGameover.finalScore.style.textShadow = textShadow;
}