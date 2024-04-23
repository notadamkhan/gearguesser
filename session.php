<?php
session_start();
$host = "db";
$port = "5432";
$database = "example";
$user = "localuser";
$password = "cs4640LocalUser!";
// echo "session.php";
// error_reporting(E_ALL);
// ini_set("display_errors", 1);

$db_connection = pg_connect("host=$host port=$port dbname=$database user=$user password=$password");


if (!isset($_SESSION['user_id'])) {
    // Generate a unique user ID and store it in the session
    $user_id = uniqid();
    $_SESSION['user_id'] = $user_id;

    // Insert a new user session into the users table
    $query = "INSERT INTO users (user_id) VALUES ($1)";
    pg_query_params($db_connection, $query, [$user_id]);
}