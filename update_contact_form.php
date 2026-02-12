<?php
    session_start();
    if (!isset($_SESSION['isLoggedIn'])){
        header("Location: login_form.php");
        die();
    }

    require 'database.php';

    // get data from form
    $contact_id = filter_input(INPUT_POST, 'contact_id', FILTER_VALIDATE_INT);
    $queryPlayers = 'SELECT contactID, firstName, lastName, dob, team, goals, assists, points, 
        gamesPlayed, typeId, imageName FROM players WHERE contactID = :contact_id';
    $statement = $db->prepare($queryPlayers);
    $statement->bindValue(':contact_id', $contact_id);
    $statement->execute();
    $player = $statement->fetch();
    $statement->closeCursor();

    // Get the contact types
    $query = 'SELECT typeID, playerType FROM types';
    $statement = $db->prepare($query);
    $statement->execute();
    $types = $statement->fetchAll();
    $statement->closeCursor();
?>

<!DOCTYPE html>
<html>

    <head>
        <title>Update Player</title>
        <link rel="stylesheet" type="text/css" href="css/add_contact.css"/>
      </head>

    <body>
        <?php include 'header.php'; ?>

        <main>
          <h2>Update Player</h2>
          <form action="update_contact.php" method="post" id="update_contact_form" 
              enctype="multipart/form-data">
          <input type="hidden" name="contact_id" 
                value="<?php echo ($player['contactID']); ?>">
            <div id ="data">
              <label for="firstName">First Name:</label>
              <input type="text" id="firstName" name="first_name" required 
                  value="<?php echo htmlspecialchars($player['firstName']); ?>"><br>

              <label for="lastName">Last Name:</label>
              <input type="text" id="lastName" name="last_name" required 
                  value="<?php echo htmlspecialchars($player['lastName']); ?>"><br>

              <label for="dob">Date of Birth:</label>
              <input type="date" id="dob" name="dob" required 
                  value="<?php echo htmlspecialchars($player['dob']); ?>"><br>

              <label for="team">Team:</label>
              <input type="text" id="team" name="team" required 
                  value="<?php echo htmlspecialchars($player['team']); ?>"><br>

              <label for="goals">Goals:</label>
              <input type="text" id="goals" name="goals" required 
                  value="<?php echo htmlspecialchars($player['goals']); ?>"><br>

              <label for="assists">Assists:</label>
              <input type="text" id="assists" name="assists" required 
                  value="<?php echo htmlspecialchars($player['assists']); ?>"><br>

              <label for="points">Points:</label>
              <input type="text" id="points" name="points" required 
                  value="<?php echo htmlspecialchars($player['points']); ?>"><br>

              <label for="gamesPlayed">Games Played:</label>
              <input type="text" id="gamesPlayed" name="games_played" required 
                  value="<?php echo htmlspecialchars($player['gamesPlayed']); ?>"><br>

              <label>Contact Type:</label>
              <select name="type_id">
                <?php foreach ($types as $type) : ?>
                  <option value="<?php echo $type['typeID']; ?>" <?php
                    if ($type['typeID'] == $player['typeID']) echo 'selected';
                  ?>>
                    <?php echo $type['playerType']; ?>
                  </option>
                <?php endforeach; ?>
              </select><br>

              <?php if (!empty($player['imageName'])): ?>
                  <label>Current Image:</label>
                  <img src="assets/images/<?php echo htmlspecialchars($player['imageName']); ?>" height="100"><br /> 
              <?php endif; ?>

              <label for="image">Update Image:</label>
              <input type="file" id="image" name="file1"><br>

            </div>

            <div id="buttons" class="updatePlayer-button">
              <input type="submit" value="Update Player"><br>
            </div>

          </form>


          <p><a href="index.php">View Player List</a></p>


        </main>

        <?php include 'footer.php'; ?>


    </body>
</html>