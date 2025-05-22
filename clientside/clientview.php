<?php
include("database.php");
$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
session_start();


// Check if user is logged in (if user was assigned a session that macthes their credentials)
if(!isset($_SESSION['user_id']) || !isset($_SESSION['username']) || !isset($_SESSION['logged_in']) || !isset($_SESSION['roles'])) {
    header("Location: index.php"); //if not GTFO
    exit();
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Client View</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        
        <!-- Display user information -->
        <div class="user-info">
            <p>User ID: <?php echo $_SESSION['user_id']; ?></p>
            <p>Username: <?php echo htmlspecialchars($_SESSION['username']); ?></p>
            <p>Last login: <?php echo date('Y-m-d H:i:s'); ?></p>
        </div>
        
        <!-- Logout form -->
        <form action="clientview.php" method="post">
            <input type="submit" name="logout" value="Logout">
        </form>
        
    </body>

    
</html>

<?php
        if(isset($_POST["logout"])){
            // Clear session data
            $_SESSION = array();
            
            // Delete session cookie
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
                );
            }
            
            
            session_destroy(); //End Current Session
            
            
            header("Location: index.php"); //back to login
            exit();
        }
?>