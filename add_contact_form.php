<?php
    session_start();

    require 'database.php';

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


            </div>

            <div id="buttons">
              <input type="submit" value="Save Contact"><br>
            </div>

          </form>


          <p><a href="index.php">View Player List</a></p>


        </main>

        <?php include 'footer.php'; ?>


    </body>
</html>