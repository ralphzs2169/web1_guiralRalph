import { snake, drawCanvas, drawFood, drawObstacles, drawSnake } from "./snake.js";
import { changeDirection, resetSnake, moveSnake, resetFood } from "./snake.js";
import { selectedDifficulty, previewDifficulty, popupGameover, displayScoreToBeat, buttonClickSound } from "./gameMenu.js";

export const canvas = document.getElementById("gameCanvas");
export const ctx = canvas.getContext("2d");

export let game; //for the interval(game loop)
export let box; //size for each cell (pixel x pixel)

const displayDifficulty = document.getElementById('difficulty');
export const displayScore = document.getElementById('score');
export const displayHighscore = document.getElementById('highscore');
export const displayFinalScore = document.getElementById('final-score');  
export let obstacles = []; // for extreme difficulty

export let currentHighScore;

export const foodImage = new Image();
foodImage.src = "images/apple.png"

export let highscores = { easy: 0, normal: 0, hard: 0, extreme: 0 }

if (localStorage.getItem('highscores') === null) {
    localStorage.setItem('highscores', JSON.stringify(highscores));
}

export const gameDifficulty = [
    { name: "easy", speed: 110, canvasWidth: 750, canvaseHeight: 500, cellSize: 50 },
    { name: "normal", speed: 70, canvasWidth: 750, canvaseHeight: 500, cellSize: 50},
    { name: "hard", speed: 40, canvasWidth: 800, canvaseHeight: 560, cellSize: 40 },
    { name: "extreme", speed: 50, canvasWidth: 840, canvaseHeight: 560, cellSize: 40 }
];

function gameLoop() {
    moveSnake();
    renderGame();
}

export function playSound(sound){
    sound.currentTime = 0;
    sound.play();
}

export function renderGame() {
    drawCanvas();
    drawFood(); 
    drawSnake();    
    if (previewDifficulty === 3) drawObstacles(); 
}

export function modifyCanvas(){
    box = gameDifficulty[previewDifficulty].cellSize;
    canvas.width = gameDifficulty[previewDifficulty].canvasWidth;
    canvas.height = gameDifficulty[previewDifficulty].canvaseHeight;

    resetFood();
    renderGame();
}

export function updateDifficulty(previewDifficulty) {
    // reset all highlights 
    gameDifficulty.forEach(difficulty => {
        document.getElementById(`highlight-${difficulty.name}`).style.background = 'white';
    })

    // highlight selected difficulty
    document.getElementById(`highlight-${gameDifficulty[previewDifficulty].name}`).style.background = '#30800d';

    const difficultyName = gameDifficulty[previewDifficulty].name.charAt(0).toUpperCase() +
                           (gameDifficulty[previewDifficulty].name.substring(1)).toLowerCase();

    selectedDifficulty.textContent = difficultyName;
    displayDifficulty.textContent = `Difficulty: ${difficultyName}`;

    return gameDifficulty[previewDifficulty].speed;
}

export function startGame(event, snakeSpeed) {
    clearInterval(game);
    if (previewDifficulty !== 3) obstacles = []; //remove all obstacles

    snake.direction = null;

    if (!snake.direction) {
        if (event.key === "ArrowLeft") snake.direction = "LEFT";
        if (event.key === "ArrowUp") snake.direction = "UP";
        if (event.key === "ArrowRight") snake.direction = "RIGHT";
        if (event.key === "ArrowDown") snake.direction = "DOWN";

        game = setInterval(gameLoop, snakeSpeed);
        refreshHighscore();

        // Re-enable movement controls
        document.addEventListener("keydown", changeDirection);
    }
}

export function restartGame(){
    playSound(buttonClickSound);
    popupGameover.remove();

    const snakeSpeed = updateDifficulty(previewDifficulty);
    
    if (previewDifficulty === 3) generateObstacles();
    resetSnake();
    resetFood();
    renderGame();

    // Wait for a keypress before restarting
    document.addEventListener("keydown", (e) => startGame(e, snakeSpeed), { once: true });
}

export function refreshHighscore(){
    highscores = JSON.parse(localStorage.getItem('highscores'));

    const difficultyLevels = gameDifficulty.map(difficulty => difficulty.name);
    const currentLevel = difficultyLevels[previewDifficulty];

    displayHighscore.textContent = highscores[currentLevel]; 
    currentHighScore = highscores[currentLevel];
}

export function gameOver(score) {
    // Stop the game loop
    clearInterval(game);

    const currentDifficulty = gameDifficulty[previewDifficulty].name;

    if (score > highscores[currentDifficulty]) {
        popupGameover.showNewHighscore();
        highscores[currentDifficulty] = score;
        displayFinalScore.textContent = score;
        // store new highscore to the browser
        localStorage.setItem('highscores', JSON.stringify(highscores));
    } else {
        popupGameover.show();
        displayFinalScore.textContent = score;
        displayScoreToBeat.textContent = `Score to Beat: ${currentHighScore}`;
    }

    // Remove movement listener to prevent conflicts
    document.removeEventListener("keydown", changeDirection);
}

export function generateObstacles() {
    obstacles = [];

    if (previewDifficulty === 3) {
        let numObstacles = 8; 

        for (let i = 0; i < numObstacles; i++) {
            let obstacle;
            do {
                obstacle = {
                    x: Math.floor(Math.random() * (canvas.width / box)) * box,
                    y: Math.floor(Math.random() * (canvas.height / box)) * box
                };
            } while (
                snake.bodyPosition.some(segment => segment.x === obstacle.x && segment.y === obstacle.y) || 
                (snake.food.x === obstacle.x && snake.food.y === obstacle.y) // Ensure no collision with food
            );

            obstacles.push(obstacle);
        }
    }
}



//✅ FIX FOOD GENERATION BUG
//✅ CHANCE LOGIC FOR THE CANVAS CHANGE SINCE CURRENTLY EVERY BUTTON CLICK IT CHANGES THE CANVAS IMMEDIATLEY
//✅ ADD HISGHCORE FEATURE (STORE IN BROWSER)
//✅ FIX UI
//✅ ADD INSTRUCTIONS