<?php 

if (isset($_POST['logout'])) {
    // Call your logout function here
    logout();

    // Redirect to the login page or another page after logout
    header("Location: login.php");
    exit();
}

function logout() {
    // Destroy the session and any other cleanup
    session_start();
    session_destroy();
    // Additional cleanup if needed
}


?>
