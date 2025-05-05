<?php
// Inizialize session FIRST
session_start();

// Then include files (ensure they don't output anything)
include("database.php");
$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

// Check if user is logged in (if user was assigned a session that macthes their credentials)
if(!isset($_SESSION['user_id']) || !isset($_SESSION['username']) || !isset($_SESSION['logged_in']) || !isset($_SESSION['roles'])) {
    header("Location: index.php");//if not GTFO
    exit();
}

// HEADER NAV
include("nav-head.php");
?>