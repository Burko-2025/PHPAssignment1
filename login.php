<?php
    session_start();
    date_default_timezone_set('America/Toronto');

    require 'database.php';

    $user_name = filter_input(INPUT_POST, 'user_name');
    $user_password = filter_input(INPUT_POST, 'password');
    

    //check for duplicate userName
    $queryUsers = 'SELECT userID, userName, password, emailAddress, failed_attempts, last_failed_login FROM registrations WHERE userName = :user_name';
    $statement = $db->prepare($queryUsers);
    $statement->bindValue(':user_name', $user_name);
    $statement->execute();
    $user = $statement->fetch();
    $statement->closeCursor();

    if ($user) {
        $now = new DateTime(); // Get current time
        $last_failed = new DateTime($user['last_failed_login']);// Get last failed login time from database
        $interval = $now->getTimestamp() - $last_failed->getTimestamp();// Calculate time difference in seconds

        if($user['failed_attempts'] >= 3 && $interval < 60) { // If there have been 3 or more failed attempts and it's been less than 5 minutes
            $remaining = 60 - $interval; // Calculate remaining lockout time
            $_SESSION['login_error'] = "Account locked due to too many failed login attempts. Please try again after " . ceil($remaining) . " seconds.";
            header("Location: login_form.php");
            exit();
        }
        if (password_verify($user_password, $user['password'])) {
            // Password is correct, set session variables
            $_SESSION['isLoggedIn'] = true;

            $query = "UPDATE registrations
                      SET failed_attempts = 0, last_failed_login = NULL
                      WHERE userName = :user_name";
            $statement = $db->prepare($query);
            $statement->bindValue(':user_name', $user['userName']);
            $statement->execute();
            $statement->closeCursor();

            $_SESSION['userName'] = $user['userName'];
            $_SESSION['user_id'] = $user['userID'];
            header("Location: login_confirmation.php");
            exit();
        } else {
            // Password is incorrect, increment failed_attempts and update last_failed_login
            $query = "UPDATE registrations
                      SET failed_attempts = failed_attempts + 1, last_failed_login = now()
                      WHERE userName = :user_name";
            $statement = $db->prepare($query);
            $statement->bindValue(':user_name', $user['userName']);
            $statement->execute();
            $statement->closeCursor();

            $_SESSION['login_error'] = "Invalid password.";
            header("Location: login_form.php");
            exit();
        }
    }
    else {
        $_SESSION['login_error'] = "No user found with that username.";
        header("Location: login_form.php");
        exit();
    }
?>