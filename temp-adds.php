<?php

// $host = "db";
// $port = "5432";
// $database = "example";
// $user = "localuser";
// $password = "cs4640LocalUser!";

// $dbHandle = pg_connect("host=$host port=$port dbname=$database user=$user password=$password");

// if ($dbHandle) {
//     echo "Success connecting to database" . "<br>";
// } else {
//     echo "An error occurred connecting to the database";
// }

// Add a car to the cars table
// $make = "Ford";
// $model = "F-150";
// $year = 2024;
// $category = "American";

// $make = "Ford";
// $model = "Mustang";
// $year = 2024;
// $category = "American";

// $make = "BMW";
// $model = "i3";
// $year = 2024;
// $category = "European";

// $insert_query = "INSERT INTO cars (make, model, year, category) VALUES ('$make', '$model', $year, '$category')";
// $insert_query = "INSERT INTO categories (category_name) VALUES ('American')";
// $insert_result = pg_query($dbHandle, $insert_query);

// if ($insert_result) {
//     echo "Car added successfully";
// } else {
//     echo "Error adding car: " . pg_last_error($dbHandle);
// }


// Get the category_id of the newly inserted category
// $query = "SELECT category_id FROM categories WHERE category_name = 'American'";
// $result = pg_query($dbHandle, $query);
// if (!$result) {
//     echo "Error selecting category_id: " . pg_last_error($dbHandle);
// } else {
//     $row = pg_fetch_assoc($result);
//     $category_id = $row['category_id'];

//     // Select all the car IDs from the cars table where the category is 'American'
//     $query = "SELECT car_id FROM cars WHERE category = 'American'";
//     $result = pg_query($dbHandle, $query);
//     if (!$result) {
//         echo "Error selecting car_ids: " . pg_last_error($dbHandle);
//     } else {
//         $car_ids = [];
//         while ($row = pg_fetch_assoc($result)) {
//             $car_ids[] = $row['car_id'];
//         }

//         // Update the car_ids array in the categories table for the 'American' category
//         $query = "UPDATE categories SET car_ids = ARRAY[" . implode(',', $car_ids) . "] WHERE category_id = $category_id";
//         $result = pg_query($dbHandle, $query);
//         if (!$result) {
//             echo "Error updating car_ids: " . pg_last_error($dbHandle);
//         }
//     }
// }

// Select all distinct categories from the cars table
// $query = "SELECT DISTINCT category FROM cars";
// $result = pg_query($dbHandle, $query);
// if (!$result) {
//     echo "Error selecting categories: " . pg_last_error($dbHandle);
// } else {
//     while ($row = pg_fetch_assoc($result)) {
//         $category = $row['category'];

//         // Insert a new category into the categories table
//         $query = "INSERT INTO categories (category_name) VALUES ('$category')";
//         $resultInsert = pg_query($dbHandle, $query);
//         if (!$resultInsert) {
//             echo "Error inserting category: " . pg_last_error($dbHandle);
//         }

//         // Get the category_id of the newly inserted category
//         $query = "SELECT category_id FROM categories WHERE category_name = '$category'";
//         $resultId = pg_query($dbHandle, $query);
//         if (!$resultId) {
//             echo "Error selecting category_id: " . pg_last_error($dbHandle);
//         } else {
//             $rowId = pg_fetch_assoc($resultId);
//             $category_id = $rowId['category_id'];

//             // Select all the car IDs from the cars table where the category matches
//             $query = "SELECT car_id FROM cars WHERE category = '$category'";
//             $resultCarIds = pg_query($dbHandle, $query);
//             if (!$resultCarIds) {
//                 echo "Error selecting car_ids: " . pg_last_error($dbHandle);
//             } else {
//                 $car_ids = [];
//                 while ($rowCarIds = pg_fetch_assoc($resultCarIds)) {
//                     $car_ids[] = $rowCarIds['car_id'];
//                 }

//                 // Update the car_ids array in the categories table for the current category
//                 $query = "UPDATE categories SET car_ids = ARRAY[" . implode(',', $car_ids) . "] WHERE category_id = $category_id";
//                 $resultUpdate = pg_query($dbHandle, $query);
//                 if (!$resultUpdate) {
//                     echo "Error updating car_ids: " . pg_last_error($dbHandle);
//                 }
//             }
//         }
//     }
// }