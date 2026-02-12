<?php
    session_start();
    if (!isset($_SESSION['isLoggedIn'])){
        header("Location: login_form.php");
        die();
    }
    require 'database.php';

    // get contact id from form
    $contact_id = filter_input(INPUT_POST, 'contact_id', FILTER_VALIDATE_INT);

    if (!$contact_id){
      header("Location: index.php");
      exit();
    }

    // Fetch the contact details

    $query = 'SELECT p.contactID, p.firstName, p.lastName, p.dob, p.team, p.goals, p.assists, p.points, p.gamesPlayed, p.typeID, p.imageName, t.playerType FROM players p LEFT JOIN types t ON p.typeID = t.typeID 
    WHERE contactID = :contact_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':contact_id', $contact_id);
    $statement->execute();
    $player = $statement->fetch();
    $statement->closeCursor();

    if(!$player){
      echo "Player not found.";
      exit();
     }

     // convert _100 image to _400 for display
     $imageName = $player['imageName'];  // example: photo_100.jpg
     $dotPosition = strrpos($imageName, '.'); //example: position of dot before jpg
     $baseName = substr($imageName, 0, $dotPosition); // example: photo_100 which is the substring before the dot starting at position 0 and up to but not including position 9
     $extension = substr($imageName, $dotPosition); // example: .jpg which is the substring starting at the dot position to the end of the string
     
     if (str_ends_with($baseName, '_100')) {
         $baseName = substr($baseName, 0, -4); // removes last 4 characters (_100)
    }

     $imageName400 = $baseName . '_400' . $extension; // example: photo + _400 +.jpg or photo_400.jpg

?>

<!DOCTYPE html>
<html>

    <head>
        <title>Contact Details</title>
        <link rel="stylesheet" type="text/css" href="css/app.css"/>
      </head>

    <body>
        <?php include 'header.php'; ?>



        <div class = "container">
          <h2>Contact Details</h2>

          <img class="player-image" src="<?php echo htmlspecialchars('./assets/images/' . $imageName400); ?>" 
            alt="<?php echo htmlspecialchars($player['firstName'] . ' ' . $player['lastName']); ?>">
          <div class="player-info">
            <p><strong>First Name:</strong> <?php echo htmlspecialchars($player['firstName']); ?></p>
            <p><strong>Last Name:</strong> <?php echo htmlspecialchars($player['lastName']); ?></p>
            <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($player['dob']); ?></p>
            <p><strong>Team:</strong> <?php echo htmlspecialchars($player['team']); ?></p>
            <p><strong>Goals:</strong> <?php echo htmlspecialchars($player['goals']); ?></p>
            <p><strong>Assists:</strong> <?php echo htmlspecialchars($player['assists']); ?></p>
            <p><strong>Points:</strong> <?php echo htmlspecialchars($player['points']); ?></p>
            <p><strong>Games Played:</strong> <?php echo htmlspecialchars($player['gamesPlayed']); ?></p>
            <p><strong>Player Position:</strong> <?php echo htmlspecialchars($player['playerType']); ?></p>
          </div>

          <p><a class="back-link" href="index.php">Back to Contact List</a></p>


        </div>

        <?php include 'footer.php'; ?>


    </body>
</html>