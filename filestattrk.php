<?php
// Initialize session FIRST
session_start();

// Then include files (ensure they don't output anything)
include("database.php");
$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

if (!isset($_SESSION['user_id']) || 
    !isset($_SESSION['username']) || 
    !isset($_SESSION['logged_in']) || 
    !isset($_SESSION['role']) || 
    $_SESSION['logged_in'] !== true) {
    
    // Destroy invalid session
    session_unset();
    session_destroy();
    
    // Redirect to login and echo error
    header("Location: index.php?error=session_invalid");
    exit();
}

// HEADER NAV
include('Component/nav-head.php');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>File Tax Return</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/Dashboard.css">
    <link rel="stylesheet" href="css/TopNav.css">
    <script src="js/Dashboard.js" async defer></script>
    <style>
        #sidebar ul li.activestattrk a {
            color: var(--accent-clr);
            background-color: var(--hover-clr);
        }

        .status-container {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
            margin: 10px 0;
        }

        .status-title {
            font-size: 1.5em;
            margin-bottom: 10px;
        }

        .status-item {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 3px;
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <main>
        <section>
            <div id="Nav-container">
                <h1>JMCYK Client Management System</h1>
            </div>
        </section>
        
        <div class="container">
            <h1>File Status Tracker</h1>
        </div>
        <br>
                
        <div class="status-title">Not Yet Started</div>
        <hr><br><br>
        
        <div class="status-title">On-Going</div>
        <hr><br><br>

        <div class="status-title">Finished</div>
        <hr><br><br>

    </main>
</body>
</html>
