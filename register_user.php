<?php

    session_start();



    $user_name = filter_input(INPUT_POST, 'user_name');
    $user_password = filter_input(INPUT_POST, 'password');
    //encrypt password using password_hash function
    $hash= password_hash($user_password, PASSWORD_DEFAULT);

    $email_address = filter_input(INPUT_POST, 'email_address');



    require 'database.php';

    //check for duplicate entries
    $queryUsers = 'SELECT userName, password, emailAddress FROM registrations';
    $statement = $db->prepare($queryUsers);
    $statement->execute();
    $users = $statement->fetchAll();
    $statement->closeCursor();
    foreach ($users as $user) {
        if ($user['userName'] == $user_name) {
            $_SESSION['error'] = "A user with this username already exists.";
            header("Location: error.php");
            exit();
        }
    }



    if ($user_name == null || $user_password == null || $hash == null || $email_address == null) {
        $error = "Invalid registration data. Check all fields and try again.";
        $_SESSION['error'] = $error;
        header("Location: error.php");
        exit();
    }
    else{
        // Add the new user to the database
        $queryAddUser = 'INSERT INTO registrations
                            (userName, password, emailAddress)
                            VALUES
                            (:user_name, :password, :email_address)';
        $statement = $db->prepare($queryAddUser);
        $statement->bindValue(':user_name', $user_name);
        $statement->bindValue(':password', $hash);
        $statement->bindValue(':email_address', $email_address);
        $statement->execute();
        $statement->closeCursor();
        $_SESSION['isLoggedIn'] = true;
        $_SESSION['userName'] = $user_name;


        // Redirect to a confirmation page
        header("Location: register_confirmation.php");
        die();
    }
    

?>