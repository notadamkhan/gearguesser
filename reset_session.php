<?php
include 'session.php';

// Destroy the session.
session_destroy();
header("Location: index.php");
exit;