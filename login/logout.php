<?php
    session_start();
    // Remove 
    session_unset(); 
    session_destroy(); 
    $_SESSION['loggedin'] == false;
    $_SESSION = array();

    // Redirect to login page
    header("Location: login.php");
    
?>