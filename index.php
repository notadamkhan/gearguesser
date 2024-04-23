<!doctype html>
<html>

<head>
    <!-- URL: https://cs4640.cs.virginia.edu/azk7ad/gearguesser/ -->
    <!-- SOURCE FOR CONFETTI: https://github.com/catdad/canvas-confetti -->

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/main.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.2/dist/confetti.browser.min.js"></script>

    <title>GearGuesser</title>
</head>

<?php
// include 'session.php';
// error_reporting(E_ALL);
// ini_set("display_errors", 1);
include '../../private/session.php';

$data = [];



?>

<body>
    <div class="heading">
        <h1>GearGuesser</h1>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            id="profile-icon">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
        </svg>
    </div>

    <div class="main-card">
        <div class="row row-1">
            <div id="collection-group">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="collection-icon" width="20">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6 6.878V6a2.25 2.25 0 0 1 2.25-2.25h7.5A2.25 2.25 0 0 1 18 6v.878m-12 0c.235-.083.487-.128.75-.128h10.5c.263 0 .515.045.75.128m-12 0A2.25 2.25 0 0 0 4.5 9v.878m13.5-3A2.25 2.25 0 0 1 19.5 9v.878m0 0a2.246 2.246 0 0 0-.75-.128H5.25c-.263 0-.515.045-.75.128m15 0A2.25 2.25 0 0 1 21 12v6a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18v-6c0-.98.626-1.813 1.5-2.122" />
                </svg>
                <span class="collection-name">
                    <?php echo isset($_SESSION['category']) ? $_SESSION['category'] : 'Categories'; ?>
                </span>
            </div>
        </div>

        <div class="row row-2">
            <img src="img/<?php echo (isset($_SESSION['car_id']) && $_SESSION['attempt_number'] < 6) ? $_SESSION['car_id'] . '-' . $_SESSION['attempt_number'] : 'img1'; ?>.jpg"
                alt="Car Image" class="car-image">

        </div>
        <div id="guess-indicator">
            <div class="circle"></div>
            <div class="circle"></div>
            <div class="circle"></div>
            <div class="circle"></div>
            <div class="circle"></div>
        </div>
        <div id="result-container" style="margin: 10px;">
            <?php
            if (isset($_SESSION['result_message'])) {
                echo $_SESSION['result_message'];
                // unset($_SESSION['result_message']);
            }
            // ?>
        </div>

        <div class="row row-3">
            <form id="guess-form" action="game.php" method="POST">
                <input type="text" name="make" placeholder="Make" class="input-make" required
                    oninvalid="this.setCustomValidity('Make is required')" oninput="this.setCustomValidity('')"
                    autocomplete="off">
                <input type=" text" name="model" placeholder="Model" class="input-model" required
                    oninvalid="this.setCustomValidity('Model is required')" oninput="this.setCustomValidity('')"
                    autocomplete="off">
                <input type="hidden" name="car_id" value="<?php echo $_SESSION['car_id']; ?>">
                <button type="submit" id="submit-button">Submit</button>
            </form>
        </div>

    </div>
    <div id="popup-card" style="display: none;">
        <h2 class="gamemode-heading">Select Gamemode</h2>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            id="popup-close-icon">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
        </svg>

        <form id="category-form" action="update_category.php" method="GET">
            <div class="grid-container">
                <label class="popup-card-grid-item">
                    <input type="radio" name="category" value="American" <?php if (isset($_SESSION['category']) && $_SESSION['category'] === 'American')
                        echo 'checked'; ?> class="hidden-radio">
                    <div class="category-content">
                        <h4>American</h4>
                        <p>Brands including Ford and Chevrolet</p>
                    </div>
                </label>
                <label class="popup-card-grid-item">
                    <input type="radio" name="category" value="European" <?php if ($_SESSION['category'] === 'European')
                        echo 'checked'; ?> class="hidden-radio">
                    <h4>European</h4>
                    <p>Brands including BMW and Jaguar</p>
                </label>
                <label class="popup-card-grid-item">
                    <input type="radio" name="category" value="Hypercars" <?php if ($_SESSION['category'] === 'Hypercars')
                        echo 'checked'; ?> class="hidden-radio">
                    <h4>Hypercars</h4>
                    <p>Brands including McLaren and Pagani</p>
                </label>
                <label class="popup-card-grid-item">
                    <input type="radio" name="category" value="Everyday" <?php if ($_SESSION['category'] === 'Everyday')
                        echo 'checked'; ?> class="hidden-radio">
                    <h4>Everyday</h4>
                    <p>Brands including Honda and Chevrolet</p>
                </label>
                <label class="popup-card-grid-item">
                    <input type="radio" name="category" value="Electric" <?php if ($_SESSION['category'] === 'Electric')
                        echo 'checked'; ?> class="hidden-radio">
                    <h4>Electric</h4>
                    <p>Brands including Tesla and Mercedes Benz</p>
                </label>
                <label class="popup-card-grid-item">
                    <input type="radio" name="category" value="Asian" <?php if ($_SESSION['category'] === 'Asian')
                        echo 'checked'; ?> class="hidden-radio">
                    <h4>Asian</h4>
                    <p>Brands including Honda and Toyota</p>
                </label>
            </div>
            <button type="submit" id="start-game-button">Start Game</button>
        </form>
    </div>
    <?php if (isset($_SESSION['game_over']) && $_SESSION['game_over']): ?>
        <div id="game-over-card" style="display: block;">
            <?php
            if (str_contains($_SESSION['result_message'], "correct")) {
                echo "<h3>Congratulations!</h3> 
                <script>
                    var duration = 1.5 * 1000;
                    var animationEnd = Date.now() + duration;
                    var defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 1000 };

                    function randomInRange(min, max) {
                    return Math.random() * (max - min) + min;
                    }

                    var interval = setInterval(function() {
                    var timeLeft = animationEnd - Date.now();

                    if (timeLeft <= 0) {
                        return clearInterval(interval);
                    }

                    var particleCount = 50 * (timeLeft / duration);
                    // since particles fall down, start a bit higher than random
                    confetti({ ...defaults, particleCount, origin: { x: randomInRange(0.1, 0.3), y: Math.random() - 0.2 } });
                    confetti({ ...defaults, particleCount, origin: { x: randomInRange(0.7, 0.9), y: Math.random() - 0.2 } });
                    }, 250);
                </script>";
            } else {
                echo "<h3>Game Over</h3>";
            }
            ?>
            <p>
                <?php
                if (isset($_SESSION['result_message'])) {
                    echo $_SESSION['result_message'];
                    unset($_SESSION['result_message']);
                }
                ?>
            </p>
            <img src="img/<?php echo isset($_SESSION['car_id']) ? $_SESSION['car_id'] . '-5' : 'img1'; ?>.jpg"
                alt="Car Image" id="card-car-image">

            <div class="stats-row">
                <div class="stats-item">
                    <h1 id="total-games"></h1>
                    <p>Unique Cars Guessed</p>
                </div>
                <div class="stats-item">
                    <h1 id="correct-guesses"></h1>
                    <p>Correct Guesses</p>
                </div>
                <div class="stats-item">
                    <h1 id="fastest-guess"></h1>
                    <p>Fastest Correct Guess</p>
                </div>
                <div class="stats-item">
                    <h1 id="avg-attempts"></h1>
                    <p>Average Attempts per Game</p>
                </div>
            </div>
            <button id="play-again-button">Play Again</button>
        </div>
        <div id="overlay" style="display: block;"></div>
        <?php unset($_SESSION['game_over']); ?>
    <?php endif; ?>
    <div id="profile-card" style="display: none;">
        <h2>Profile</h2>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            id="profile-close-icon">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            <p>Welcome
                <?php echo isset($_SESSION['name']) ? $_SESSION['name'] : 'Player'; ?>
            </p>
            <!-- <p>Your user ID:
            <?php echo $_SESSION['user_id']; ?>
        </p> -->
            <form id="name-form" action="update_name.php" method="POST">
                <input type="text" name="name" placeholder="Enter your name" id="update-name-input" autocomplete="off">
                <button type="submit" id="update-name-button">Update Name</button>
            </form>
            <h3>Your Stats</h3>
            <div class="stats-row">
                <div class="stats-item">
                    <h1 id="total-games"></h1>
                    <p>Unique Cars Guessed</p>
                </div>
                <div class="stats-item">
                    <h1 id="correct-guesses"></h1>
                    <p>Correct Guesses</p>
                </div>
                <div class="stats-item">
                    <h1 id="fastest-guess"></h1>
                    <p>Fastest Correct Guess</p>
                </div>
                <div class="stats-item">
                    <h1 id="avg-attempts"></h1>
                    <p>Average Attempts per Game</p>
                </div>
            </div>
            <button onclick="location.href='reset_session.php'" id="reset-session-button">Reset Your Data</button>
    </div>

    <div id="overlay" style="display: none;"></div>
    <script>
        document.querySelectorAll('.row-1 > *').forEach(item => {
            item.addEventListener('click', (event) => {
                event.stopPropagation();
                document.getElementById('popup-card').style.display = 'block';
                document.getElementById('overlay').style.display = 'block';
            });
        });

        document.getElementById('overlay').addEventListener('click', () => {
            document.getElementById('popup-card').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
            document.getElementById('profile-card').style.display = 'none';
            document.getElementById('game-over-card').style.display = 'none';
        });

        document.getElementById('popup-close-icon').addEventListener('click', function () {
            document.getElementById('popup-card').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        });

        document.getElementById('profile-close-icon').addEventListener('click', function () {
            document.getElementById('profile-card').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        });

        var playAgainButton = document.getElementById('play-again-button');
        if (playAgainButton) {
            playAgainButton.addEventListener('click', () => {
                location.href = 'reset_game.php';
            });
        }
        var attempt_number = <?php echo isset($_SESSION['attempt_number']) ? $_SESSION['attempt_number'] : 1; ?>;
        // var circles = document.getElementsByClassName('circle');
        try {
            $('.circle').slice(0, attempt_number).css('background-color', 'darkgray');
        }
        catch (error) {
            console.error(error);
        }

        // try {
        //     for (var i = 0; i < attempt_number; i++) {
        //         circles[i].style.backgroundColor = 'darkgray';
        //     }
        // } catch (error) {
        //    console.error(error);
        // }

        // for (var i = 0; i < attempt_number; i++) {
        //     circles[i].style.backgroundColor = 'darkgray';
        // }
        document.getElementById('profile-icon').addEventListener('click', () => {
            document.getElementById('profile-card').style.display = 'block';
            document.getElementById('overlay').style.display = 'block';

        });

        var gameData = {
            total_games: 0,
            correct_guesses: 0,
            fastest_guess: 0,
            avg_attempts: 0,
            name: ''
        };

        function updateGameData(data) {
            gameData.total_games = data.total_games;
            gameData.correct_guesses = data.correct_guesses;
            gameData.fastest_guess = data.fastest_guess;
            gameData.avg_attempts = parseFloat(data.avg_attempts).toFixed(1);
            gameData.name = data.name;

            // Update the HTML elements with the game data
            document.getElementById('total-games').textContent = gameData.total_games;
            document.getElementById('correct-guesses').textContent = gameData.correct_guesses;
            document.getElementById('fastest-guess').textContent = gameData.fastest_guess + ' attempt' + (gameData.fastest_guess > 1 ? 's' : '');
            document.getElementById('avg-attempts').textContent = gameData.avg_attempts;
            document.getElementById('user-name').textContent = gameData.name;
        }
        var categoryItems = document.querySelectorAll('.popup-card-grid-item');
        categoryItems.forEach(function (item) {
            item.addEventListener('click', function () {
                categoryItems.forEach(function (item) {
                    item.classList.remove('selected');
                });
                this.classList.add('selected');
            });
        });

        // Make an AJAX request to fetch the game data
        fetch('get_game_data.php')
            .then(response => response.json())
            .then(data => {
                updateGameData(data);
            })
            .catch(error => {
                console.error('Error fetching game data:', error);
            });

    </script>
</body>

</html>