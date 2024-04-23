<?php

$host = "db";
$port = "5432";
$database = "example";
$user = "localuser";
$password = "cs4640LocalUser!";
echo "postgres.php";
// error_reporting(E_ALL);
// ini_set("display_errors", 1);


$dbHandle = pg_connect("host=$host port=$port dbname=$database user=$user password=$password");

if ($dbHandle) {
    echo "Success connecting to database" . "<br>";
} else {
    echo "An error occurred connecting to the database";
}

$table_queries = [
    "CREATE TABLE IF NOT EXISTS users (
        user_id VARCHAR(255) PRIMARY KEY,
        name VARCHAR(100),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",

    "CREATE TABLE IF NOT EXISTS cars (
        car_id SERIAL PRIMARY KEY,
        make VARCHAR(100) NOT NULL,
        model VARCHAR(100) NOT NULL,
        year INT,
        category VARCHAR(100),
        image_path VARCHAR(255)
    )",

    "CREATE TABLE IF NOT EXISTS guesses (
        guess_id SERIAL PRIMARY KEY,
        user_id VARCHAR(255) REFERENCES users(user_id),
        car_id INT REFERENCES cars(car_id),
        guess_result BOOLEAN,
        attempt_number INT,
        timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",

    "CREATE TABLE IF NOT EXISTS categories (
        category_id SERIAL PRIMARY KEY,
        category_name VARCHAR(100) NOT NULL,
        car_ids INT[]
    )"

    // "CREATE TABLE IF NOT EXISTS challenges (
    //     challenge_id SERIAL PRIMARY KEY,
    //     car_id INT REFERENCES cars(car_id),
    //     start_date DATE,
    //     end_date DATE
    // )"

];

foreach ($table_queries as $query) {
    $result = pg_query($dbHandle, $query);
    if (!$result) {
        echo "Error creating table: " . pg_last_error($dbHandle);
    } else {
        echo "Tables created successfully" . "<br>";
    }
}

// $query = "
// CREATE TABLE users (
//     user_id SERIAL PRIMARY KEY,
//     username VARCHAR(100) NOT NULL,
//     password VARCHAR(100) NOT NULL
// )";
// $result = pg_query($dbHandle, $query);

// if ($result) {
//     echo "users table created successfully";
// } else {
//     echo "An error occurred while creating the users table";
// }