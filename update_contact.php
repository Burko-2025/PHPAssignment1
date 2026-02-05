<?php
    session_start();

    require 'database.php';
    require 'image_util.php';

    $contact_id = filter_input(INPUT_POST, 'contact_id', FILTER_VALIDATE_INT);

    $first_name = filter_input(INPUT_POST, 'first_name');
    $last_name = filter_input(INPUT_POST, 'last_name');
    $team = filter_input(INPUT_POST, 'team');
    $dob = filter_input(INPUT_POST, 'dob');
    $goals = filter_input(INPUT_POST, 'goals');
    $assists = filter_input(INPUT_POST, 'assists');
    $points = filter_input(INPUT_POST, 'points');
    $games_played = filter_input(INPUT_POST, 'games_played');
    $type_id = filter_input(INPUT_POST, 'type_id', FILTER_VALIDATE_INT);
    $image = $_FILES['file1'];

    //get current contact record to check current image name
    $queryPlayers = 'SELECT contactID, firstName, lastName, dob, team, goals, assists, points, 
      gamesPlayed, typeID, imageName FROM players WHERE contactID = :contact_id';
    $statement = $db->prepare($queryPlayers);
    $statement->bindValue(':contact_id', $contact_id);
    $statement->execute();
    $player= $statement->fetch();
    $statement->closeCursor();
    $old_image_name= $player['imageName'];
    $base_dir= 'assets/images/';
    $image_name= $old_image_name;

    //check for duplicate entries
    $queryPlayers = 'SELECT contactID, firstName, lastName, dob, team, goals, assists, points, 
        gamesPlayed FROM players';
    $statement = $db->prepare($queryPlayers);
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
            $dot_pos=strrpos($original_filename, '.');
            $new_image_name=substr($original_filename, 0, $dot_pos) . '_100' . 
                substr($original_filename, $dot_pos);
            $image_name = $new_image_name;

            if($old_image_name != 'placeholder_100.jpg') {
              $old_base = substr($old_image_name, 0, strrpos($old_image_name, '_100'));
              $old_ext = substr($old_image_name,strrpos($old_image_name, '.'));
              $original = $old_base . $old_ext;
              $img100 = $old_base . '_100' . $old_ext;
              $img400 = $old_base . '_400' . $old_ext;

              foreach([$original, $img100, $img400] as $file) {
                  $path = $base_dir . $file;
                  if(file_exists($path)) {
                      unlink($path);
                  }
             }
          }
        }
            // update player in the database
      $queryupdatePlayer = 'UPDATE players
                          SET firstName = :first_name,
                              lastName = :last_name,
                              dob = :dob,
                              team = :team,
                              goals = :goals,
                              assists = :assists,
                              points = :points,
                              gamesPlayed = :games_played,
                              typeID = :type_id,
                              imageName = :image_name

                          WHERE contactID = :contact_id';
      $statement = $db->prepare($queryupdatePlayer);
      $statement->bindValue(':first_name', $first_name);
      $statement->bindValue(':last_name', $last_name);
      $statement->bindValue(':dob', $dob);
      $statement->bindValue(':team', $team);
      $statement->bindValue(':goals', $goals);
      $statement->bindValue(':assists', $assists);
      $statement->bindValue(':points', $points);
      $statement->bindValue(':games_played', $games_played);
      $statement->bindValue(':type_id', $type_id);
      $statement->bindValue(':image_name', $image_name);
      $statement->bindValue(':contact_id', $contact_id);
      $statement->execute();
      $statement->closeCursor();

      $_SESSION['fullName'] = $first_name . " " . $last_name;

      // Redirect to a confirmation page
      header("Location: update_confirmation.php");
      die();
    }
    

?>