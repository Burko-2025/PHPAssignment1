<?php
    session_start();
    if (!isset($_SESSION['isLoggedIn'])){
        header("Location: login_form.php");
        die();
    }

    // Unset all of the session variables.
    $_SESSION = []; //clears all the sessions data

    // clean up the session ID.
    session_destroy();

    // Redirect to the login page
    header("Location: login_form.php");
    die();
?>