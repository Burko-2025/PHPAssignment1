<?php
    session_start();

    require 'database.php';
    // get data from form
    $contact_id = filter_input(INPUT_POST, 'contact_id', FILTER_VALIDATE_INT);

    //get current contact record to check current image name
    $queryPlayers = 'SELECT contactID, firstName, lastName, dob, team, goals, assists, points, 
        gamesPlayed, imageName FROM players WHERE contactID = :contact_id';
    $statement = $db->prepare($queryPlayers);
    $statement->bindValue(':contact_id', $contact_id);
    $statement->execute();
    $player = $statement->fetch();
    $statement->closeCursor();
    $old_image_name = $player['imageName'];
    $base_dir = 'assets/images/';

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

    //code to delete contact from database
    //validate contact_id
    if ($contact_id !== false) {

        $queryDeletePlayer = 'DELETE FROM players WHERE contactID = :contact_id';
        $statement = $db->prepare($queryDeletePlayer);
        $statement->bindValue(':contact_id', $contact_id);
        $statement->execute();
        $statement->closeCursor();
        
    }

    header("Location: index.php");
    exit();
?>