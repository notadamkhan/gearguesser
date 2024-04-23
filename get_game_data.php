<?php
include 'session.php';

function getGameData($db_connection, $user_id)
{
    // Total number of games
    $query = "SELECT COUNT(DISTINCT car_id) AS total_games FROM guesses WHERE user_id = $1";
    $result = pg_query_params($db_connection, $query, [$user_id]);
    $total_games = pg_fetch_assoc($result)['total_games'];

    // Number of correct guesses
    $query = "SELECT COUNT(*) AS correct_guesses FROM guesses WHERE user_id = $1 AND guess_result = true";
    $result = pg_query_params($db_connection, $query, [$user_id]);
    $correct_guesses = pg_fetch_assoc($result)['correct_guesses'];

    // Average number of attempts per game
    $query = "SELECT AVG(attempt_number) AS avg_attempts FROM (SELECT MAX(attempt_number) AS attempt_number FROM guesses WHERE user_id = $1 GROUP BY car_id) AS subquery";
    $result = pg_query_params($db_connection, $query, [$user_id]);
    $avg_attempts = pg_fetch_assoc($result)['avg_attempts'];

    // Fastest correct guess (minimum number of attempts)
    $query = "SELECT MIN(attempt_number) AS fastest_guess FROM guesses WHERE user_id = $1 AND guess_result = true";
    $result = pg_query_params($db_connection, $query, [$user_id]);
    $fastest_guess = pg_fetch_assoc($result)['fastest_guess'];

    // Retrieve the user's name
    $query = "SELECT name FROM users WHERE user_id = $1";
    $result = pg_query_params($db_connection, $query, [$user_id]);
    $user = pg_fetch_assoc($result);
    $name = $user['name'] ?? '';

    return [
        'total_games' => $total_games,
        'correct_guesses' => $correct_guesses,
        'avg_attempts' => $avg_attempts,
        'fastest_guess' => $fastest_guess,
        'name' => $name

    ];
}

$data = getGameData($db_connection, $_SESSION['user_id']);

header('Content-Type: application/json');
echo json_encode($data); // using JSON for assign reqs
exit();