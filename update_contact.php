<?php
    session_start();

    $contact_id = filter_input(INPUT_POST, 'contact_id', FILTER_VALIDATE_INT);

    $first_name = filter_input(INPUT_POST, 'first_name');
    $last_name = filter_input(INPUT_POST, 'last_name');
    $team = filter_input(INPUT_POST, 'team');
    $dob = filter_input(INPUT_POST, 'dob');
    $goals = filter_input(INPUT_POST, 'goals');
    $assists = filter_input(INPUT_POST, 'assists');
    $points = filter_input(INPUT_POST, 'points');
    $games_played = filter_input(INPUT_POST, 'games_played');

    require 'database.php';

    //check for duplicate entries
    $queryContacts = 'SELECT contactID, firstName, lastName, dob, team, goals, assists, points, 
        gamesPlayed FROM players';
    $statement = $db->prepare($queryContacts);
    $statement->execute();
    $players = $statement->fetchAll();
    $statement->closeCursor();
    foreach ($players as $player) {
        if ($player['firstName'] == $first_name && $player['lastName'] == $last_name 
            && $contact_id != $player['contactID']) {
            $_SESSION['error'] = "A player with this name already exists. Try again.";
            header("Location: error.php");
            exit();
        }
    }

    if ($first_name == null || $last_name == null || $dob == null || 
        $team == null || $goals == null || $assists == null || $points == null 
          || $games_played == null) {
        $error = "Invalid contact data. Check all fields and try again.";
        $_SESSION['error'] = $error;
        header("Location: error.php");
        exit();
    }
    else{
            // update contact in the database
    $queryupdateContact = 'UPDATE players
                         SET firstName = :first_name,
                             lastName = :last_name,
                             dob = :dob,
                             team = :team,
                             goals = :goals,
                             assists = :assists,
                             points = :points,
                             gamesPlayed = :games_played
                         WHERE contactID = :contact_id';
    $statement = $db->prepare($queryupdateContact);
    $statement->bindValue(':first_name', $first_name);
    $statement->bindValue(':last_name', $last_name);
    $statement->bindValue(':dob', $dob);
    $statement->bindValue(':team', $team);
    $statement->bindValue(':goals', $goals);
    $statement->bindValue(':assists', $assists);
    $statement->bindValue(':points', $points);
    $statement->bindValue(':games_played', $games_played);
    $statement->bindValue(':contact_id', $contact_id);
    $statement->execute();
    $statement->closeCursor();

    $_SESSION['fullName'] = $first_name . " " . $last_name;

    // Redirect to a confirmation page
    header("Location: update_confirmation.php");
    die();
    }
    

?>