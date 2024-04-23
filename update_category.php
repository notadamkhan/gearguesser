<?php
include 'session.php';

if (isset($_GET['category'])) { // using get for assignment reqs
    $selected_category = $_GET['category'];
    $_SESSION['category'] = $selected_category;

    // Retrieve a random car ID from the selected category
    $query = "SELECT * FROM cars WHERE category = $1 ORDER BY RANDOM() LIMIT 1";
    $result = pg_query_params($db_connection, $query, [$selected_category]);
    $car = pg_fetch_assoc($result);

    if ($car) {
        $random_car_id = $car['car_id'];
        $_SESSION['car_id'] = $random_car_id;
        $_SESSION['attempt_number'] = 1;
    }
} else {
    $selected_category = "American";
    $_SESSION['category'] = $selected_category;

    // Retrieve a random car ID from the selected category
    $query = "SELECT * FROM cars WHERE category = $1 ORDER BY RANDOM() LIMIT 1";
    $result = pg_query_params($db_connection, $query, [$selected_category]);
    $car = pg_fetch_assoc($result);

    if ($car) {
        $random_car_id = $car['car_id'];
        $_SESSION['car_id'] = $random_car_id;
        $_SESSION['attempt_number'] = 1;
    }
}

header("Location: index.php");
exit();