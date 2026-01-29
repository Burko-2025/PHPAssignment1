<?php
    session_start();

    $contact_id = filter_input(INPUT_POST, 'contact_id', FILTER_VALIDATE_INT);

    $first_name = filter_input(INPUT_POST, 'first_name');
    $last_name = filter_input(INPUT_POST, 'last_name');
    $dob = filter_input(INPUT_POST, 'dob');
    $team = filter_input(INPUT_POST, 'team');
    $goals = filter_input(INPUT_POST, 'goals');
    $assists = filter_input(INPUT_POST, 'assists');
    $points = filter_input(INPUT_POST, 'points');
    $games_played = filter_input(INPUT_POST, 'games_played');

    require 'database.php';

    //check for duplicate entries
    $queryPlayers = 'SELECT firstName, lastName, dob, team, goals, assists, points, gamesPlayed 
        FROM players';
    $statement = $db->prepare($queryPlayers);
    $statement->execute();
    $players = $statement->fetchAll();
    $statement->closeCursor();
    foreach ($players as $player) {
        if ($player['firstName'] == $first_name && $player['lastName'] == $last_name) {
            $_SESSION['error'] = "A player with this name already exists.";
            header("Location: error.php");
            exit();
        }
    }



    if ($first_name == null || $last_name == null || $team == null || 
        $goals == null || $assists == null || $points == null || $games_played == null) {
        $error = "Invalid contact data. Check all fields and try again.";
        $_SESSION['error'] = $error;
        header("Location: error.php");
        exit();
    }
    else{
        // Add the new player to the database
        $queryAddPlayer = 'INSERT INTO players
                            (firstName, lastName, dob, team, goals, assists, points, gamesPlayed)
                            VALUES
                            (:first_name, :last_name, :dob, :team, :goals, :assists, :points, :games_played)';
        $statement = $db->prepare($queryAddPlayer);
        $statement->bindValue(':first_name', $first_name);
        $statement->bindValue(':last_name', $last_name);
        $statement->bindValue(':dob', $dob);
        $statement->bindValue(':team', $team);
        $statement->bindValue(':goals', $goals);
        $statement->bindValue(':assists', $assists);
        $statement->bindValue(':points', $points);
        $statement->bindValue(':games_played', $games_played);
        $statement->execute();
        $statement->closeCursor();

        $_SESSION['fullName'] = $first_name . " " . $last_name;

        // Redirect to a confirmation page
        header("Location: confirmation.php");
        die();
    }
    

?>