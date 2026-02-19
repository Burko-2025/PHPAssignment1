<?php

    session_start();

    if (!isset($_SESSION['isLoggedIn'])){
        header("Location: login_form.php");
        die();
    }

    require 'database.php';

    $query = 'SELECT typeID, playerType FROM types';
    $statement = $db->prepare($query);
    $statement->execute();
    $types = $statement->fetchAll();
    $statement->closeCursor();
?>

<!DOCTYPE html>
<html>

    <head>
        <title>Add Player</title>
        <link rel="stylesheet" type="text/css" href="css/add_contact.css"/>
      </head>

    <body>
        <?php include 'header.php'; ?>

        <main>
          <h2>Add Contact</h2>
          <form action="add_contact.php" method="post" id="add_contact_form" 
          enctype="multipart/form-data">
            <div id ="data">
              <label for="firstName">First Name:</label>
              <input type="text" id="firstName" name="first_name" required><br>

              <label for="lastName">Last Name:</label>
              <input type="text" id="lastName" name="last_name" required><br>

              <label for="dob">Date of Birth:</label>
              <input type="date" id="dob" name="dob" required><br>

              <label for="team">Team:</label>
              <input type="text" id="team" name="team" required><br>

              <label for="goals">Goals:</label>
              <input type="text" id="goals" name="goals" required><br>

              <label for="assists">Assists:</label>
              <input type="text" id="assists" name="assists" required><br>

              <label for="points">Points:</label>
              <input type="text" id="points" name="points" required><br>

              <label for="gamesPlayed">Games Played:</label>
              <input type="text" id="gamesPlayed" name="games_played" required><br>

              <label>Contact Type:</label>
              <select name="type_id">
                <?php foreach ($types as $type) : ?>
                  <option value="<?php echo $type['typeID']; ?>">
                    <?php echo $type['playerType']; ?>
                  </option>
                <?php endforeach; ?>
              </select><br>

              <label for="image">Upload Image:</label>
              <input type="file" id="image" name="file1"><br>

            </div>

            <div id="buttons">
              <input type="submit" class="save-button" value="Save Contact"><br>
            </div>

          </form>


          <p><a class= "save-button" href="index.php">View Player List</a></p>


        </main>

        <?php include 'footer.php'; ?>


    </body>
</html>