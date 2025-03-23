import { canvas, ctx, box, obstacles,  playSound, foodImage }  from "./gameManager.js"
import { currentHighScore, gameOver, displayScore, displayHighscore } from "./gameManager.js";
import { previewDifficulty } from './gameMenu.js'

let score = 0;

export const snake = {
    bodyPosition : [{
        x: Math.floor(canvas.width / (2 * box)) * box, 
        y: Math.floor(canvas.height / (2 * box)) * box
    }],
    food : {
        x: Math.floor(Math.random() * (canvas.width / box)) * box,
        y: Math.floor(Math.random() * (canvas.height / box)) * box
    },
    direction: null
}

const snakeImages = {
    LEFT: new Image(),
    UP: new Image(),
    RIGHT: new Image(),
    DOWN: new Image()
};

snakeImages.LEFT.src = "images/snake-left.png";
snakeImages.UP.src = "images/snake-up.png";
snakeImages.RIGHT.src = "images/snake-right.png";
snakeImages.DOWN.src = "images/snake-down.png";

const eatSound = new Audio('/audio/eat-sound.mp3');
eatSound.volume = 1.0;
let directionChanged = false; // Once a direction is pressed, the value of this variable changes, preventing another move to be detected
document.addEventListener("keydown", changeDirection);

export function changeDirection(event) {
    // If the player already pressed a key, any extra key presses are ignored until the next frame.
    if (directionChanged) return; 

    const key = event.key;

    if (key === "ArrowLeft" && snake.direction !== "RIGHT") snake.direction = "LEFT";
    if (key === "ArrowUp" && snake.direction !== "DOWN") snake.direction = "UP";
    if (key === "ArrowRight" && snake.direction !== "LEFT") snake.direction = "RIGHT";
    if (key === "ArrowDown" && snake.direction !== "UP") snake.direction = "DOWN";

    directionChanged = true; // Block extra inputs
}

export function drawCanvas(){
    // Drawing the alternating grid
    for (let row = 0; row < canvas.height / box; row++) {
        for (let col = 0; col < canvas.width / box; col++) {
            ctx.fillStyle = (row + col) % 2 === 0 ? "#a5d34f" : "#a0d14b";
            ctx.fillRect(col * box, row * box, box, box);
        }
    }
}

export function drawFood(){
    ctx.drawImage(foodImage, snake.food.x, snake.food.y, box, box);
}

export function drawObstacles(){
    if (previewDifficulty === 3) {
        ctx.fillStyle = "gray";
        obstacles.forEach(obstacle => {
            ctx.fillRect(obstacle.x, obstacle.y, box, box);
        });
    }
}

export function drawSnake(){
    snake.bodyPosition.forEach((segment, index) => {
        if (index === 0) {
            // Use the correct image for the head based on direction
            ctx.drawImage(snakeImages[snake.direction ?? "UP"], segment.x, segment.y, box, box);
            ctx.strokeStyle = "#3b57f7"; 
            ctx.lineWidth = 2;
            ctx.strokeRect(segment.x, segment.y, box, box);
        } else {
            // Draw normal body
            ctx.fillStyle = "#4760f7";
            ctx.fillRect(segment.x, segment.y, box, box);

            // Adding border
            ctx.strokeStyle = "#3b57f7"; 
            ctx.lineWidth = 2;
            ctx.strokeRect(segment.x, segment.y, box, box);
        }
    });
}

export function moveSnake() {
    directionChanged = false; // allow new direction in the next frame

    let head = { ...snake.bodyPosition[0] }; // get the current position of the head

    if (snake.direction === "LEFT") head.x -= box;
    if (snake.direction === "UP") head.y -= box;
    if (snake.direction === "RIGHT") head.x += box;
    if (snake.direction === "DOWN") head.y += box;
  
    // check if the snake eats food
    if (head.x === snake.food.x && head.y === snake.food.y) {       
        playSound(eatSound);
        // ensures resetFood will execute in the next frame to avoid generating it on the snake's body
        requestAnimationFrame(() => resetFood()); 
        score++;

        if (score > currentHighScore) displayHighscore.textContent = score

        displayScore.textContent = score;
    } else {
        snake.bodyPosition.pop();
    }

    // check collision with walls or itself
    if (head.x < 0 || head.x >= canvas.width || 
        head.y < 0 || head.y >= canvas.height || 
        checkCollision(head) || 
        ((previewDifficulty) === 3 && obstacles.some(obstacle => obstacle.x === head.x && obstacle.y === head.y)) // Check collision with obstacles
    ) {
        gameOver(score);
    }
    
    snake.bodyPosition.unshift(head);
}

export function resetSnake(){
    let initialPosition;
    do {
        initialPosition = {
            x: Math.floor(Math.random() * (canvas.width / box)) * box, 
            y: Math.floor(Math.random() * (canvas.height / box)) * box
        };
    } while (previewDifficulty === 3 && obstacles.some(obstacle => obstacle.x === initialPosition.x && obstacle.y === initialPosition.y));

    snake.bodyPosition = [initialPosition];

    // Reset score
    score = 0;
    displayScore.textContent = score;
}

export function resetFood() {
    let newFoodPosition;
    let attempts = 0;
    const maxAttempts = 100; // Prevent infinite loops

    do {
        newFoodPosition = {
            x: Math.floor(Math.random() * (canvas.width / box)) * box,
            y: Math.floor(Math.random() * (canvas.height / box)) * box
        };
        attempts++;
    } while (
        (snake.bodyPosition.some(segment => segment.x === newFoodPosition.x && segment.y === newFoodPosition.y) ||
        (previewDifficulty === 3 && obstacles.some(obstacle => obstacle.x === newFoodPosition.x && obstacle.y === newFoodPosition.y))) 
        && attempts < maxAttempts
    );

    // If no valid position was found
    if (attempts >= maxAttempts) {
        gameOver();
        return;
    }
    
    snake.food = newFoodPosition;
}

function checkCollision(head) {
    return snake.bodyPosition.some((segment, index) => index !== 0 && segment.x === head.x && segment.y === head.y) ||
           (previewDifficulty === 3 && obstacles.some(obstacle => obstacle.x === head.x && obstacle.y === head.y));
}





