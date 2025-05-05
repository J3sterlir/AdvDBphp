<?php
// Inizialize session FIRST
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
        <title>Employee Home</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/Dashboard.css">
        <link rel="stylesheet" href="css/TopNav.css">
        <script src="js/Dashboard.js" async defer></script>
        <style>
            #sidebar ul li.activeabout a{
                color: var(--accent-clr);
                background-color: var(--hover-clr);
                
                svg{
                    fill: var(--accent-clr);
                    
                }
            }
        </style>
    </head>
    <body>
        
    </body>

    <main>
            <section>
                <div id="Nav-container">
                    <h1>JMCYK Client Management System</h1>
                </div>
            </section>

            <div class="container">
                <h1>About</h1><br>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsum assumenda error obcaecati dolores quis asperiores at nesciunt, veritatis similique quia veniam architecto rem necessitatibus labore blanditiis debitis incidunt soluta? Vel.</p>
            </div>

            <div class="container">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsum assumenda error obcaecati dolores quis asperiores at nesciunt, veritatis similique quia veniam architecto rem necessitatibus labore blanditiis debitis incidunt soluta? Vel.</p>
            </div>

            
            <div class="container">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsum assumenda error obcaecati dolores quis asperiores at nesciunt, veritatis similique quia veniam architecto rem necessitatibus labore blanditiis debitis incidunt soluta? Vel.</p>
            </div>

            
            <div class="container">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsum assumenda error obcaecati dolores quis asperiores at nesciunt, veritatis similique quia veniam architecto rem necessitatibus labore blanditiis debitis incidunt soluta? Vel.</p>
            </div>

            
            <div class="container">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsum assumenda error obcaecati dolores quis asperiores at nesciunt, veritatis similique quia veniam architecto rem necessitatibus labore blanditiis debitis incidunt soluta? Vel.</p>
            </div>
    </main> 
</html>