<?php
    session_start();

    require 'database.php';

?>

<!DOCTYPE html>
<html>

    <head>
        <title>Confirmation</title>
        <link rel="stylesheet" type="text/css" href="css/app.css"/>
      </head>

    <body>
        <?php include 'header.php'; ?>

        <main>
          <h2>Player Confirmation</h2>
          <p2>Thank you, <?php echo $_SESSION['fullName']; ?>, for saving your player 
          information. We look forward to working with you!</p2>

          <p><a href="add_contact_form.php">Add Another Player</a></p>
          <p><a href="index.php">View Player List</a></p>


        </main>

        <?php include 'footer.php'; ?>


    </body>
</html>