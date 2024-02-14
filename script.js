document.addEventListener('DOMContentLoaded', () => {
    const board = document.getElementById('ticTacToeBoard');
    const gameContainer = document.getElementById('gameContainer');
    const resultContainer = document.getElementById('resultContainer');
    const gameStatus = document.getElementById('gameStatus');
    const resultMessage = document.getElementById('resultMessage');
    let currentPlayer = 'X';
    let gameBoard = ['', '', '', '', '', '', '', '', ''];

    for (let i = 0; i < 9; i++) {
        const cell = document.createElement('div');
        cell.classList.add('cell');
        cell.dataset.index = i;
        cell.addEventListener('click', () => cellClicked(i));
        board.appendChild(cell);
    }

    function cellClicked(index) {
        if (gameBoard[index] === '' && !isGameOver()) {
            gameBoard[index] = currentPlayer;
            updateBoard();
            if (checkWinner()) {
                showResult(`Player ${currentPlayer} wins!`);
            } else if (isBoardFull()) {
                showResult('It\'s a tie!');
            } else {
                currentPlayer = currentPlayer === 'X' ? 'O' : 'X';
                gameStatus.textContent = `Current Player: ${currentPlayer}`;
            }
        }
    }

    function updateBoard() {
        const cells = document.querySelectorAll('.cell');
        cells.forEach((cell, index) => {
            cell.textContent = gameBoard[index];
        });
    }

    function checkWinner() {
        const winningCombos = [
            [0, 1, 2], [3, 4, 5], [6, 7, 8], // Rows
            [0, 3, 6], [1, 4, 7], [2, 5, 8], // Columns
            [0, 4, 8], [2, 4, 6]             // Diagonals
        ];

        return winningCombos.some(combo => {
            const [a, b, c] = combo;
            return gameBoard[a] && gameBoard[a] === gameBoard[b] && gameBoard[a] === gameBoard[c];
        });
    }

    function isBoardFull() {
        return gameBoard.every(cell => cell !== '');
    }

    function isGameOver() {
        return checkWinner() || isBoardFull();
    }

    function showResult(message) {
        resultMessage.textContent = message;
        gameContainer.style.display = 'none';
        resultContainer.style.display = 'flex';
    }

    function startNewGame() {
        gameBoard = ['', '', '', '', '', '', '', '', ''];
        currentPlayer = 'X';
        gameStatus.textContent = 'Current Player: X';
        updateBoard();
        gameContainer.style.display = 'flex';
        resultContainer.style.display = 'none';
    }
});
