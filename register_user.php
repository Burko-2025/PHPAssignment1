<?php

    session_start();



    $user_name = filter_input(INPUT_POST, 'user_name');
    $user_password = filter_input(INPUT_POST, 'password');
    //encrypt password using password_hash function
    $hash= password_hash($user_password, PASSWORD_DEFAULT);

    $email_address = filter_input(INPUT_POST, 'email_address');



    require 'database.php';
    require 'message.php';

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


        // set up email variables
        $to_address = $email_address;
        $to_name = $user_name;
        $from_address = 'YOUR_USERNAME@gmail.com';
        $from_name = 'Contact Manager 2026';
        $subject = 'Contact Manager 2026 - Registration Complete';
        $body = '<p>Thanks for registering with our site.</p>' .
            '<p>Sincerely,</p>' .
            '<p>Contact Manager 2026</p>';
        $is_body_html = true;

        

        // Send email
        try {
            send_mail($to_address, $to_name, $from_address, $from_name, $subject, $body, $is_body_html);        
        }
        catch (Exception $ex) {
            $_SESSION['error'] = $ex->getMessage();
            header("Location: error.php");
            die();
        }


        // Redirect to a confirmation page
        header("Location: register_confirmation.php");
        die();
    }
    

?>