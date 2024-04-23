<?php
include 'postgres.php';
include 'session.php';

session_start();

if (isset($_POST['make']) && isset($_POST['model']) && isset($_POST['car_id'])) {
    $guessed_make = $_POST['make'];
    $guessed_model = $_POST['model'];
    $car_id = $_POST['car_id']; // use hidden input to pass car_id

    // Retrieve the correct make and model for the car
    $query = "SELECT make, model FROM cars WHERE car_id = $1";
    $result = pg_query_params($db_connection, $query, [$car_id]);
    $car = pg_fetch_assoc($result);

    function compareStrings($str1, $str2)
    {
        // Regex to remove dashes and spaces
        $str1 = preg_replace('/[-\s]/', '', $str1);
        $str2 = preg_replace('/[-\s]/', '', $str2);

        return strcasecmp($str1, $str2) == 0;
    }

    if ($car) {
        $correct_make = $car['make'];
        $correct_model = $car['model'];

        $makeComparison = compareStrings($guessed_make, $correct_make);
        $modelComparison = compareStrings($guessed_model, $correct_model);

        if ($_SESSION['attempt_number'] > 5) {
            $_SESSION['result_message'] = "You have reached the maximum number of attempts.";
            header("Location: index.php");
            exit();
        }

        // Check if the guess is correct
        if ($makeComparison && $modelComparison) {
            // Guess is correct
            $guess_result = true;
            $message = "Your guess is correct! The car is a $correct_make $correct_model.";
            $_SESSION['game_over'] = true;

        } else {
            // Guess is incorrect
            $guess_result = false;
            if ($_SESSION['attempt_number'] == 5) {
                $message = "Game over! You have reached the maximum number of attempts. The car is a $correct_make $correct_model.";
                $_SESSION['attempt_number']++;

            } else {
                $message = "Incorrect, try again!";
                $_SESSION['attempt_number']++;

            }
        }

        if ($_SESSION['attempt_number'] > 5) {
            if ($guess_result) {
                $_SESSION['game_over_message'] = "Congratulations, your guess is correct! The car is a $correct_make $correct_model.";
            } else {
                $_SESSION['game_over_message'] = "Game over! You have reached the maximum number of attempts.";
            }
            $_SESSION['game_over'] = true;
        }
        // Store the guess result in the database
        $user_id = $_SESSION['user_id'];
        $attempt_number = $_SESSION['attempt_number'];
        $query = "INSERT INTO guesses (user_id, car_id, guess_result, attempt_number) VALUES ($1, $2, $3, $4)";
        pg_query_params($db_connection, $query, [$user_id, $car_id, $guess_result, $attempt_number]);

        // Store the result message in a session variable
        $_SESSION['result_message'] = $message;
    } else {
        $_SESSION['result_message'] = "Invalid car ID.";
    }
} else {
    $_SESSION['result_message'] = "Please provide a make and model.";
}

header("Location: index.php");
exit();