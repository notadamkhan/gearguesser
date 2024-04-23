<?php
include 'session.php';

$_SESSION['attempt_number'] = 1;

header("Location: update_category.php");
exit();