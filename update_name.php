<?php
include 'session.php';

if (isset($_POST['name'])) {
    $name = $_POST['name'];
    $_SESSION['name'] = $name;

    // Update the user's name in the database
    $user_id = $_SESSION['user_id'];
    $query = "UPDATE users SET name = $1 WHERE user_id = $2";
    pg_query_params($db_connection, $query, [$name, $user_id]);
}

header("Location: index.php");
exit();