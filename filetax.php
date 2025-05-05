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
        <title>File Tax Return</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/Dashboard.css">
        <link rel="stylesheet" href="css/TopNav.css">
        <link rel="stylesheet" href="css/Forms.css">
        <script src="js/Dashboard.js" async defer></script>
        <script src="js/forms.js" async defer></script>
        <style>
            #sidebar ul li.activefiletax a{
                color: var(--accent-clr);
                background-color: var(--hover-clr);
                
                svg{
                    fill: var(--accent-clr);
                    
                }
            }
        </style>
    </head>
    
    <body>
        <main>
                <section class="section1">
                    <div id="Nav-container">
                        <h1>JMCYK Client Management System</h1>
                    </div>
                </section>
                <div class="container">
                    <h1>Receipt Summarizer</h1>
                </div>

                <div class="container">
                    <form action="#">
                        <div class="form first">
                            <div class="details personal">
                                <span class="title">Receipt Details</span>
                                <hr><br>
                                <div class="fields">
                                    <div class="input-field">
                                        <label>Client Name</label>
                                        <input type="text" placeholder="Enter client name" required>
                                    </div>
                                    
                                    <div class="input-field">
                                        <label>Reference Number</label>
                                        <input type="text" placeholder="Enter PK reference number" required>
                                    </div>
                                    
                                    <div class="input-field">
                                        <label>Type of VAT</label>
                                        <select required>
                                            <option disabled selected>Select VAT type</option>
                                            <option>VAT</option>
                                            <option>NON VAT</option>
                                        </select>
                                    </div>
                                    
                                    <div class="input-field">
                                        <label>Date</label>
                                        <input type="date" placeholder="Enter tax return date" required>
                                    </div>
                                    
                                    <div class="input-field">
                                        <label>Total Amount</label>
                                        <input type="number" step="0.01" placeholder="Enter total amount" required>
                                    </div>
                                </div>
                            </div>
                            
                            <button class="submit">
                                <span class="btnText">Submit Tax Return</span>
                                <i class="uil uil-navigator"></i>
                            </button>
                        </div>
                    </form>
                </div>
        </main>
    </body>
        
</html>
