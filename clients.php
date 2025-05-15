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

// Initialize search results
$searchResults = [];
$searchError = '';

// Handle search request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
    $searchQuery = mysqli_real_escape_string($conn, $_POST['search_query']);
    
    // Query to search for clients
    $sql = "SELECT * FROM clients WHERE client_name LIKE '%$searchQuery%' OR client_email LIKE '%$searchQuery%'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $searchResults[] = $row; // Store each result in the array
        }
    } else {
        $searchError = "Client doesn't exist.";
    }
}
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
        <link rel="stylesheet" href="css/Clients.css"> <!-- Link to your CSS file -->
        <script src="js/Dashboard.js" async defer></script>
        <style>
            #sidebar ul li.activeclients a {
                color: var(--accent-clr);
                background-color: var(--hover-clr);
            }
            .clients-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 1em;
                width: 100%;
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
                <div class="clients-header">
                    <h1 id="Clients">Clients</h1>
                    <form method="POST" action="" class="search-box">
                        <input type="text" name="search_query" id="search-input" placeholder="Search for clients..." required>
                        <button type="submit" id="search-button" name="search">Search</button>
                    </form>
                </div>
                <?php if ($searchError): ?>
                    <p style="color: red;"><?php echo $searchError; ?></p>
                <?php endif; ?>
                <?php if (!empty($searchResults)): ?>
                    <div id="search-results">
                        <ul>
                            <?php foreach ($searchResults as $client): ?>
                                <li><?php echo htmlspecialchars($client['client_name']) . ' - ' . htmlspecialchars($client['client_email']); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>

            <div class="container">
                <h1>Receipt List</h1><br>
                <p>List is empty....</p>
            </div>
        </main> 
    </body>
</html>
