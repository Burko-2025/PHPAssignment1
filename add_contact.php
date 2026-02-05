<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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
    $type_id = filter_input(INPUT_POST, 'type_id', FILTER_VALIDATE_INT);
    $image = $_FILES['file1'];

    require 'database.php';
    require 'image_util.php';

    $base_dir = 'assets/images/';

    //check for duplicate entries
    $queryPlayers = 'SELECT firstName, lastName, dob, team, goals, assists, points, gamesPlayed, imageName
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




    if ($first_name == null || $last_name == null || $team == null || $goals == null || 
        $assists == null || $points == null || $games_played == null || $type_id == null) {
        $error = "Invalid contact data. Check all fields and try again.";
        $_SESSION['error'] = $error;
        header("Location: error.php");
        exit();
    }
    else{

        $image_name = ''; //default to empty string
        if ($image && $image['error'] == UPLOAD_ERR_OK) {
            // Process the uploaded image
            $original_filename = basename($image['name']);
            $upload_path = $base_dir . $original_filename;
            $image_type = exif_imagetype($image['tmp_name']);

            if ($image_type === IMAGETYPE_JPEG || 
                $image_type === IMAGETYPE_GIF || 
                $image_type === IMAGETYPE_PNG) {
                move_uploaded_file($image['tmp_name'], $upload_path);
                process_image($base_dir, $original_filename);
            } else {
                $_SESSION['error'] = 'File must be a JPEG, GIF, or PNG image.';
                header("Location: error.php");
                die();
            }


            // save _100 version filename to database
            $dot_pos=strpos($original_filename, '.');
            $name_100=substr($original_filename, 0, $dot_pos) . '_100' . 
                substr($original_filename, $dot_pos);
            $image_name = $name_100;
        }
        else {
            // use placeholder
            $placeholder = 'placeholder.jpg';
            $placeholder_100 = 'placeholder_100.jpg';
            $placeholder_400 = 'placeholder_400.jpg';

            if (!file_exists($base_dir . $placeholder_100) || !file_exists
                ($base_dir . $placeholder_400)) {
                process_image($base_dir, $placeholder);
            }
            $image_name = $placeholder_100;
        }

        // Add the new player to the database
        $queryAddPlayer = 'INSERT INTO players
                            (firstName, lastName, dob, team, goals, assists, points, gamesPlayed, imageName, typeID)
                            VALUES
                            (:first_name, :last_name, :dob, :team, :goals, :assists, :points, :games_played, :image_name, :type_id)';
        $statement = $db->prepare($queryAddPlayer);
        $statement->bindValue(':first_name', $first_name);
        $statement->bindValue(':last_name', $last_name);
        $statement->bindValue(':dob', $dob);
        $statement->bindValue(':team', $team);
        $statement->bindValue(':goals', $goals);
        $statement->bindValue(':assists', $assists);
        $statement->bindValue(':points', $points);
        $statement->bindValue(':games_played', $games_played);
        $statement->bindValue(':image_name', $image_name);
        $statement->bindValue(':type_id', $type_id);
        $statement->execute();
        $statement->closeCursor();

        $_SESSION['fullName'] = $first_name . " " . $last_name;

        // Redirect to a confirmation page
        header("Location: confirmation.php");
        die();
    }
    

?>