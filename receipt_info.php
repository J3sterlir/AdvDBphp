<?php
// Initialize session FIRST
session_start();

// Include files (ensure they don't output anything)
include("database.php");
$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

// Check session validity
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
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Input Receipt Information</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="css/Dashboard.css">
    <link rel="stylesheet" href="css/TopNav.css">
    <link rel="stylesheet" href="css/Forms.css">
    <link rel="stylesheet" href="css/receipt_info.css">
    
    <script src="js/receipt_info.js" async defer></script>
    <script src="js/Dashboard.js" async defer></script>

    <style>
        #sidebar ul li.activefiletax a {
            color: var(--accent-clr);
            background-color: var(--hover-clr);
        }

        #sidebar ul li.activefiletax a svg {
            fill: var(--accent-clr);
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
            <h1>Input Receipt Information</h1>
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

        <div class="container">
            <h2>Receipt Summarizer</h2><br>
            <hr /><br>
            <label for="frequency-select">Select Frequency:</label>
            <br><br>
            <select id="frequency-select" name="frequency-select">
                <option value="">--Select--</option>
                <option value="monthly">Monthly</option>
                <option value="quarterly">Quarterly</option>
                <option value="annually">Annually</option>
            </select>

            <div id="date-range-container" class="hidden">
                <div class="date-range-group">
                    <label for="from-date">From:</label>
                    <input type="date" id="from-date" name="from-date" />
                </div>
                <div class="date-range-group">
                    <label for="to-date">To:</label>
                    <input type="date" id="to-date" name="to-date" />
                </div>
            </div>

            <div id="year-container" class="hidden">
                <label for="year-select">Select Year:</label>
                <select id="year-select" name="year-select">
                    <option value="">--Select Year--</option>
                    <?php
                    $currentYear = (int)date("Y");
                    for ($y = $currentYear; $y >= $currentYear - 10; $y--) {
                        echo "<option value=\"$y\">$y</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
    </main>
</body>
</html>
