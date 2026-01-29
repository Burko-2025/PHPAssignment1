<?php
    session_start();

    require 'database.php';
    // get data from form
    $contact_id = filter_input(INPUT_POST, 'contact_id', FILTER_VALIDATE_INT);

    //code to delete contact from database
    //validate contact_id
    if ($contact_id !== false) {

        $queryDeleteContact = 'DELETE FROM players WHERE contactID = :contact_id';
        $statement = $db->prepare($queryDeleteContact);
        $statement->bindValue(':contact_id', $contact_id);
        $statement->execute();
        $statement->closeCursor();
        
    }

    header("Location: index.php");
    exit();
?>